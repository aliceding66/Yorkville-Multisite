<?php

namespace MailPoet\Premium\Models;

use MailPoet\Models\Segment as MailPoetSegment;
use MailPoet\Premium\DynamicSegments\Filters\Filter;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 */
class DynamicSegment extends MailPoetSegment {

  const TYPE_DYNAMIC = 'dynamic';

  /** @var Filter[] */
  private $filters = array();

  /**
   * @return Filter[]
   */
  public function getFilters() {
    return $this->filters;
  }

  /**
   * @param Filter[] $filters
   */
  public function setFilters(array $filters) {
    $this->filters = $filters;
  }

  function save() {
    $this->set('type', DynamicSegment::TYPE_DYNAMIC);
    return parent::save();
  }

  function dynamicSegmentFilters() {
    return $this->has_many(__NAMESPACE__ . '\DynamicSegmentFilter', 'segment_id');
  }

  static function findAll() {
    $query = self::select('*');
    return $query->where('type', DynamicSegment::TYPE_DYNAMIC)->findMany();
  }

  static function listingQuery(array $data = array()) {
    $query = self::select('*');
    $query->where('type', DynamicSegment::TYPE_DYNAMIC);
    if(isset($data['group'])) {
      $query->filter('groupBy', $data['group']);
    }
    if(isset($data['search'])) {
      $query->filter('search', $data['search']);
    }
    return $query;
  }

  static function groups() {
    return array(
      array(
        'name' => 'all',
        'label' => __('All', 'mailpoet-premium'),
        'count' => DynamicSegment::getPublished()->where('type', DynamicSegment::TYPE_DYNAMIC)->count()
      ),
      array(
        'name' => 'trash',
        'label' => __('Trash', 'mailpoet-premium'),
        'count' => parent::getTrashed()->count()
      )
    );
  }

  function delete() {
    DynamicSegmentFilter::where('segment_id', $this->id)->deleteMany();
    return parent::delete();
  }

  static function bulkTrash($orm) {
    $count = parent::bulkAction($orm, function($ids) {
      $placeholders = join(',', array_fill(0, count($ids), '?'));
      DynamicSegment::rawExecute(join(' ', array(
        'UPDATE `' .  DynamicSegment::$_table . '`',
        'SET `deleted_at` = NOW()',
        'WHERE `id` IN (' . $placeholders . ')'
      )), $ids);
    });

    return array('count' => $count);
  }

  static function bulkDelete($orm) {
    $count = parent::bulkAction($orm, function($ids) {
      $placeholders = join(',', array_fill(0, count($ids), '?'));
      DynamicSegmentFilter::rawExecute(join(' ', array(
        'DELETE FROM `' . DynamicSegmentFilter::$_table . '`',
        'WHERE `segment_id` IN (' . $placeholders . ')'
      )), $ids);
      DynamicSegment::rawExecute(join(' ', array(
        'DELETE FROM `' . DynamicSegment::$_table . '`',
        'WHERE `id` IN (' . $placeholders . ')'
      )), $ids);
    });
    
    return array('count' => $count);
  }

}