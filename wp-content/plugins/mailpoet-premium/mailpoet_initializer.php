<?php

use MailPoet\Config\ServicesChecker;
use MailPoet\Premium\Config\Initializer;
use MailPoet\Util\Helpers;

if(!defined('ABSPATH') || empty($mailpoet_premium)) exit;

require_once($mailpoet_premium['autoloader']);

define('MAILPOET_PREMIUM_VERSION', $mailpoet_premium['version']);
define('MAILPOET_VERSION_REQUIRED', $mailpoet_premium['free_version_required']);
define('MAILPOET_PREMIUM_LICENSE', true);

if(is_plugin_active(plugin_basename($mailpoet_premium['filename']))) {
  // This is to ensure MailPoet is loaded before we proceed
  $GLOBALS['mailpoet_premium'] = $mailpoet_premium;
  // Free 'plugins_loaded' hook is set with a default priority of 10, we need to run before it.
  // It is halfway between 0 and 10 so there's a place for hooks before and after.
  add_action('plugins_loaded', 'mailpoet_premium_init', 5);
} else {
  // Activation, MailPoet should been already loaded
  mailpoet_premium_init($mailpoet_premium);
}

function mailpoet_premium_init($mailpoet_premium = null) {
  $mailpoet_premium = $mailpoet_premium ?: $GLOBALS['mailpoet_premium'];

  if(mailpoet_premium_check_mailpoet_version()) {
    $initializer = new Initializer(
      array(
        'file' => $mailpoet_premium['filename'],
        'version' => $mailpoet_premium['version']
      )
    );
    $initializer->init();
  }
}

// Check for a required MailPoet free version
function mailpoet_premium_check_mailpoet_version() {
  $free_minor_version = false;
  if(defined('MAILPOET_VERSION')) {
    // Get the minor version or fall back to using the version as is
    preg_match('/^3\.\d+/', MAILPOET_VERSION, $match);
    $free_minor_version = !empty($match[0]) ? $match[0] : MAILPOET_VERSION;
  }
  if(!$free_minor_version
    || version_compare($free_minor_version, MAILPOET_VERSION_REQUIRED) < 0
  ) {
    add_action('admin_notices', 'mailpoet_premium_free_version_required_notice');
    return false;
  } elseif(version_compare($free_minor_version, MAILPOET_VERSION_REQUIRED) > 0) {
    add_action('admin_notices', 'mailpoet_premium_upgrade_required_notice');
    return false;
  }

  return true;
}

// Display MailPoet free version error notice
function mailpoet_premium_free_version_required_notice() {
  $notice = sprintf(
    __('You need to have MailPoet version %s or higher activated before using this version of MailPoet Premium.', 'mailpoet-premium'),
    MAILPOET_VERSION_REQUIRED
  );
  printf('<div class="error"><p>%1$s</p></div>', $notice);
}

// Display MailPoet Premium upgrade error notice
function mailpoet_premium_upgrade_required_notice() {
  $checker = new ServicesChecker();
  $is_key_valid = $checker->isPremiumKeyValid($show_notices = false);
  if($is_key_valid) {
    $notice = __('You have an older version of the Premium plugin. The features have been disabled in order not to break MailPoet. Please update it in the Plugins page now.', 'mailpoet-premium');
  } else {
    $notice = __('Your MailPoet Premium plugin is incompatible with the free MailPoet plugin. [link1]Register[/link1] your key or [link2]purchase one now[/link2] to update the Premium to the latest version.', 'mailpoet');
    $notice = Helpers::replaceLinkTags($notice, 'admin.php?page=mailpoet-settings#premium', array(), 'link1');
    $notice = Helpers::replaceLinkTags($notice, 'admin.php?page=mailpoet-premium', array(), 'link2');
  }

  printf('<div class="error"><p>%1$s</p></div>', $notice);
}
