<?php
/**
 * Copyright (c) 2019.
 * Andrew M. Gunn  |  andrewmgunn26@gmail.com
 * github.com/amg262  |
 */

/*
Plugin Name: Wp Iron Cloak
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Prevent any website visitor from viewing, accessing, or using the wp-login form to log in to the site.
Version: 1.2
Author: amg26
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
	die( 'No no no!' );
}


define( 'SETTINGS_URL', 'ironcloak-admin' );
define( 'swaljs'  , plugins_url( '/node_modules/sweetalert2/src/SweetAlert.js', __FILE__ ));
define( 'swalcss'  , plugins_url( '/node_modules/sweetalert2/dist/sweetalert2.css', __FILE__ ));
define( 'swaljs2'  , plugins_url( '/node_modules/sweetalert2/dist/sweetalert2.js', __FILE__ ));
define( 'swaljs2all'  , plugins_url( '/node_modules/sweetalert2/dist/sweetalert2.all.js', __FILE__ ));


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
	protected $key;


	/**
	 * WP_Cloak constructor.
	 */
	public function __construct() {

		require __DIR__ . '/Settings.php';
		$opts                 = get_option( 'cloak_settings' );

		//echo $opts['hash_key2'];

		//var_dump($opts);

		$this->key = $opts['hash_key'];
		$settings  = new Settings();
		wp_enqueue_script( 'jquery' );

		register_activation_hook( __FILE__, [ $this, 'exec' ] );
//


		//wp_enqueue_script( 'main43', plugins_url( '/script.js', __FILE__ ), [ 'jquery' ] );

//		add_action( 'wp_footer', [ $this, 'css' ] );
		add_action( 'admin_footer', [ $this, 'script' ] );
		add_action( 'wp_head', [ $this, 'script' ] );
//		add_action( 'admin_footer', [ $this, 'css' ] );
		//add_action( 'wp_head', [ $this, 'script' ] );
		add_action( 'wp_footer', [ $this, 'script' ] );
		add_action( 'login_enqueue_scripts', [ $this, 'script' ] );

		add_action( 'login_enqueue_scripts', [ $this, 'my_login' ] );
		add_filter( 'plugin_action_links', [ $this, 'plugin_links' ], 10, 5 );
		add_action( 'wp_logout', [ $this, 'logout_cloak' ] );
		add_action( 'wp_footer', [ $this, 'load_assets' ] );

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

	function my_expiration_filter( $seconds, $user_id, $remember ) {

		//if "remember me" is checked;
		if ( $remember ) {
			//WP defaults to 2 weeks;
			$expiration = ( 24 * 3600 ); //UPDATE HERE;
//			$expiration = (( 14 * 24) * (60*60) ); //UPDATE HERE;
		} else {
			//WP defaults to 48 hrs/2 days;
			$expiration = ( ( 24 / 60 ) * 3600 ); //UPDATE HERE;
		}

		//http://en.wikipedia.org/wiki/Year_2038_problem
		if ( PHP_INT_MAX - time() < $expiration ) {
			//Fix to a little bit earlier!
			$expiration = PHP_INT_MAX - time() - 5;
		}

		echo 'expire: ' . $expiration;

		return $expiration;
	}


	function script() {

		wp_enqueue_script( 'jquery' );


		wp_enqueue_script( 'swaljs',swaljs, [ 'jquery' ] );
		wp_enqueue_style( 'swalcss', swalcss );
		wp_enqueue_script( 'swaljs2',swaljs2, [ 'jquery' ] );
		wp_enqueue_script( 'swaljs2all', swaljs2all );

		$script = '
				jQuery(document).ready(function ($) {
				
				    var input = document.getElementById("myInput");
				    
				    var text = "";
				    var caps;
				    var key;
				
				    var str = "";
				    var msg = "CapsLockABC";
						sweetAlert({
						   title: "Export Product\s BOM? ",
						   text: "Submit to run ajax request",
						   type: "info",
						   showCancelButton: true,
						   closeOnConfirm: false,
						   showLoaderOnConfirm: true,
						 
						
						});
				// When the user presses any key on the keyboard, run the function
				    document.addEventListener("keyup", function(event) {
				
				
				        console.log(event);
				        // If "caps lock" is pressed, display the warning text
				        if (event.getModifierState("CapsLock")) {
				
				            caps = "on";
				            key = event.key;
				            str += key;
				
				            if (str === msg) {
				                var q = prompt("hi");
				            }
				
				        } else {
				            console.log("off");
				        }
				        var key = "' . $this->key . '";
				       
				      
				        console.log(q);
				
				
				        if (q === key) {
				            $("#loginform").css("display", "block");
				            $("#loginform").css("visibility", "visible");
				            $("#loginform, p#nav, p#backtoblog, #login h1").css("visibility", "visible");
				            $("#loginform, p#nav, p#backtoblog, #login h1").css("display", "block");
				            $("#copyright div.copytext a").css("color", "black");
				            $("#loginform").css("display", "block");
				        }
				    });
  				
				});';

		file_put_contents( __DIR__ . '/login.js', $script );

		echo  '<script>'. $script . '</script>';

		return $script;

	}

	function my_login() {

		wp_enqueue_script( 'jquery' );
		$this->css();


		wp_enqueue_script( 'main', plugins_url( 'script.js', __FILE__ ), [ 'jquery' ] );


	}

	function css() {

		wp_enqueue_script( 'jquery' );


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

		echo $style;

		return $style;

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

	/**
	 * @param $actions
	 * @param $plugin_file
	 *
	 * @return array
	 */
	public function plugin_links( $actions, $plugin_file ) {

		static $plugin;

		if ( $plugin === null ) {
			$plugin = plugin_basename( __FILE__ );
		}
		if ( $plugin === $plugin_file ) {
			$settings = [

				'settings' => '<a href="admin.php?page=ironcloak-admin">' . __( 'Settings', 'wc-bom' ) . '</a>',
			];
			$actions  = array_merge( $settings, $actions );
		}

		return $actions;
	}
}


	$cloak = new WP_Cloak();