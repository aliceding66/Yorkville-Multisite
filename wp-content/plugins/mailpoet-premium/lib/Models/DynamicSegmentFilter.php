<?php

namespace MailPoet\Premium\Models;

use MailPoet\Models\Model;

class DynamicSegmentFilter extends Model {

  public static $_table = MP_DYNAMIC_SEGMENTS_FILTERS_TABLE;

  function save() {
    if(is_null($this->filter_data)) {
      $this->filter_data = array();
    }

    $this->set('filter_data', (
      is_serialized($this->filter_data)
      ? $this->filter_data
      : serialize($this->filter_data)
    ));

    return parent::save();
  }

  static function getAllBySegmentIds($segmentIds) {
    if(empty($segmentIds)) return array();
    $query = self::table_alias('filters')
      ->whereIn('filters.segment_id', $segmentIds);

    $query->findMany();
    return $query->findMany();
  }

  public function __get($name) {
    $value = parent::__get($name);
    if($name === 'filter_data' && is_serialized($value)) {
      return unserialize($value);
    }
    return $value;
  }

  static function deleteAllBySegmentIds($segmentIds) {
    if(empty($segmentIds)) return;

    $query = self::table_alias('filters')
      ->whereIn('segment_id', $segmentIds);

    $query->deleteMany();

  }
  
}