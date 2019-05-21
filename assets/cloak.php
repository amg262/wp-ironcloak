<?php
/*
 * Copyright (c) 2019.
 * Andrew M. Gunn  |  andrewmgunn26@gmail.com
 * github.com/amg262  |
 */


define('SETTINGS_URL', 'ironcloak-admin');



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
	protected WP_User $user;
	protected $now, $time;
	protected DateTime $date;


	/**
	 * WP_Cloak constructor.
	 */
	public function __construct() {

		// your code
		$this->settings = get_option( 'wcb_settings' );
		$this->data     = get_option( 'wcb_data' );
		$user_id        = get_current_user_id();
		$user           = new WP_User( $user_id );
		$username       = $user->user_login;
		$now            = current_time( 'Y-m-d H:i:s' );

	}


	function css() {

		$var = '<style>
			#loginform, p#nav, p#backtoblog, #login h1 {
				display:    none !important;
				visibility: hidden !important;
			}
			#copyright div.copytext a, div.footer-copyright {
				color: #FF2848;
			}
			h2.irc-title {
			text-align: 
			center;padding: 10px;
			}
			</style>';

	}

	function my_login() {

		$opt = get_option( 'wcb_settings' );


		echo '<style>' . $opt['css'] . '</style>';
		echo '<h1 class="irc-title">' . $opt['html'] . '</h1>';

		if ( $opt['ip'] === 'yes' ) {
			echo '<h2 class="irc-title">' . $_SERVER['REMOTE_ADDR'] . '</h2>';
		}
	}

	/**
	 *
	 */
	public function run() {

		add_option( 'wcb_data', false );


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
	public function plugin_links( $actions, $plugin_file ) {

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