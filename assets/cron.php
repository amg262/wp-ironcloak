<?php// Scheduled Action Hook

var_dump(wp_get_scheduled_event('cron_name'));

function cron_name( $param1 = 'cron_args' ) {

	$opts = get_option( 'wcb_settings' );
	$data = get_option( 'wcb_data' );

if ( file_exists( __DIR__ . '/tmp' ) ) {
	unlink( __DIR__ . '/tmp' );

	update_option( 'wcb_data', 'on' );

} else {
	update_option( 'wcb_data', 'off' );

}
}
add_action( 'cron_name', 'cron_name' );

// Schedule Cron Job Event
function custom_cron_job() {

	$opts = get_option( 'wcb_settings' );

	$num = $opts['number_input2'];
	if ( ! wp_next_scheduled( 'cron_name' ) ) {
		wp_schedule_event( current_time( 'timestamp' ), 'hourly', 'cron_name', array( 'cron_args' ) );
	}
}
add_action( 'wp', 'custom_cron_job' );
var_dump(wp_get_scheduled_event('cron_name'));



/**
 * Class WP_IronCurtain
 */
class WP_IronCloak {


	/**
	 * @var null
	 */
	protected static $instance = null;
	/**
	 * @var bool
	 */
	public $status = false;
	/**
	 * @var array
	 */
	protected $http_args = [];
	/**
	 * @var array
	 */
	protected $hosts = [];


	/**
	 * @var
	 */
	protected $options;

	/**
	 * WP_IronCurtain constructor.
	 */
	protected function __construct() {

		require __DIR__ . '/Settings.php';

		$settings = new Settings();
		include_once __DIR__ . '/cron.php';

		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		add_action( 'wp_logout', [ $this, 'logout_cloak' ] );
		add_action( 'wp_footer', [ $this, 'load_assets' ] );
		add_action( 'wp_head', [ $this, 'run' ] );

		if ( ! file_exists( __DIR__ . '/tmp' ) ) {
			add_action( 'login_enqueue_scripts', [ $this, 'my_login' ] );
			update_option( 'wcb_data', 'on' );

		} else {
			update_option( 'wcb_data', 'off' );

		}



	}

	/**
	 * @return null
	 */
	public static function getInstance() {

		if ( static::$instance === null ) {
			static::$instance = new static;
		}

		return static::$instance;
	}



	public function cron() {

		// your code
		$opts = get_option( 'wcb_settings' );
		$data = get_option( 'wcb_data' );


		if ( $opts['radio'] === 'yes' ) {
			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );

				update_option( 'wcb_data', 'on' );

			} else {
				update_option( 'wcb_data', 'off' );

			}
		}

	}



// put this line inside a function,
// presumably in response to something the user does
// otherwise it will schedule a new event on every page visit


	/**
	 *
	 */
	public function init() {

		$this->options = get_option( 'wcb_settings' );

	}

	/**
	 *
	 */
	public function my_login() {

		$opt = get_option( 'wcb_settings' );


		echo '<style>' . $opt['css'] . '</style>';
		echo '<h1 style="padding: 10px">' . $opt['html'] . '</h1>';

		if ( $opt['ip'] === 'yes' ) {
			echo '<h2 style="text-align: center;padding: 10px;">' . $_SERVER['REMOTE_ADDR'] . '</h2>';
		}
	}

	/**
	 *
	 */
	function logout_cloak() {

		// your code
		$opts = get_option( 'wcb_settings' );


		if ( $opts['event'] > 0 ) {

		}


		if ( $opts['radio'] === 'yes' ) {
			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );

				update_option( 'wcb_data', 'on' );

			} else {
				update_option( 'wcb_data', 'off' );

			}
		}

	}

	/**
	 *
	 */
	public function load_assets() {

		wp_enqueue_script( 'sweetalertjs', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js' );
		wp_enqueue_style( 'sweetalert_css', 'https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css' );

		if ( ! file_exists( __DIR__ . '/tmp' ) ) {

			echo '<style>#copyright div.copytext a, div.footer-copyright { color:#46b349; } </style>';
		} else {

			echo '<style>#copyright div.copytext a, div.footer-copyright  { color:#ff2848; } </style>';

		}

		$green = '#3ab300';
		$red   = '#ff1919';

	}

	/**
	 *
	 */
	public function run() {

		add_option( 'wcb_data', false );


		$opt  = get_option( 'wcb_settings' );
		$data = get_option( 'wcb_data' );
		$opt2 = get_option( 'wcb_advanced' );

		if ( $_GET['loggedout'] === true ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );

		}

		if ( ( $_GET['cloak'] === 'reset' ) ) {

			file_put_contents( __DIR__ . '/tmp', 'true' );
			$headers = [ 'Content-Type: text/html; charset=UTF-8' ];


			if ( ! file_exists( __DIR__ . '/tmp' ) ) {
				$status = 'ON';

				update_option( 'wcb_data', 'on' );
			} else {
				$status = 'OFF';
				update_option( 'wcb_data', 'off' );

			}

			$sub = get_bloginfo() . ' CLOAK: ' . strtoupper( $status ) . ' ' . current_time( 'm/d H:i' );


			//$this->notify($sub,'reset');
			//update_option( 'wcb_key', null );

			//if ( get_option( 'wcb_key' ) === null ) {
			update_option( 'wcb_key', mt_rand( 0, 1000 ) );

			$opt['key2'] = (string) get_option( 'wcb_key' );

			update_option( 'wcb_settings', $opt );


			$key = md5( $opt['key2'] );

			$url = urlencode( site_url() . '/?cloak=on&key=' . $opt['key2'] );
			//}
			$html  = '<p><strong>New key: </strong>' . $opt['key2'] . '</p>' . '<p><strong>Status: </strong>' . $status . '</p>' . '<p><strong>Click for ON: </strong>' . site_url() . '/?cloak=on&key=' . $opt['key2'] . '</p>' . '<p><strong>Click for OFF: </strong>' . site_url() . '/?cloak=off&key=' . $opt['key2'] . '</p>' . site_url() . '/?cloak=off&key=' . $opt['key2'];
			$html2 = 'Key: ' . $key . '<br>' . $url;


			//$this->notify('', $html, 'RESET' );


			wp_mail( $opt['email'], 'Cloak key reset for ' . site_url(), $html, $headers );
			//wp_mail( $opt['email'], 'CClean' . site_url(), $html2, $headers );

		}
		if ( ( $_GET['cloak'] === 'email' ) || ( $_GET['cloak'] === 'status' ) ) {

			if ( ! file_exists( __DIR__ . '/tmp' ) ) {
				$status = 'ON';
				update_option( 'wcb_data', 'on' );

			} else {
				$status = 'OFF';
				update_option( 'wcb_data', 'off' );

			}
			if ( ! file_exists( __DIR__ . '/tmp' ) ) {
				echo '<h5>Cloak is <strong>ON</strong></h5>';
			} else {
				echo '<h5>Cloak is <strong>OFF</strong></h5>';
			}

			$key  = md5( $opt['key2'] );
			$key2 = ( $opt['key2'] );


			$url = esc_url( urlencode( site_url() . '/?cloak=on&key=' . $opt['key2'] ) );
			//}

			//echo $url;
			$html2 = 'Key: ' . $key . '<br>' . $url;

			$headers = [ 'Content-Type: text/html; charset=UTF-8' ];

			//$html = '<p><strong>Key: </strong>' . $opt['key2'] . '</p>' . '<p><strong>Status: </strong>' . $status . '</p>' . '<p><strong>Click for ON: </strong>' . site_url() . '/?cloak=on&key=' . $opt['key2'] . '</p>' . '<p><strong>Click for OFF: </strong>' . site_url() . '/?cloak=off&key=' . $opt['key2'] . '</p>' . site_url() . '/?cloak=off&key=' . $opt['key2'];


			$this->notify( '', $html, 'RESET2' );


			wp_mail( $opt['email'], 'Cloak key status for ' . site_url(), $html, $headers );
			//wp_mail( $opt['email'], 'CClean' . site_url(), $html2 );

		}

		if ( ( $_GET['cloak'] === 'on' ) && $_GET['key'] === $opt['key2'] ) {

			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );
			}

			$this->notify( '', '', 'on' );
			update_option( 'wcb_data', 'on' );


		} elseif ( ( $_GET['cloak'] === 'off' ) && $_GET['key'] === $opt['key2'] ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );
			$this->notify( '', '', 'OFF' );
			update_option( 'wcb_data', 'off' );


		}

	}

	/**
	 * @param $subject
	 * @param $html
	 * @param $event
	 */
	public function notify( $subject, $html, $event ) {

		$opt = get_option( 'wcb_settings' );
		$ip  = $_SERVER['REMOTE_ADDR'];

		$headers = [ 'Content-Type: text/html; charset=UTF-8' ];

		if ( ! file_exists( __DIR__ . '/tmp' ) ) {
			$status = 'ON';
		} else {
			$status = 'OFF';
		}


		$user_id  = get_current_user_id();
		$user     = new WP_User( $user_id );
		$username = $user->user_login;


		$now = current_time( 'Y-m-d H:i:s' );

		if ( $html === '' ) {
			$html = '<p>URL: ' . site_url() . '</p>' .
			        '<p>User: ' . $username . '</p>' .
			        '<p>Cloak: ' . $status . '</p>' .
			        '<p>Event: ' . $event . '</p>' .
			        '<p>' . $now . '</p>' .
			        '<p>' . $ip . '</p>';;


		}

		if ( $subject === '' ) {

			$subject = get_bloginfo() . ' CLOAK: ' . strtoupper( $status ) . ' ' . current_time( 'm/d H:i' );
		}


		wp_mail( $opt['email'], $subject, $html, $headers );
	}

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function plugin_links(
		$actions, $plugin_file
	) {

		static $plugin;

		if ( $plugin === null ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin === $plugin_file ) {
			$settings = [

				'settings' => '<a href="admin.php?page=wp-irc-admin">' . __( 'Settings', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}

}

$wpic = WP_IronCloak::getInstance();