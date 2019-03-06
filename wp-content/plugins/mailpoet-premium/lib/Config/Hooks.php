<?php

namespace MailPoet\Premium\Config;

use MailPoet\Config\ServicesChecker;
use MailPoet\Premium\DynamicSegments\FreePluginConnectors\AddToNewslettersSegments;
use MailPoet\Premium\DynamicSegments\FreePluginConnectors\AddToSubscribersFilters;
use MailPoet\Premium\DynamicSegments\FreePluginConnectors\SendingNewslettersSubscribersFinder;
use MailPoet\Premium\DynamicSegments\FreePluginConnectors\SubscribersBulkActionHandler;
use MailPoet\Premium\DynamicSegments\FreePluginConnectors\SubscribersListingsHandlerFactory;
use MailPoet\Premium\DynamicSegments\Mappers\DBMapper;
use MailPoet\Premium\DynamicSegments\Persistence\Loading\Loader;
use MailPoet\Premium\DynamicSegments\Persistence\Loading\SingleSegmentLoader;
use MailPoet\Premium\DynamicSegments\Persistence\Loading\SubscribersCount;
use MailPoet\Premium\DynamicSegments\Persistence\Loading\SubscribersIds;
use MailPoet\Util\Helpers;
use MailPoet\WP\Hooks as WPHooks;

class Hooks {
  function init() {
    WPHooks::addAction(
      'mailpoet_api_setup',
      array($this, 'addPremiumAPIEndpoints')
    );

    WPHooks::addAction(
      'in_plugin_update_message-mailpoet-premium/mailpoet-premium.php',
      array($this, 'pluginUpdateMessage')
    );

    WPHooks::addAction(
      'mailpoet_segments_with_subscriber_count',
      array($this, 'addSegmentsWithSubscribersCount')
    );

    WPHooks::addAction(
      'mailpoet_get_subscribers_in_segment_finders',
      array($this, 'getSubscribersInSegmentsFinders')
    );

    WPHooks::addAction(
      'mailpoet_get_subscribers_listings_in_segment_handlers',
      array($this, 'getSubscribersListingsInSegmentsHandlers')
    );

    WPHooks::addAction(
      'mailpoet_subscribers_listings_filters_segments',
      array($this, 'addDynamicFiltersToSubscribersListingsFilters')
    );

    WPHooks::addAction(
      'mailpoet_subscribers_in_segment_apply_bulk_action_handlers',
      array($this, 'applySubscriberBulkAction')
    );

  }

  function addPremiumAPIEndpoints($api) {
    if(is_callable(array($api, 'addEndpointNamespace'))) {
      $api->addEndpointNamespace('MailPoet\Premium\API\JSON\v1', 'v1');
    }
  }

  function pluginUpdateMessage() {
    $checker = new ServicesChecker();
    $is_key_valid = $checker->isPremiumKeyValid($show_notices = false);
    if(!$is_key_valid) {
      $error = __('[link1]Register[/link1] your copy of the MailPoet Premium plugin to receive access to automatic upgrades and support. Need a license key? [link2]Purchase one now.[/link2]', 'mailpoet-premium');
      $error = Helpers::replaceLinkTags($error, 'admin.php?page=mailpoet-settings#premium', array(), 'link1');
      $error = Helpers::replaceLinkTags($error, 'admin.php?page=mailpoet-premium', array(), 'link2');
      echo '<br><br>' . $error;
    }
  }

  function addSegmentsWithSubscribersCount($initial_segments) {
    $newsletters_add_segments = new AddToNewslettersSegments(new Loader(new DBMapper()), new SubscribersCount());
    return $newsletters_add_segments->add($initial_segments);
  }

  function getSubscribersInSegmentsFinders(array $finders) {
    $finders[] = new SendingNewslettersSubscribersFinder(new SingleSegmentLoader(new DBMapper()), new SubscribersIds());
    return $finders;
  }

  function getSubscribersListingsInSegmentsHandlers(array $handlers) {
    $handlers[] = new SubscribersListingsHandlerFactory();
    return $handlers;
  }

  function addDynamicFiltersToSubscribersListingsFilters($segment_filters) {
    $newsletters_add_segments = new AddToSubscribersFilters(new Loader(new DBMapper()), new SubscribersCount());
    return $newsletters_add_segments->add($segment_filters);
  }

  function applySubscriberBulkAction(array $handlers) {
    $handlers[] = new SubscribersBulkActionHandler();
    return $handlers;
  }


}