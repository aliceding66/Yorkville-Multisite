<?php

namespace MailPoet\Premium\Config;

use MailPoet\Config\AccessControl;
use MailPoet\Models\Setting;
use MailPoet\Premium\DynamicSegments\SegmentStringsFilter;
use MailPoet\Premium\Models\NewsletterExtraData;
use MailPoet\Premium\Newsletter\GATracking;
use MailPoet\WP\Hooks;
use MailPoet\Premium\Config\Hooks as ConfigHooks;

if(!defined('ABSPATH')) exit;

class Initializer {

  /** @var Menu */
  private $menu;

  function __construct($params = array(
    'file' => '',
    'version' => '1.0.0'
  )) {
    Env::init($params['file'], $params['version']);
  }

  function init() {
    register_activation_hook(
      Env::$file,
      array('MailPoet\Premium\Config\Activator', 'activate')
    );

    Hooks::addAction('mailpoet_initialized', array(
      $this,
      'setup'
    ));
  }

  function setup() {
    $this->setupLocalizer();
    $this->setupDB();
    $this->maybeDbUpdate();
    $this->setupRenderer();
    $this->setupMenu();

    Hooks::addAction(
      'mailpoet_styles_admin_after',
      array($this, 'includePremiumStyles')
    );

    Hooks::addAction(
      'mailpoet_scripts_admin_before',
      array($this, 'includePremiumJavascript')
    );

    $this->setupNewsletterExtraData();
    $this->setupGATracking();
    $this->setupCampaignStats();

    Hooks::addAction(
      'mailpoet_setup_reset',
      array('MailPoet\Premium\Config\Activator', 'reset')
    );

    $this->setupHooks();

  }

  function maybeDbUpdate() {
    try {
      $current_db_version = Setting::getValue('premium_db_version');
    } catch(\Exception $e) {
      $current_db_version = null;
    }

    // if current db version and plugin version differ
    if(version_compare($current_db_version, Env::$version) !== 0) {
      Activator::activate();
    }
  }

  function setupDB() {
    $database = new Database();
    $database->init();
  }

  function setupRenderer() {
    $caching = !WP_DEBUG;
    $debugging = WP_DEBUG;
    $this->renderer = new Renderer($caching, $debugging);
  }
  
  function setupLocalizer() {
    $localizer = new Localizer();
    $localizer->init();
  }

  function setupMenu() {
    $caching = !WP_DEBUG;
    $debugging = WP_DEBUG;
    $access_control = new AccessControl();
    $renderer = new \MailPoet\Config\Renderer($caching, $debugging);
    $this->menu = new Menu(
      $this->renderer,
      $access_control,
      new \MailPoet\Config\Menu($renderer, Env::$assets_url, $access_control)
    );

    Hooks::addAction(
      'mailpoet_menu_after_lists',
      array($this->menu, 'afterLists')
    );
  }

  function setupNewsletterExtraData() {
    NewsletterExtraData::init();
  }

  function setupGATracking() {
    GATracking::init();

    Hooks::addAction(
      'mailpoet_newsletters_translations_after',
      array($this, 'newslettersGATracking')
    );
  }

  function setupCampaignStats() {
    Hooks::addAction(
      'mailpoet_newsletters_translations_after',
      array($this, 'newslettersCampaignStats')
    );
  }

  function newslettersGATracking() {
    echo $this->renderer->render('newsletters/ga_tracking.html');
  }

  function newslettersCampaignStats() {
    // shortcode URLs to substitute with user-friendly names
    $data['shortcode_links'] = array(
      '[link:subscription_unsubscribe_url]' => __('Unsubscribe link', 'mailpoet-premium'),
      '[link:subscription_manage_url]' => __('Manage subscription link', 'mailpoet-premium'),
      '[link:newsletter_view_in_browser_url]' => __('View in browser link', 'mailpoet-premium'),
    );

    echo $this->renderer->render('newsletters/campaign_stats.html', $data);
  }

  function includePremiumStyles() {
    echo $this->renderer->render('styles.html');
  }

  function includePremiumJavascript() {
    echo $this->renderer->render('scripts.html');
  }

  function setupHooks() {
    $hooks = new ConfigHooks();
    $hooks->init();
  }

}
