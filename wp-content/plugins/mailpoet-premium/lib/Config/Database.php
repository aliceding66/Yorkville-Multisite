<?php
namespace MailPoet\Premium\Config;

use MailPoet\Config\Env as ParentEnv;

if(!defined('ABSPATH')) exit;

class Database {
  function init() {
    $this->defineTables();
  }

  function defineTables() {
    if(!defined('MP_NEWSLETTER_EXTRA_DATA_TABLE')) {
      $newsletter_extra_data = ParentEnv::$db_prefix . 'premium_newsletter_extra_data';
      $dynamic_segment_filters = ParentEnv::$db_prefix . 'dynamic_segment_filters';

      define('MP_NEWSLETTER_EXTRA_DATA_TABLE', $newsletter_extra_data);
      define('MP_DYNAMIC_SEGMENTS_FILTERS_TABLE', $dynamic_segment_filters);
    }
  }
}
