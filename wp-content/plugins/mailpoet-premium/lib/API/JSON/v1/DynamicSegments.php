<?php

namespace MailPoet\Premium\API\JSON\v1;

use MailPoet\API\JSON\Endpoint as APIEndpoint;
use MailPoet\API\JSON\Error;
use MailPoet\API\JSON\Response;
use MailPoet\Config\AccessControl;
use MailPoet\Listing\Handler;
use MailPoet\Listing\BulkAction;
use MailPoet\Models\Model;
use MailPoet\Premium\DynamicSegments\Exceptions\ErrorSavingException;
use MailPoet\Premium\DynamicSegments\Exceptions\InvalidSegmentTypeException;
use MailPoet\Premium\DynamicSegments\Mappers\DBMapper;
use MailPoet\Premium\DynamicSegments\Mappers\FormDataMapper;
use MailPoet\Premium\DynamicSegments\Persistence\Loading\SingleSegmentLoader;
use MailPoet\Premium\DynamicSegments\Persistence\Loading\SubscribersCount;
use MailPoet\Premium\DynamicSegments\Persistence\Saver;

class DynamicSegments extends APIEndpoint {

  public $permissions = array(
    'global' => AccessControl::PERMISSION_MANAGE_SEGMENTS,
  );

  /** @var \MailPoet\Premium\DynamicSegments\Mappers\FormDataMapper */
  private $mapper;

  /** @var Saver */
  private $saver;

  /** @var SingleSegmentLoader */
  private $dynamic_segments_loader;

  /** @var SubscribersCount */
  private $subscribers_counts_loader;

  public function __construct($mapper = null, $saver = null, $dynamic_segments_loader = null, $subscribers_counts_loader = null) {
    $this->mapper = $mapper ?: new FormDataMapper();
    $this->saver = $saver ?: new Saver();
    $this->dynamic_segments_loader = $dynamic_segments_loader ?: new SingleSegmentLoader(new DBMapper());
    $this->subscribers_counts_loader = $subscribers_counts_loader ?: new SubscribersCount();
  }

  function get($data = array()) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    try {
      $segment = $this->dynamic_segments_loader->load($id);

      $filters = $segment->getFilters();

      return $this->successResponse(array_merge(array(
        'name' => $segment->name,
        'description' => $segment->description,
        'id' => $segment->id,
      ), $filters[0]->toArray()));
    } catch (\InvalidArgumentException $e) {
      return $this->errorResponse(array(
        Error::NOT_FOUND => __('This segment does not exist.', 'mailpoet-premium')
      ));
    }
  }

  function save($data) {
    try {
      $dynamic_segment = $this->mapper->mapDataToDB($data);
      $this->saver->save($dynamic_segment);

      return $this->successResponse($data);
    } catch (InvalidSegmentTypeException $e) {
      return $this->errorResponse(array(
        Error::BAD_REQUEST => $this->getErrorString($e)
      ), array(), Response::STATUS_BAD_REQUEST);
    } catch (ErrorSavingException $e) {
      $statusCode = Response::STATUS_UNKNOWN;
      if($e->getCode() === Model::DUPLICATE_RECORD) {
        $statusCode = Response::STATUS_CONFLICT;
      }
      return $this->errorResponse(array($statusCode => $e->getMessage()), array(), $statusCode);
    }
  }

  private function getErrorString(InvalidSegmentTypeException $e) {
    switch($e->getCode()) {
      case InvalidSegmentTypeException::MISSING_TYPE:
        return __('Segment type is missing.', 'mailpoet-premium');
      case InvalidSegmentTypeException::INVALID_TYPE:
        return __('Segment type is unknown.', 'mailpoet-premium');
      case InvalidSegmentTypeException::MISSING_ROLE:
        return __('Please select user role.', 'mailpoet-premium');
      case InvalidSegmentTypeException::MISSING_ACTION:
        return __('Please select email action.', 'mailpoet-premium');
      case InvalidSegmentTypeException::MISSING_NEWSLETTER_ID:
        return __('Please select an email.', 'mailpoet-premium');
      case InvalidSegmentTypeException::MISSING_PRODUCT_ID:
        return __('Please select category.', 'mailpoet-premium');
      case InvalidSegmentTypeException::MISSING_CATEGORY_ID:
        return __('Please select product.', 'mailpoet-premium');
      default:
        return __('An error occurred while saving data.', 'mailpoet-premium');
    }
  }

  function trash($data = array()) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    try {
      $segment = $this->dynamic_segments_loader->load($id);
      $segment->trash();
      return $this->successResponse(
        $segment->asArray(),
        array('count' => 1)
      );
    } catch (\InvalidArgumentException $e) {
      return $this->errorResponse(array(
        Error::NOT_FOUND => __('This segment does not exist.', 'mailpoet-premium')
      ));
    }
  }

  function restore($data = array()) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    try {
      $segment = $this->dynamic_segments_loader->load($id);
      $segment->restore();
      return $this->successResponse(
        $segment->asArray(),
        array('count' => 1)
      );
    } catch (\InvalidArgumentException $e) {
      return $this->errorResponse(array(
        Error::NOT_FOUND => __('This segment does not exist.', 'mailpoet-premium')
      ));
    }
  }

  function delete($data = array()) {
    $id = (isset($data['id']) ? (int)$data['id'] : false);
    try {
      $segment = $this->dynamic_segments_loader->load($id);
      $segment->delete();
      return $this->successResponse(null, array('count' => 1));
    } catch (\InvalidArgumentException $e) {
      return $this->errorResponse(array(
        Error::NOT_FOUND => __('This segment does not exist.', 'mailpoet-premium')
      ));
    }
  }

  function listing($data = array()) {
    $listing = new Handler(
      '\MailPoet\Premium\Models\DynamicSegment',
      $data
    );

    $listing_data = $listing->get();

    $data = array();
    foreach($listing_data['items'] as $segment) {
      $segment->subscribers_url = admin_url(
        'admin.php?page=mailpoet-subscribers#/filter[segment=' . $segment->id . ']'
      );

      $row = $segment->asArray();
      $segment_with_filters = $this->dynamic_segments_loader->load($segment->id);
      $row['count'] = $this->subscribers_counts_loader->getSubscribersCount($segment_with_filters);
      $data[] = $row;
    }

    return $this->successResponse($data, array(
      'count' => $listing_data['count'],
      'filters' => $listing_data['filters'],
      'groups' => $listing_data['groups']
    ));

  }

  function bulkAction($data = array()) {
    try {
      $bulk_action = new BulkAction(
        '\MailPoet\Premium\Models\DynamicSegment',
        $data
      );
      $meta = $bulk_action->apply();
      return $this->successResponse(null, $meta);
    } catch(\Exception $e) {
      return $this->errorResponse(array(
        $e->getCode() => $e->getMessage()
      ));
    }
  }
}