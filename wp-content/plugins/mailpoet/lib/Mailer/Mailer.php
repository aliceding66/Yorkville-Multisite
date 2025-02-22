<?php
namespace MailPoet\Mailer;

use MailPoet\Models\Setting;

if(!defined('ABSPATH')) exit;
require_once(ABSPATH . 'wp-includes/pluggable.php');

class Mailer {
  public $mailer_config;
  public $sender;
  public $reply_to;
  public $return_path;
  public $mailer_instance;
  const MAILER_CONFIG_SETTING_NAME = 'mta';
  const SENDING_LIMIT_INTERVAL_MULTIPLIER = 60;
  const METHOD_MAILPOET = 'MailPoet';
  const METHOD_AMAZONSES = 'AmazonSES';
  const METHOD_SENDGRID = 'SendGrid';
  const METHOD_PHPMAIL = 'PHPMail';
  const METHOD_SMTP = 'SMTP';

  function __construct($mailer = false, $sender = false, $reply_to = false, $return_path = false) {
    $this->mailer_config = self::getMailerConfig($mailer);
    $this->sender = $this->getSenderNameAndAddress($sender);
    $this->reply_to = $this->getReplyToNameAndAddress($reply_to);
    $this->return_path = $this->getReturnPathAddress($return_path);
    $this->mailer_instance = $this->buildMailer();
  }

  function send($newsletter, $subscriber, $extra_params = array()) {
    $subscriber = $this->formatSubscriberNameAndEmailAddress($subscriber);
    return $this->mailer_instance->send($newsletter, $subscriber, $extra_params);
  }

  function buildMailer() {
    switch($this->mailer_config['method']) {
      case self::METHOD_AMAZONSES:
        $mailer_instance = new $this->mailer_config['class'](
          $this->mailer_config['region'],
          $this->mailer_config['access_key'],
          $this->mailer_config['secret_key'],
          $this->sender,
          $this->reply_to,
          $this->return_path
        );
        break;
      case self::METHOD_MAILPOET:
        $mailer_instance = new $this->mailer_config['class'](
          $this->mailer_config['mailpoet_api_key'],
          $this->sender,
          $this->reply_to
        );
        break;
      case self::METHOD_SENDGRID:
        $mailer_instance = new $this->mailer_config['class'](
          $this->mailer_config['api_key'],
          $this->sender,
          $this->reply_to
        );
        break;
      case self::METHOD_PHPMAIL:
        $mailer_instance = new $this->mailer_config['class'](
          $this->sender,
          $this->reply_to,
          $this->return_path
        );
        break;
      case self::METHOD_SMTP:
        $mailer_instance = new $this->mailer_config['class'](
          $this->mailer_config['host'],
          $this->mailer_config['port'],
          $this->mailer_config['authentication'],
          $this->mailer_config['login'],
          $this->mailer_config['password'],
          $this->mailer_config['encryption'],
          $this->sender,
          $this->reply_to,
          $this->return_path
        );
        break;
      default:
        throw new \Exception(__('Mailing method does not exist.', 'mailpoet'));
    }
    return $mailer_instance;
  }

  static function getMailerConfig($mailer = false) {
    if(!$mailer) {
      $mailer = Setting::getValue(self::MAILER_CONFIG_SETTING_NAME);
      if(!$mailer || !isset($mailer['method'])) throw new \Exception(__('Mailer is not configured.', 'mailpoet'));
    }
    if(empty($mailer['frequency'])) {
      $default_settings = Setting::getDefaults();
      $mailer['frequency'] = $default_settings['mta']['frequency'];
    }
    // add additional variables to the mailer object
    $mailer['class'] = 'MailPoet\\Mailer\\Methods\\' . $mailer['method'];
    $mailer['frequency_interval'] =
      (int)$mailer['frequency']['interval'] * self::SENDING_LIMIT_INTERVAL_MULTIPLIER;
    $mailer['frequency_limit'] = (int)$mailer['frequency']['emails'];
    return $mailer;
  }

  function getSenderNameAndAddress($sender = false) {
    if(empty($sender)) {
      $sender = Setting::getValue('sender', array());
      if(empty($sender['address'])) throw new \Exception(__('Sender name and email are not configured.', 'mailpoet'));
    }
    $from_name = $this->encodeAddressNamePart($sender['name']);
    return array(
      'from_name' => $from_name,
      'from_email' => $sender['address'],
      'from_name_email' => sprintf('%s <%s>', $from_name, $sender['address'])
    );
  }

  function getReplyToNameAndAddress($reply_to = array()) {
    if(!$reply_to) {
      $reply_to = Setting::getValue('reply_to');
      $reply_to['name'] = (!empty($reply_to['name'])) ?
        $reply_to['name'] :
        $this->sender['from_name'];
      $reply_to['address'] = (!empty($reply_to['address'])) ?
        $reply_to['address'] :
        $this->sender['from_email'];
    }
    if(empty($reply_to['address'])) {
      $reply_to['address'] = $this->sender['from_email'];
    }
    $reply_to_name = $this->encodeAddressNamePart($reply_to['name']);
    return array(
      'reply_to_name' => $reply_to_name,
      'reply_to_email' => $reply_to['address'],
      'reply_to_name_email' => sprintf('%s <%s>', $reply_to_name, $reply_to['address'])
    );
  }

  function getReturnPathAddress($return_path) {
    return ($return_path) ?
      $return_path :
      Setting::getValue('bounce.address');
  }

  function formatSubscriberNameAndEmailAddress($subscriber) {
    $subscriber = (is_object($subscriber)) ? $subscriber->asArray() : $subscriber;
    if(!is_array($subscriber)) return $subscriber;
    if(isset($subscriber['address'])) $subscriber['email'] = $subscriber['address'];
    $first_name = (isset($subscriber['first_name'])) ? $subscriber['first_name'] : '';
    $last_name = (isset($subscriber['last_name'])) ? $subscriber['last_name'] : '';
    if(!$first_name && !$last_name) return $subscriber['email'];
    $full_name = sprintf('%s %s', $first_name, $last_name);
    $full_name = trim(preg_replace('!\s\s+!', ' ', $full_name));
    $full_name = $this->encodeAddressNamePart($full_name);
    $subscriber = sprintf(
      '%s <%s>',
      $full_name,
      $subscriber['email']
    );
    return $subscriber;
  }

  function encodeAddressNamePart($name) {
    if(mb_detect_encoding($name) === 'ASCII') return $name;
    // encode non-ASCII string as per RFC 2047 (https://www.ietf.org/rfc/rfc2047.txt)
    return sprintf('=?utf-8?B?%s?=', base64_encode($name));
  }

  static function formatMailerConnectionErrorResult($error_message) {
    return array(
      'response' => false,
      'operation' => 'connect',
      'error_message' => $error_message
    );
  }

  static function formatMailerSendErrorResult($error_message) {
    return array(
      'response' => false,
      'operation' => 'send',
      'error_message' => $error_message
    );
  }

  static function formatMailerSendSuccessResult() {
    return array(
      'response' => true
    );
  }
}
