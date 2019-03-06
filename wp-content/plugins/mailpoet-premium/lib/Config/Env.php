<?php
namespace MailPoet\Premium\Config;

use MailPoet\Config\Env as ParentEnv;

if(!defined('ABSPATH')) exit;

class Env {
  static $version;
  static $plugin_name;
  static $file;
  static $path;
  static $views_path;
  static $assets_path;
  static $assets_url;
  static $temp_path;
  static $cache_path;
  static $languages_path;
  static $lib_path;

  static function init($file, $version) {
    self::$version = $version;
    self::$file = $file;
    self::$path = dirname(self::$file);
    self::$plugin_name = 'mailpoet-premium';
    self::$views_path = self::$path.'/views';
    self::$assets_path = self::$path.'/assets';
    self::$assets_url = plugins_url('/assets', $file);
    // Use MailPoet Free's upload dir to prevent it from being altered
    // due to late Premium initialization, just replace the plugin name at the end
    self::$temp_path = preg_replace('/'. ParentEnv::$plugin_name . '$/', self::$plugin_name, ParentEnv::$temp_path);
    self::$cache_path = self::$temp_path.'/cache';
    self::$languages_path = self::$path.'/lang';
    self::$lib_path = self::$path.'/lib';
  }
}
