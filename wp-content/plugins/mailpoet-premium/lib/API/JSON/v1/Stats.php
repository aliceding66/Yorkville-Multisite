<?php
namespace MailPoet\Premium\API\JSON\v1;

use MailPoet\Config\AccessControl;
use MailPoet\API\JSON\Endpoint as APIEndpoint;
use MailPoet\API\JSON\Error as APIError;
use MailPoet\Listing;
use MailPoet\Models\Newsletter;
use MailPoet\Newsletter\Url as NewsletterUrl;
use MailPoet\Premium\Models\NewsletterExtraData;
use MailPoet\Premium\Newsletter\Stats as CampaignStats;
use MailPoet\Premium\Newsletter\Stats\SubscriberEngagement;

if(!defined('ABSPATH')) exit;

class Stats extends APIEndpoint {
  public $permissions = array(
    'global' => AccessControl::PERMISSION_MANAGE_EMAILS
  );

  function get($data = array()) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    $newsletter = Newsletter::findOne($id);
    if($newsletter === false) {
      return $this->errorResponse(array(
        APIError::NOT_FOUND => __('This newsletter does not exist.', 'mailpoet-premium')
      ));
    }

    $newsletter
      ->withSegments()
      ->withSendingQueue()
      ->withTotalSent()
      ->withStatistics();

    if($newsletter->queue === false) {
      return $this->errorResponse(array(
        APIError::NOT_FOUND => __('This newsletter is not sent yet.', 'mailpoet-premium')
      ));
    }

    $clicked_links = CampaignStats::getClickedLinks($newsletter);

    $preview_url = NewsletterUrl::getViewInBrowserUrl(
      NewsletterUrl::TYPE_LISTING_EDITOR,
      $newsletter
    );

    $newsletter = $newsletter->asArray();
    $newsletter = NewsletterExtraData::getFields($newsletter);
    $newsletter['clicked_links'] = $clicked_links;
    $newsletter['preview_url'] = $preview_url;

    return $this->successResponse($newsletter);
  }

  function listing($data = array()) {
    $id = (isset($data['params']['id']) ? (int)$data['params']['id'] : false);
    $newsletter = Newsletter::findOne($id);
    if($newsletter === false) {
      return $this->errorResponse(array(
        APIError::NOT_FOUND => __('This newsletter does not exist.', 'mailpoet-premium')
      ));
    }

    $newsletter
      ->withSendingQueue();

    if($newsletter->queue === false) {
      return $this->errorResponse(array(
        APIError::NOT_FOUND => __('This newsletter is not sent yet.', 'mailpoet-premium')
      ));
    }

    $listing = new SubscriberEngagement($data);
    $listing_data = $listing->get();

    foreach($listing_data['items'] as &$item) {
      $item['subscriber_url'] = admin_url(
        'admin.php?page=mailpoet-subscribers#/edit/' . $item['subscriber_id']
      );
    }
    unset($item);

    return $this->successResponse($listing_data['items'], array(
      'count' => $listing_data['count'],
      'filters' => $listing_data['filters'],
      'groups' => $listing_data['groups']
    ));
  }
}
