<?php
namespace W3TC;

/**
 * MaxCDN Widget
 */
class Cdn_Plugin_WidgetMaxCdn {
	private $authorized;
	private $have_zone;
	private $_sealed;

	private $api;
	private $_config = null;

	function __construct() {
		$this->_config = Dispatcher::config();
	}

	/**
	 * Runs plugin
	 */
	function run() {
		if ( Util_Admin::get_current_wp_page() == 'w3tc_dashboard' )
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

		add_action( 'w3tc_widget_setup', array(
				$this,
				'wp_dashboard_setup'
			), 100 );
		add_action( 'w3tc_network_dashboard_setup', array(
				$this,
				'wp_dashboard_setup'
			), 100 );

		// Configure authorize and have_zone
		$this->_setup( $this->_config );

		if ( $this->have_zone && $this->authorized && isset( $_GET['page'] ) && strpos( $_GET['page'], 'w3tc_dashboard' ) !== false ) {
			require_once W3TC_LIB_NETDNA_DIR . '/NetDNA.php';
			require_once W3TC_LIB_NETDNA_DIR . '/NetDNAPresentation.php';
			$authorization_key = $this->_config->get_string( 'cdn.maxcdn.authorization_key' );
			$alias = $consumerkey = $consumersecret = '';
			$keys = explode( '+', $authorization_key );
			if ( sizeof( $keys ) == 3 )
				list( $alias, $consumerkey, $consumersecret ) =  $keys;

			$this->api = new \NetDNA( $alias, $consumerkey, $consumersecret );

			add_action( 'admin_head', array( $this, 'admin_head' ) );
		}
	}

	function admin_head() {
		$zone_id = $this->_config->get_string( 'cdn.maxcdn.zone_id' );
		try {
			$zone_info = $this->api->get_pull_zone( $zone_id );

			if ( !$zone_info )
				return;
			$filetypes = $this->api->get_list_of_file_types_per_zone( $zone_id );

			if ( !isset( $filetypes['filetypes'] ) )
				return;
		} catch ( \Exception $ex ) {
			return;
		}
		$filetypes = $filetypes['filetypes'];
		$group_hits = \NetDNAPresentation::group_hits_per_filetype_group( $filetypes );

		$list = array();
		$colors = array();
		foreach ( $group_hits as $group => $hits ) {
			$list[] = sprintf( "['%s', %d]", $group, $hits );
			$colors[] = '\'' . \NetDNAPresentation::get_file_group_color( $group ) . '\'';
		}
?>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages:["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Filetype', 'Hits'],<?php
		echo "                ", implode( ',', $list );
?>
            ]);
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            var options = {colors: [<?php echo implode( ',', $colors ) ?>]};
            chart.draw(data, options);
        }
    </script>
<?php
	}

	/**
	 * Dashboard setup action
	 *
	 * @return void
	 */
	function wp_dashboard_setup() {
		Util_Widget::add( 'w3tc_maxcdn',
			'<div class="w3tc-widget-maxcdn-logo"></div>',
			array( $this, 'widget_maxcdn' ),
			Util_Ui::admin_url( 'admin.php?page=w3tc_cdn' ),
			'normal' );
	}

	/**
	 * Loads and configures NetDNA widget to be used in WP Dashboards.
	 *
	 * @param unknown $widget_id
	 * @param array   $form_inputs
	 */
	function widget_maxcdn( $widget_id, $form_inputs = array() ) {

		$authorized = $this->authorized;
		$have_zone = $this->have_zone;
		$error = '';
		$no_zone = $this->_config->get_integer( 'cdn.maxcdn.zone_id' ) == 0;
		$is_sealed = $this->_sealed;
		$pull_zones = array();
		$zone_info = false;
		if ( $this->authorized && $this->have_zone ) {
			$zone_id = $this->_config->get_integer( 'cdn.maxcdn.zone_id' );

			try{
				$zone_info = $this->api->get_pull_zone( $zone_id );
			} catch ( \Exception $ex ) {
				$zone_info = false;
				$error = $ex->getMessage();
			}

			if ( $zone_info ) {
				$content_zone = $zone_info['name'];
				try {
					$summary = $this->api->get_stats_per_zone( $zone_id );
					$filetypes = $this->api->get_list_of_file_types_per_zone( $zone_id );
					$popular_files = $this->api->get_list_of_popularfiles_per_zone( $zone_id );
					$popular_files = \NetDNAPresentation::format_popular( $popular_files );
					$popular_files = array_slice( $popular_files, 0 , 5 );
					$account = $this->api->get_account();
					$account_status = \NetDNAPresentation::get_account_status( $account['status'] );
					include W3TC_INC_WIDGET_DIR . '/maxcdn.php';
				} catch ( \Exception $ex ) {
					$error = $ex->getMessage();
					try {
						$pull_zones = $this->api->get_zones_by_url( home_url() );
					} catch ( \Exception $ex ) {}
					include W3TC_INC_WIDGET_DIR . '/maxcdn_signup.php';
				}
			} else {
				try {
					$pull_zones = $this->api->get_zones_by_url( home_url() );
				} catch ( \Exception $ex ) {}
				include W3TC_INC_WIDGET_DIR . '/maxcdn_signup.php';
			}
		} else {
			include W3TC_INC_WIDGET_DIR . '/maxcdn_signup.php';
		}
	}

	/**
	 *
	 *
	 * @param Config  $config
	 */
	private function _setup( $config ) {
		$this->authorized = $config->get_string( 'cdn.maxcdn.authorization_key' ) != '' &&
			$config->get_string( 'cdn.engine' ) == 'maxcdn';
		$keys = explode( '+', $config->get_string( 'cdn.maxcdn.authorization_key' ) );
		$this->authorized = $this->authorized  && sizeof( $keys ) == 3;

		$this->have_zone = $config->get_string( 'cdn.maxcdn.zone_id' ) != 0;
	}

	public function enqueue() {
		wp_enqueue_style( 'w3tc-widget' );
		wp_enqueue_script( 'w3tc-metadata' );
		wp_enqueue_script( 'w3tc-widget' );
	}
}
