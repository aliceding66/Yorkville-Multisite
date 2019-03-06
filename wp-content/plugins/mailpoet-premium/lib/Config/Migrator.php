<?php
namespace MailPoet\Premium\Config;
use MailPoet\Config\Env as ParentEnv;
use MailPoet\Util\Helpers;

if(!defined('ABSPATH')) exit;

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

class Migrator {
  function __construct() {
    $this->prefix = ParentEnv::$db_prefix;
    $this->charset = ParentEnv::$db_charset_collate;
    $this->models = array(
      'premium_newsletter_extra_data',
      'dynamic_segment_filters',
    );
  }

  function up() {
    global $wpdb;

    $_this = $this;
    $migrate = function($model) use($_this) {
      $modelMethod = Helpers::underscoreToCamelCase($model);
      dbDelta($_this->$modelMethod());
    };

    array_map($migrate, $this->models);
  }

  function down() {
    global $wpdb;

    $_this = $this;
    $drop_table = function($model) use($wpdb, $_this) {
      $table = $_this->prefix . $model;
      $wpdb->query("DROP TABLE {$table}");
    };

    array_map($drop_table, $this->models);
  }

  function premiumNewsletterExtraData() {
    $attributes = array(
      'id int(11) unsigned NOT NULL AUTO_INCREMENT,',
      'newsletter_id int(11) unsigned NOT NULL,',
      'ga_campaign varchar(250) NOT NULL DEFAULT "",',
      'created_at TIMESTAMP NULL,',
      'updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,',
      'PRIMARY KEY  (id),',
      'UNIQUE KEY newsletter_id (newsletter_id)'
    );
    return $this->sqlify(__FUNCTION__, $attributes);
  }

  function dynamicSegmentFilters() {
    $attributes = array(
      'id int(11) unsigned NOT NULL AUTO_INCREMENT,',
      'segment_id int(11) unsigned NOT NULL,',
      'created_at TIMESTAMP NULL,',
      'updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,',
      'filter_data LONGBLOB,',
      'PRIMARY KEY (id),',
      'KEY segment_id (segment_id)',
    );
    return $this->sqlify(__FUNCTION__, $attributes);
  }

  private function sqlify($model, $attributes) {
    $table = $this->prefix . Helpers::camelCaseToUnderscore($model);

    $sql = array();
    $sql[] = "CREATE TABLE " . $table . " (";
    $sql = array_merge($sql, $attributes);
    $sql[] = ") " . $this->charset . ";";

    return implode("\n", $sql);
  }
}
