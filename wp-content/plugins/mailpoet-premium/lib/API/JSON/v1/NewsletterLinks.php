<?php

namespace MailPoet\Premium\API\JSON\v1;

use MailPoet\API\JSON\Endpoint as APIEndpoint;
use MailPoet\Config\AccessControl;
use MailPoet\Models\NewsletterLink;

class NewsletterLinks extends APIEndpoint {

  public $permissions = array(
    'global' => AccessControl::PERMISSION_MANAGE_SEGMENTS,
  );

  function get($data = array()) {
    $links = NewsletterLink::select(array('id', 'url'))->where('newsletter_id', $data['newsletterId'])->findArray();
    return $this->successResponse($links);
  }

}