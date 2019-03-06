<?php
namespace MailPoet\Premium\Newsletter;

use MailPoet\Models\Newsletter;
use MailPoet\Newsletter\Links\Links as NewsletterLinks;
use MailPoet\Util\Helpers;
use MailPoet\WP\Hooks;
use MailPoet\Premium\Models\NewsletterExtraData;

class GATracking {
  static function init() {
    Hooks::addFilter(
      'mailpoet_sending_newsletter_render_after',
      array(__CLASS__, 'applyGATracking'),
      10,
      2
    );
  }

  static function applyGATracking($rendered_newsletter, $newsletter, $internal_host = null) {
    if($newsletter instanceof Newsletter && $newsletter->type == Newsletter::TYPE_NOTIFICATION_HISTORY) {
      $parent_newsletter = $newsletter->parent()->findOne();
      $fields = NewsletterExtraData::getFields($parent_newsletter);
    } else {
      $fields = NewsletterExtraData::getFields($newsletter);
    }
    if(!empty($fields['ga_campaign'])) {
      list($rendered_newsletter, $links) =
        self::addGAParamsToLinks($rendered_newsletter, $fields['ga_campaign'], $internal_host);
    }
    return $rendered_newsletter;
  }

  static function addGAParamsToLinks($rendered_newsletter, $ga_campaign, $internal_host = null) {
    // join HTML and TEXT rendered body into a text string
    $content = Helpers::joinObject($rendered_newsletter);
    $extracted_links = NewsletterLinks::extract($content);
    $processed_links = self::addParams($extracted_links, $ga_campaign, $internal_host);
    list($content, $links) = NewsletterLinks::replace($content, $processed_links);
    // split the processed body with hashed links back to HTML and TEXT
    list($rendered_newsletter['html'], $rendered_newsletter['text'])
      = Helpers::splitObject($content);
    return array(
      $rendered_newsletter,
      $links
    );
  }

  static function addParams($extracted_links, $ga_campaign, $internal_host = null) {
    $processed_links = array();
    $params = array(
      'utm_source' => 'mailpoet',
      'utm_medium' => 'email',
      'utm_campaign' => urlencode($ga_campaign)
    );
    $internal_host = $internal_host ?: parse_url(home_url(), PHP_URL_HOST);
    foreach($extracted_links as $extracted_link) {
      if($extracted_link['type'] !== NewsletterLinks::LINK_TYPE_URL) {
        continue;
      } elseif(strpos(parse_url($extracted_link['link'], PHP_URL_HOST), $internal_host) === false) {
        // Process only internal links (i.e. pointing to current site)
        continue;
      }
      $processed_link = add_query_arg($params, $extracted_link['link']);
      $link = $extracted_link['link'];
      $processed_links[$link] = array(
        'type' => $extracted_link['type'],
        'link' => $link,
        'processed_link' => $processed_link
      );
    }
    return $processed_links;
  }
}
