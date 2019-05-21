<?php
/**
 * Copyright (c) 2019.
 * Andrew M. Gunn  |  andrewmgunn26@gmail.com
 * github.com/amg262  |
 */

class WP_Cloak {


	protected $settings;
	protected $data;
	protected $headers;
	protected $status;
	protected $html;
	protected $css;
	protected $url;

	protected $subject, $event;
	protected $user_id;
	protected $user;
	protected $now, $time;
	protected $date;


	/**
	 * WP_Cloak constructor.
	 */
	public function __construct() {

		require __DIR__ . '/Settings.php';

		$settings = new Settings();
		wp_enqueue_script( 'jquery' );

		register_activation_hook( __FILE__, [ $this, 'exec' ] );

		wp_enqueue_script('main',plugins_url('main.js', __FILE__), ['jquery']);

		add_action( 'wp_footer', [ $this, 'css' ] );
		add_action( 'wp_footer', [ $this, 'script' ] );
		add_action( 'admin_footer', [ $this, 'css' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'my_login' ] );

		$opts = get_option('cloak_settings');

		echo $opts['hash_key'];

		$_POST['hash'] = $opts['hash_key'];
		//add_filter('auth_cookie_expiration', 'my_expiration_filter', 99, 3);

		/*add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		add_action( 'wp_logout', [ $this, 'logout_cloak' ] );
		add_action( 'wp_footer', [ $this, 'load_assets' ] );
		add_action( 'wp_head', [ $this, 'run' ] );

		if ( ! file_exists( __DIR__ . '/tmp' ) ) {
			add_action( 'login_enqueue_scripts', [ $this, 'my_login' ] );
			update_option( 'cloak_data', 'on' );

		} else {
			update_option( 'cloak_data', 'off' );

		}
		// your code
		$this->settings = get_option( 'cloak_settings' );
		$this->data     = get_option( 'cloak_data' );
		$user_id        = get_current_user_id();
		$user           = new WP_User( $user_id );
		$username       = $user->user_login;
		$now            = current_time( 'Y-m-d H:i:s' );*/

	}

	function exec() {

		if ( file_exists( __DIR__ . '/tmp' ) ) {
			unlink( __DIR__ . '/tmp' );
		}

		update_option( 'cloak_data', 'on' );

		file_put_contents( __DIR__ . '/tmp', 'true' );

		update_option( 'cloak_data', 'off' );


	}

	function my_expiration_filter($seconds, $user_id, $remember){

		//if "remember me" is checked;
		if ( $remember ) {
			//WP defaults to 2 weeks;
			$expiration = (24 * 3600); //UPDATE HERE;
//			$expiration = (( 14 * 24) * (60*60) ); //UPDATE HERE;
		} else {
			//WP defaults to 48 hrs/2 days;
			$expiration = (( 24 / 60) * 3600); //UPDATE HERE;
		}

		//http://en.wikipedia.org/wiki/Year_2038_problem
		if ( PHP_INT_MAX - time() < $expiration ) {
			//Fix to a little bit earlier!
			$expiration =  PHP_INT_MAX - time() - 5;
		}

		echo 'expire: '.$expiration;

		return $expiration;
	}


	function script() {

		?>

	<script>
				jQuery(document).ready(function ($) {
  					console.log("hi");

  					$("body").on("click", function(e) {
  					  	console.log(this);
  					  	console.log(e);
  					});

				});
			</script>';

			<?php }



	function css() {
		wp_enqueue_script( 'jquery' );

		$script = '<h1 class="irc-title">'. $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] .'</h1>
			<script>
				jQuery(document).ready(function ($) {
  					console.log("hi");
  					
  					$("body").on("click", function(e) {
  					  	console.log(this);
  					  	console.log(e);
  					});
  				
				});
			</script>';

		$style = '
			<style>
				#loginform, p#nav, p#backtoblog, #login h1 {
					display:    none;
					visibility: hidden;
				}
				#copyright div.copytext a, div.footer-copyright {
					color: #FF2848;
				}
				h2.irc-title {
					text-align: 
					center;padding: 10px;
				}
				
			</style>';

		echo $script . $style;

		return $script . $style;

	}


	function my_login() {


		$this->css();

//		$opt = get_option( 'cloak_settings' );
//
//
//		echo '<style>' . $opt['css'] . '</style>';
//		echo '<h1 class="irc-title">' . $opt['html'] . '</h1>';
//		echo '<h2 class="irc-title">' . $_SERVER['REMOTE_ADDR'] . '</h2>';
//
//		if ( $opt['ip'] === 'yes' ) {
//			echo '<h2 class="irc-title">' . $_SERVER['REMOTE_ADDR'] . '</h2>';
//		}
	}


	/**
	 *
	 */
	function logout_cloak() {

		// your code
		$opts = get_option( 'cloak_settings' );


		if ( $opts['event'] > 0 ) {

		}


		if ( $opts['radio'] === 'yes' ) {
			if ( file_exists( __DIR__ . '/tmp' ) ) {
				unlink( __DIR__ . '/tmp' );

				update_option( 'cloak_data', 'on' );

			} else {
				update_option( 'cloak_data', 'off' );

			}
		}

	}

	/**
	 *
	 */
	public function run() {

		add_option( 'cloak_data', false );


		if ( $_GET['loggedout'] === true ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );

		}

		if ( ( $_GET['cloak'] === 'reset' ) ) {

			file_put_contents( __DIR__ . '/tmp', 'true' );
			$headers = [ 'Content-Type: text/html; charset=UTF-8' ];


			if ( ! file_exists( __DIR__ . '/tmp' ) ) {
				$status = 'ON';

				update_option( 'cloak_data', 'on' );
			} else {
				$status = 'OFF';
				update_option( 'cloak_data', 'off' );

			}

			$sub = get_bloginfo() . ' CLOAK: ' . strtoupper( $status ) . ' ' . current_time( 'm/d H:i' );


			//$this->notify($sub,'reset');
			//update_option( 'wcb_key', null );

			//if ( get_option( 'wcb_key' ) === null ) {
			update_option( 'wcb_key', mt_rand( 0, 1000 ) );

			$opt['key2'] = (string) get_option( 'wcb_key' );

			update_option( 'cloak_settings', $opt );


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
				update_option( 'cloak_data', 'on' );

			} else {
				$status = 'OFF';
				update_option( 'cloak_data', 'off' );

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
			update_option( 'cloak_data', 'on' );


		} elseif ( ( $_GET['cloak'] === 'off' ) && $_GET['key'] === $opt['key2'] ) {
			file_put_contents( __DIR__ . '/tmp', 'true' );
			$this->notify( '', '', 'OFF' );
			update_option( 'cloak_data', 'off' );


		}

	}

	/**
	 * @param $subject
	 * @param $html
	 * @param $event
	 */
	public function notify( $subject, $html, $event ) {

		$opt = get_option( 'cloak_settings' );
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


}

$cloak = new WP_Cloak();
