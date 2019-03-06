<?php
namespace MailPoet\Premium\Models;

use MailPoet\Models\Model;
use MailPoet\WP\Hooks;

if(!defined('ABSPATH')) exit;

class NewsletterExtraData extends Model {
  public static $_table = MP_NEWSLETTER_EXTRA_DATA_TABLE;

  // form fields to be managed by this model
  public static $premium_field_names = array('ga_campaign');
  public static $premium_fields_holder;

  static function init() {
    Hooks::addFilter(
      'mailpoet_api_newsletters_save_before',
      array(__CLASS__, 'extractFields')
    );

    Hooks::addAction(
      'mailpoet_api_newsletters_save_after',
      array(__CLASS__, 'saveFields')
    );

    Hooks::addFilter(
      'mailpoet_api_newsletters_get_after',
      array(__CLASS__, 'getFields')
    );

    Hooks::addAction(
      'mailpoet_api_newsletters_duplicate_after',
      array(__CLASS__, 'duplicateFields'),
      10,
      2
    );
  }

  static function extractFields($data) {
    $result = array();
    foreach(self::$premium_field_names as $field) {
      if(isset($data[$field])) {
        $result[$field] = $data[$field];
        unset($data[$field]);
      }
    }
    self::$premium_fields_holder = $result;
    return $data;
  }

  static function saveFields($newsletter, $data = null) {
    $data = $data ?: self::$premium_fields_holder;
    $data['newsletter_id'] = $newsletter->id;
    $model = self::where('newsletter_id', $newsletter->id)->findOne();
    if($model === false) {
      $model = self::create();
      $model->hydrate($data);
    } else {
      $model->set($data);
    }
    $model->save();
    return $model;
  }

  static function getFields($newsletter) {
    if(is_object($newsletter)) {
      $newsletter = $newsletter->asArray();
    } elseif(!is_array($newsletter)) {
      $newsletter = array('id' => (int)$newsletter);
    }
    $fields = self::where('newsletter_id', $newsletter['id'])->findOne();
    if(empty($fields)) {
      return $newsletter;
    }
    $filtered_fields = array_intersect_key(
      $fields->asArray(),
      array_flip(self::$premium_field_names)
    );
    return array_merge($newsletter, $filtered_fields);
  }

  static function duplicateFields($newsletter, $duplicate) {
    $fields = self::getFields($newsletter);
    self::extractFields($fields);
    return self::saveFields($duplicate);
  }
}
