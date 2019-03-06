<?php
namespace MailPoet\Premium\Newsletter;

use MailPoet\Models\Newsletter;
use MailPoet\Models\StatisticsClicks;

class Stats {
  static function getClickedLinks(Newsletter $newsletter) {
    return StatisticsClicks::tableAlias('clicks')
      ->selectExpr(
        'clicks.*, links.url, COUNT(DISTINCT clicks.subscriber_id) as cnt'
      )
      ->join(
        MP_NEWSLETTER_LINKS_TABLE,
        'links.id = clicks.link_id',
        'links'
      )
      ->where('newsletter_id', $newsletter->id)
      ->groupBy('clicks.link_id')
      ->orderByDesc('cnt')
      ->findArray();
  }
}
