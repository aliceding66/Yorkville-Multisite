<?php
if(!defined('ABSPATH')) exit;

/*
 * Plugin Name: MailPoet 3 Premium (New)
 * Version: 3.0.16
 * Plugin URI: http://www.mailpoet.com
 * Description: This plugin adds Premium features to the free version of MailPoet and unlocks the limit of 2000 subscribers. Enjoy!
 * Author: MailPoet
 * Author URI: http://www.mailpoet.com
 * Requires at least: 4.6
 * Tested up to: 4.8
 *
 * Text Domain: mailpoet-premium
 * Domain Path: /lang/
 *
 * @package WordPress
 * @author MailPoet
 * @since 3.0.0
 */

$mailpoet_premium = array(
  'version' => '3.0.16',
  'free_version_required' => '3.6', // minor version
  'filename' => __FILE__,
  'path' => dirname(__FILE__),
  'autoloader' => dirname(__FILE__) . '/vendor/autoload.php',
  'initializer' => dirname(__FILE__) . '/mailpoet_initializer.php'
);

require_once(ABSPATH . 'wp-admin/includes/plugin.php');

function mailpoet_premium_deactivate_plugin() {
  deactivate_plugins(plugin_basename(__FILE__));
  if(!empty($_GET['activate'])) {
    unset($_GET['activate']);
  }
}

// Check for minimum supported PHP version
if(version_compare(phpversion(), '5.3.3', '<')) {
  add_action('admin_notices', 'mailpoet_premium_php_version_notice');
  // deactivate the plugin
  add_action('admin_init', 'mailpoet_premium_deactivate_plugin');
  return;
}

// Display PHP version error notice
function mailpoet_premium_php_version_notice() {
  $notice = str_replace(
    '[link]',
    '<a href="//beta.docs.mailpoet.com/article/152-minimum-requirements-for-mailpoet-3#php_version" target="_blank">',
    __('MailPoet Premium plugin requires PHP version 5.3.3 or newer. Please read our [link]instructions[/link] on how to resolve this issue.', 'mailpoet-premium')
  );
  $notice = str_replace('[/link]', '</a>', $notice);
  printf('<div class="error"><p>%1$s</p></div>', $notice);
}

// Check for presence of core dependencies
if(!file_exists($mailpoet_premium['autoloader']) || !file_exists($mailpoet_premium['initializer'])) {
  add_action('admin_notices', 'mailpoet_premium_core_dependency_notice');
  // deactivate the plugin
  add_action('admin_init', 'mailpoet_premium_deactivate_plugin');
  return;
}

// Display missing core dependencies error notice
function mailpoet_premium_core_dependency_notice() {
  $notice = __('MailPoet Premium cannot start because it is missing core files. Please reinstall the plugin.', 'mailpoet-premium');
  printf('<div class="error"><p>%1$s</p></div>', $notice);
}

// Initialize plugin
require_once($mailpoet_premium['initializer']);
