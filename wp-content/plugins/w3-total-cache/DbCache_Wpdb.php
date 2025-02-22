<?php
namespace W3TC;

/**
 * class Db
 * Database access mediator
 */
class DbCache_Wpdb extends DbCache_WpdbBase {
	/**
	 * Returns object instance. Called by WP engine
	 *
	 * @return DbCache_Wpdb
	 */
	static function instance() {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$processors = array();
			$call_default_constructor = true;

			// no caching during activation
			$is_installing = ( defined( 'WP_INSTALLING' ) && WP_INSTALLING );

			$config = Dispatcher::config();
			if ( !$is_installing && $config->get_boolean( 'dbcache.enabled' ) ) {
				$processors[] = new DbCache_WpdbInjection_QueryCaching();
			}
			if ( Util_Environment::is_dbcluster() ) {
				// dbcluster use mysqli only since other is obsolete now
				if ( !defined( 'WP_USE_EXT_MYSQL' ) ) {
                    define( 'WP_USE_EXT_MYSQL', false );
                }

				$processors[] = new Enterprise_Dbcache_WpdbInjection_Cluster();
			}

			$processors[] = new DbCache_WpdbInjection();

			$class = __CLASS__;
			$o = new $class( $processors );

			$next_injection = new _CallUnderlying( $o );

			foreach ( $processors as $processor ) {
				$processor->initialize_injection( $o, $next_injection );
			}

			// initialize after processors configured
			$o->initialize();

			$instance = $o;
		}

		return $instance;
	}

	private $active_processor_number;
	private $active_processor;
	private $processors;

	private $debug;
	private $request_time_start = 0;

	/*
     * @param boolean $call_default_constructor
     */
	public function __construct( $processors = null ) {
		// required to initialize $use_mysqli which is private
		parent::__construct( '', '', '', '' );

		// cant force empty parameter list due to wp requirements
		if ( !is_array( $processors ) )
			throw new Exception( 'called incorrectly, use instance()' );

		$this->processors = $processors;
		$this->active_processor = $processors[0];
		$this->active_processor_number = 0;

		$c = Dispatcher::config();
		$this->debug = $c->get_boolean( 'dbcache.debug' );

		if ( $this->debug )
			$this->_request_time_start = microtime( true );
	}

	/**
	 * Called by Root_Loader when all w3tc plugins loaded,
	 * i.e. later that object instantiated
	 */
	function on_w3tc_plugins_loaded() {
		$o = $this;

		if ( $this->debug ) {
			add_action( 'shutdown', array( $o, 'debug_shutdown' ) );
		}

		add_filter( 'w3tc_footer_comment', array(
				$o, 'w3tc_footer_comment' ) );
		add_action( 'w3tc_usage_statistics_of_request', array(
				$o, 'w3tc_usage_statistics_of_request' ), 10, 1 );

	}

	function w3tc_footer_comment( $strings ) {
		foreach ( $this->processors as $processor )
			$strings = $processor->w3tc_footer_comment( $strings );

		return $strings;
	}

	function debug_shutdown() {
		$strings = array();
		foreach ( $this->processors as $processor )
			$strings = $processor->w3tc_footer_comment( $strings );

		$request_time_total = microtime( true ) - $this->request_time_start;

		$data = sprintf( "\n[%s] [%s] [%s]\n", date( 'r' ),
			$_SERVER['REQUEST_URI'], round( $request_time_total, 4 ) ) .
			implode( "\n", $strings ) . "\n";
		$data = strtr( $data, '<>', '..' );

		$filename = Util_Debug::log_filename( 'dbcache' );
		@file_put_contents( $filename, $data, FILE_APPEND );
	}

	function w3tc_usage_statistics_of_request( $storage ) {
		foreach ( $this->processors as $processor )
			$processor->w3tc_usage_statistics_of_request( $storage );
	}

	function flush_cache() {
		$v = true;

		foreach ( $this->processors as $processor )
			$v &= $processor->flush_cache();

		return $v;
	}

	function db_connect( $allow_bail = true ) {
		if ( empty( $this->dbuser ) ) {
			// skip connection - called from constructor
		} else
			return parent::db_connect( $allow_bail );
	}

	/**
	 * Initializes object after processors configured. Called from instance() only
	 */
	function initialize() {
		return $this->active_processor->initialize();
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function insert( $table, $data, $format = null ) {
		do_action( 'w3tc_db_insert', $table, $data, $format );
		return $this->active_processor->insert( $table, $data, $format );
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function query( $query ) {
		return $this->active_processor->query( $query );
	}

	function _escape( $data ) {
		return $this->active_processor->_escape( $data );
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function replace( $table, $data, $format = null ) {
		do_action( 'w3tc_db_replace', $table, $data, $format );
		return $this->active_processor->replace( $table, $data, $format );
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function update( $table, $data, $where, $format = null, $where_format = null ) {
		do_action( 'w3tc_db_update', $table, $data, $where, $format,
			$where_format );
		return $this->active_processor->update( $table, $data, $where, $format, $where_format );
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function delete( $table, $where, $where_format = null ) {
		do_action( 'w3tc_db_delete', $table, $where, $where_format );
		return $this->active_processor->delete( $table, $where, $where_format );
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function init_charset() {
		return $this->active_processor->init_charset();
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function set_charset( $dbh, $charset = null, $collate = null ) {
		return $this->active_processor->set_charset( $dbh, $charset, $collate );
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function flush() {
		return $this->active_processor->flush();
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function check_database_version( $dbh_or_table = false ) {
		return $this->active_processor->check_database_version( $dbh_or_table );
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function supports_collation( $dbh_or_table = false ) {
		return $this->active_processor->supports_collation( $dbh_or_table );
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function has_cap( $db_cap, $dbh_or_table = false ) {
		return $this->active_processor->has_cap( $db_cap, $dbh_or_table );
	}

	/**
	 * Overriten logic of wp_db by processor.
	 */
	function db_version( $dbh_or_table = false ) {
		return $this->active_processor->db_version( $dbh_or_table );
	}

	/**
	 * Default initialization method, calls wp_db apropriate method
	 */
	function default_initialize() {
		parent::__construct( DB_USER, DB_PASSWORD, DB_NAME, DB_HOST );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_insert( $table, $data, $format = null ) {
		return parent::insert( $table, $data, $format );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_query( $query ) {
		return parent::query( $query );
	}

	function default__escape( $data ) {
		return parent::_escape( $data );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_replace( $table, $data, $format = null ) {
		return parent::replace( $table, $data, $format );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_update( $table, $data, $where, $format = null, $where_format = null ) {
		return parent::update( $table, $data, $where, $format, $where_format );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_delete( $table, $where, $where_format = null ) {
		return parent::delete( $table, $where, $where_format );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_init_charset() {
		return parent::init_charset();
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_set_charset( $dbh, $charset = null, $collate = null ) {
		return parent::set_charset( $dbh, $charset, $collate );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_flush() {
		return parent::flush();
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_check_database_version( $dbh_or_table = false ) {
		return parent::check_database_version( $dbh_or_table );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_supports_collation( $dbh_or_table = false ) {
		return parent::supports_collation( $dbh_or_table );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_has_cap( $db_cap, $dbh_or_table = false ) {
		return parent::has_cap( $db_cap, $dbh_or_table );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function default_db_version( $dbh_or_table = false ) {
		return parent::db_version( $dbh_or_table );
	}

	/**
	 * Default implementation, calls wp_db apropriate method
	 */
	function switch_active_processor( $offset ) {
		$new_processor_number = $this->active_processor_number + $offset;
		if ( $new_processor_number <= 0 ) {
			$new_processor_number = 0;
		} else if ( $new_processor_number >= count( $this->processors ) ) {
				$new_processor_number = count( $this->processors ) - 1;
			}

		$offset_made = $new_processor_number - $this->active_processor_number;
		$this->active_processor_number = $new_processor_number;
		$this->active_processor = $this->processors[$new_processor_number];

		return $offset_made;
	}
}



/**
 * class CallUnderlying
 */
class _CallUnderlying {
	function __construct( $manager ) {
		$this->wpdb_mixin = $manager;
	}

	/**
	 * Calls underlying processor's aproptiate method of wp_db
	 */
	function initialize() {
		$switched = $this->wpdb_mixin->switch_active_processor( 1 );

		try {
			$r = $this->wpdb_mixin->initialize();

			$this->wpdb_mixin->switch_active_processor( -$switched );
			return $r;
		} catch ( \Exception $e ) {
			$this->wpdb_mixin->switch_active_processor( -$switched );
			throw $e;
		}
	}

	/**
	 * Calls underlying processor's aproptiate method of wp_db
	 */
	function flush() {
		$switched = $this->wpdb_mixin->switch_active_processor( 1 );

		try {
			$r = $this->wpdb_mixin->flush();

			$this->wpdb_mixin->switch_active_processor( -$switched );
			return $r;
		} catch ( \Exception $e ) {
			$this->wpdb_mixin->switch_active_processor( -$switched );
			throw $e;
		}
	}

	/**
	 * Calls underlying processor's aproptiate method of wp_db
	 */
	function query( $query ) {
		$switched = $this->wpdb_mixin->switch_active_processor( 1 );

		try {
			$r = $this->wpdb_mixin->query( $query );

			$this->wpdb_mixin->switch_active_processor( -$switched );
			return $r;
		} catch ( \Exception $e ) {
			$this->wpdb_mixin->switch_active_processor( -$switched );
			throw $e;
		}
	}

	/**
	 * Calls underlying processor's aproptiate method of wp_db
	 */
	function _escape( $data ) {
		$switched = $this->wpdb_mixin->switch_active_processor( 1 );

		try {
			$r = $this->wpdb_mixin->_escape( $data );

			$this->wpdb_mixin->switch_active_processor( -$switched );
			return $r;
		} catch ( \Exception $e ) {
			$this->wpdb_mixin->switch_active_processor( -$switched );
			throw $e;
		}
	}

	/**
	 * Calls underlying processor's aproptiate method of wp_db
	 */
	function insert( $table, $data, $format = null ) {
		$switched = $this->wpdb_mixin->switch_active_processor( 1 );

		try {
			$r = $this->wpdb_mixin->insert( $table, $data, $format );

			$this->wpdb_mixin->switch_active_processor( -$switched );
			return $r;
		} catch ( \Exception $e ) {
			$this->wpdb_mixin->switch_active_processor( -$switched );
			throw $e;
		}
	}

	/**
	 * Calls underlying processor's aproptiate method of wp_db
	 */
	function replace( $table, $data, $format = null ) {
		$switched = $this->wpdb_mixin->switch_active_processor( 1 );

		try {
			$r = $this->wpdb_mixin->replace( $table, $data, $format );

			$this->wpdb_mixin->switch_active_processor( -$switched );
			return $r;
		} catch ( \Exception $e ) {
			$this->wpdb_mixin->switch_active_processor( -$switched );
			throw $e;
		}
	}

	/**
	 * Calls underlying processor's aproptiate method of wp_db
	 */
	function update( $table, $data, $where, $format = null, $where_format = null ) {
		$switched = $this->wpdb_mixin->switch_active_processor( 1 );

		try {
			$r = $this->wpdb_mixin->update( $table, $data, $where, $format, $where_format );

			$this->wpdb_mixin->switch_active_processor( -$switched );
			return $r;
		} catch ( \Exception $e ) {
			$this->wpdb_mixin->switch_active_processor( -$switched );
			throw $e;
		}
	}

	function delete( $table, $where, $where_format = null ) {
		$switched = $this->wpdb_mixin->switch_active_processor( 1 );

		try {
			$r = $this->wpdb_mixin->delete( $table, $where, $where_format );

			$this->wpdb_mixin->switch_active_processor( -$switched );
			return $r;
		} catch ( \Exception $e ) {
			$this->wpdb_mixin->switch_active_processor( -$switched );
			throw $e;
		}
	}
}
