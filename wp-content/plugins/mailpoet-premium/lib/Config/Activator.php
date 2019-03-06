<?php

namespace MailPoet\Premium\Config;

use MailPoet\Models\Setting;

if(!defined('ABSPATH')) exit;

class Activator {
  static function activate() {
    $migrator = new Migrator();
    $migrator->up();

    Setting::setValue('premium_db_version', Env::$version);
  }

  static function deactivate() {
    $migrator = new Migrator();
    $migrator->down();
  }

  static function reset() {
    self::deactivate();
    self::activate();
  }
}
