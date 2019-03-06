<?php

namespace MailPoet\Premium\DynamicSegments\FreePluginConnectors;

use MailPoet\Listing\BulkAction;
use MailPoet\Premium\Models\DynamicSegment;

class SubscribersBulkActionHandler {

  /**
   * @param array $segment
   * @param array $data
   *
   * @return array
   * @throws \Exception
   */
  function apply(array $segment, array $data) {
    if($segment['type'] === DynamicSegment::TYPE_DYNAMIC) {
      $bulkAction = new BulkAction('\MailPoet\Premium\Models\SubscribersInDynamicSegment', $data);
      return $bulkAction->apply();
    }
  }

}