<?php
defined('WP_PVP_VERSION') OR exit('No direct script access allowed');

class WP_PVP_update {
	public static function update() {
		$now_version = get_option('PVP_version');

		if( $now_version === FALSE ) {
			$now_version = '0.0.0';
		}
		if( $now_version == WP_PVP_VERSION ) {
			return;
		}

		if( version_compare($now_version, '2.0.0', '<' ) ) {
			update_option('PVP_version', '2.0.0');
		}
		if( version_compare($now_version, '2.0.1', '<' ) ) {
			update_option('PVP_version', '2.0.1');
		}
		if( version_compare($now_version, '2.0.2', '<' ) ) {
			update_option('PVP_version', '2.0.2');
		}
		if( version_compare($now_version, '2.0.3', '<' ) ) {
			update_option('PVP_version', '2.0.3');
		}
		if( version_compare($now_version, '2.0.4', '<' ) ) {
			update_option('PVP_version', '2.0.4');
		}
		if( version_compare($now_version, '2.0.5', '<' ) ) {
			update_option('PVP_version', '2.0.5');
		}
		if( version_compare($now_version, '2.0.6', '<' ) ) {
			update_option('PVP_version', '2.0.6');
		}
		if( version_compare($now_version, '2.0.7', '<' ) ) {
			update_option('PVP_version', '2.0.7');
		}
		if( version_compare($now_version, '2.0.8', '<' ) ) {
			update_option('PVP_version', '2.0.8');
		}
		if( version_compare($now_version, '2.0.10', '<' ) ) {
			update_option('PVP_version', '2.0.10');
		}
	}
}
