<?php

namespace MailPoet\Premium\DynamicSegments\FreePluginConnectors;

use MailPoet\Listing\Handler;
use MailPoet\Premium\Models\DynamicSegment;

class SubscribersListingsHandlerFactory {

  function get($segment, $data) {
    if($segment['type'] === DynamicSegment::TYPE_DYNAMIC) {
      $listing = new Handler('\MailPoet\Premium\Models\SubscribersInDynamicSegment', $data);

      return $listing_data = $listing->get();
    }
  }


}