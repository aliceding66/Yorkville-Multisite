<?php

namespace MailPoet\Premium\DynamicSegments\FreePluginConnectors;

use MailPoet\Models\Subscriber;
use MailPoet\Premium\DynamicSegments\Persistence\Loading\SingleSegmentLoader;
use MailPoet\Premium\DynamicSegments\Persistence\Loading\SubscribersIds;
use MailPoet\Premium\Models\DynamicSegment;

class SendingNewslettersSubscribersFinder {

  /** @var SingleSegmentLoader */
  private $single_segment_loader;

  /** @var \MailPoet\Premium\DynamicSegments\Persistence\Loading\SubscribersIds */
  private $subscribers_ids_loader;

  public function __construct(SingleSegmentLoader $single_segment_loader, SubscribersIds $subscribers_ids_loader) {
    $this->single_segment_loader = $single_segment_loader;
    $this->subscribers_ids_loader = $subscribers_ids_loader;
  }

  /**
   * @param array $segment
   * @param int[] $subscribers_to_process_ids
   *
   * @return Subscriber[]
   */
  function findSubscribersInSegment(array $segment, array $subscribers_to_process_ids) {
    if($segment['type'] !== DynamicSegment::TYPE_DYNAMIC) return array();
    $dynamic_segment = $this->single_segment_loader->load($segment['id']);
    return $this->subscribers_ids_loader->load($dynamic_segment, $subscribers_to_process_ids);
  }

  /**
   * @param array $segment
   *
   * @return array
   */
  function getSubscriberIdsInSegment(array $segment) {
    if($segment['type'] !== DynamicSegment::TYPE_DYNAMIC) return array();
    $dynamic_segment = $this->single_segment_loader->load($segment['id']);
    $result = $this->subscribers_ids_loader->load($dynamic_segment);
    return $this->createResultArray($result);
  }

  private function createResultArray($subscribers) {
    $result = array();
    foreach($subscribers as $subscriber) {
      $result[] = $subscriber->asArray();
    }
    return $result;
  }

}