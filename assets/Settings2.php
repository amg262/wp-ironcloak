<?php
/**
 * Copyright (c) 2019.
 * Andrew M. Gunn  |  andrewmgunn26@gmail.com
 * github.com/amg262  |
 */

/**
 * WordPress settings API demo class
 *
 * @author Tareq Hasan
 */


class Settings2 {

	private $settings_api;

	function __construct() {

		require __DIR__ . '/SettingsAPI.php';
		$this->settings_api = new SettingsAPI();

		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	function admin_init() {

		//set the settings
		$this->settings_api->set_sections( $this->get_settings_sections() );
		$this->settings_api->set_fields( $this->get_settings_fields() );

		//initialize settings
		$this->settings_api->admin_init();

	}

	function get_settings_sections() {

		$sections = [

			[
				'id'    => 'wcb_settings',
				'title' => __( 'Data', 'wedevs' ),
			],
			[
				'id'    => 'wcb_settings',
				'title' => __( 'Settings', 'wedevs' ),
			],
			[
				'id'    => 'wcb_styles',
				'title' => __( 'Styles', 'wedevs' ),
			],

		];

		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	function get_settings_fields() {

		//var_dump( get_option( 'wcb_settings' ) );

		//var_dump( get_option( 'wcb_settings' ) );

		$opt = get_option( 'wcb_settings' );



//
//		echo ($aa * (30 * HOUR_IN_SECONDS));
//
//		echo $t->format($t,'d.m.Y H:i:s');
//		$dd = date('d.m.Y H:i:s');
//
//		$d = date('H:i:s');
//
//		echo $t;
//		echo $d;
		//$key             = ( $opt['key2'] !== '' ) ? $opt['key2'] : 'stalin';
		$settings_fields = [

			'wcb_settings' => [

				[
					'name'  => 'key2',
					'label' => __( 'Secret Key', 'wedevs' ),
					'desc'  => __( '<i>http://rbrvs.net/?cloak=on&<b>key=</b> *this field </i>', 'wedevs' ),
					'type'  => 'text',
					'default' => '',
					//'sanitize_callback' => 'intval',
				],

				[
					'name'    => 'radio',
					'label'   => __( 'Enable Cloak on Log Out', 'wedevs' ),
					'desc'    => __( 'Enable Cloak on Log Out', 'wedevs' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],
				[
					'name'    => 'ip',
					'label'   => __( 'Show IP', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'select',
					'options' => [
						'yes' => 'Yes',
						'no'  => 'No',
					],
				],

				[
					'name'    => 'email',
					'label'   => __( 'Set emails to get update notifications', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'text',
					'default' => 'andrewmgunn26@gmail.com',
					//'sanitize_callback' => 'intval',
				],

				[
					'name'              => 'number_input2',
					'label'             => __( 'Minutes', 'wedevs' ),
					'desc'              => __( $this->get_n( ($opt['number_input2'] / 60)), 'wedevs' ),
					'type'              => 'text',
					'default'           => 60,
					'sanitize_callback' => '',
				],
				[
					'name'    => 'selectbox',
					'label'   => __( 'A Dropdown', 'wedevs' ),
					'desc'    => __( 'Dropdown description', 'wedevs' ),
					'type'    => 'select',
					'default' => 'no',
					'options' => [
						$this->get_n( ($opt['number_input2'] / 60), 'H:i:s') => $this->get_n( ($opt['number_input2'] / 60), 'H:i:s'),
					],
				],



				[
					'name'              => 'key2',
					'label'             => __( 'Secret Key', 'wedevs' ),
					'desc'              => __( '<i>http://rbrvs.net/?cloak=on&<b>key=</b> *this field </i>', 'wedevs' ),
					'type'              => 'number',
					'default'           => 1,
					'sanitize_callback' => 'intval',
				],
//				[
//					'name'    => 'event',
//					'label'   => __( localtime(), 'wedevs' ),
//					'desc'    => __( '', 'wedevs' ),
//					'type'    => 'radio',
//					'options' => [
//						$this->get_n( 0, 'H:i:s' ) => $this->get_n( 0 ),
//						$this->get_n( .25 )        => $this->get_n( .25 ),
//
//						$this->get_n( .55 ) => $this->get_n( .55 ),
//						$this->get_n( 1 )   => $this->get_n( 1 ),
//
//						$this->get_n( 1.25 ) => $this->get_n( 1.25 ),
//						$this->get_n( 1.4 )  => $this->get_n( 1.4 ),
//						'none'               => 'none',
//
//
//					],
//				],

				[
					'name'    => 'color',
					'label'   => __( 'Color', 'wedevs' ),
					'desc'    => __( 'Color description', 'wedevs' ),
					'type'    => 'color',
					'default' => '',
				], [
				'name'    => 'color2',
				'label'   => __( 'Color', 'wedevs' ),
				'desc'    => __( 'Color description', 'wedevs' ),
				'type'    => 'color',
				'default' => '',
			],
				[
					'name'    => 'css',
					'label'   => __( 'CSS', 'wedevs' ),
					'desc'    => __( 'WP_Editor description', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],
				[
					'name'    => 'html',
					'label'   => __( 'HTML', 'wedevs' ),
					'desc'    => __( '', 'wedevs' ),
					'type'    => 'wysiwyg',
					'default' => '',
				],

//				[
//					'name'    => 'radio',
//					'label'   => __( 'Radio Button', 'wedevs' ),
//					'desc'    => __( 'A radio button', 'wedevs' ),
//					'type'    => 'radio',
//					'options' => [
//						'yes' => 'Yes',
//						'no'  => 'No',
//					],
//				],
//				[
//					'name'    => 'multicheck',
//					'label'   => __( 'Multile checkbox', 'wedevs' ),
//					'desc'    => __( 'Multi checkbox description', 'wedevs' ),
//					'type'    => 'multicheck',
//					'options' => [
//						'one'   => 'One',
//						'two'   => 'Two',
//						'three' => 'Three',
//						'four'  => 'Four',
//					],
//				],
//
//				[
//					'name'    => 'password',
//					'label'   => __( 'Password', 'wedevs' ),
//					'desc'    => __( 'Password description', 'wedevs' ),
//					'type'    => 'password',
//					'default' => '',
//				],
//				[
//					'name'    => 'file',
//					'label'   => __( 'File', 'wedevs' ),
//					'desc'    => __( 'File description', 'wedevs' ),
//					'type'    => 'file',
//					'default' => '',
//					'options' => [
//						'button_label' => 'Choose Image',
//					],
//				],
//				[
//					'name'    => 'color',
//					'label'   => __( 'Color', 'wedevs' ),
//					'desc'    => __( 'Color description', 'wedevs' ),
//					'type'    => 'color',
//					'default' => '',
//				],
//				[
//					'name'    => 'wysiwyg',
//					'label'   => __( 'Advanced Editor', 'wedevs' ),
//					'desc'    => __( 'WP_Editor description', 'wedevs' ),
//					'type'    => 'wysiwyg',
//					'default' => '',
//				],
//				[
//					'name'    => 'file',
//					'label'   => __( 'File', 'wedevs' ),
//					'desc'    => __( 'File description', 'wedevs' ),
//					'type'    => 'file',
//					'default' => '',
//				],
//				[
//					[
//						'name'    => 'text',
//						'label'   => __( 'Text Input', 'wedevs' ),
//						'desc'    => __( 'Text input description', 'wedevs' ),
//						'type'    => 'text',
//						'default' => 'Title',
//					],
//					[
//						'name'  => 'textarea',
//						'label' => __( 'Textarea Input', 'wedevs' ),
//						'desc'  => __( 'Textarea description', 'wedevs' ),
//						'type'  => 'textarea',
//					],
//
//
//				],
//				'wcb_settings2' => [
//
//					[
//						'name'  => 'key2',
//						'label' => __( 'Secret Key', 'wedevs' ),
//						'desc'  => __( '<i>http://rbrvs.net/?cloak=on&<b>key=</b> *this field </i>', 'wedevs' ),
//						'type'  => 'text',
//						//	'default' => $key,
//						//'sanitize_callback' => 'intval',
//					],
//
//					[
//						'name'    => 'radio',
//						'label'   => __( 'Enable Cloak on Log Out', 'wedevs' ),
//						'desc'    => __( 'Enable Cloak on Log Out', 'wedevs' ),
//						'type'    => 'radio',
//						'options' => [
//							'yes' => 'Yes',
//							'no'  => 'No',
//						],
//					],
//
//					[
//						'name'    => 'email',
//						'label'   => __( 'Set emails to get update notifications', 'wedevs' ),
//						'desc'    => __( '', 'wedevs' ),
//						'type'    => 'text',
//						'default' => 'andrewmgunn26@gmail.com',
//						//'sanitize_callback' => 'intval',
//					],
//					[
//						'name'    => 'ip',
//						'label'   => __( 'Show IP', 'wedevs' ),
//						'desc'    => __( '', 'wedevs' ),
//						'type'    => 'radio',
//						'options' => [
//							'yes' => 'Yes',
//							'no'  => 'No',
//						],
//					],
//
//					[
//						'name'              => 'key2',
//						'label'             => __( 'Secret Key', 'wedevs' ),
//						'desc'              => __( '<i>http://rbrvs.net/?cloak=on&<b>key=</b> *this field </i>', 'wedevs' ),
//						'type'              => 'number',
//						'default'           => 1,
//						'sanitize_callback' => 'intval',
//					],
//					[
//						'name'    => 'event',
//						'label'   => __( localtime(), 'wedevs' ),
//						'desc'    => __( '', 'wedevs' ),
//						'type'    => 'radio',
//						'options' => [
//							$this->get_n( 0, 'H:i:s' ) => $this->get_n( 0 ),
//							$this->get_n( .25 )        => $this->get_n( .25 ),
//
//							$this->get_n( .55 ) => $this->get_n( .55 ),
//							$this->get_n( 1 )   => $this->get_n( 1 ),
//
//							$this->get_n( 1.25 ) => $this->get_n( 1.25 ),
//							$this->get_n( 1.4 )  => $this->get_n( 1.4 ),
//							'none'               => 'none',
//
//
//						],
//					],
//					[
//						'name'    => 'css',
//						'label'   => __( 'CSS', 'wedevs' ),
//						'desc'    => __( 'WP_Editor description', 'wedevs' ),
//						'type'    => 'wysiwyg',
//						'default' => '',
//					],
//					[
//						'name'    => 'html',
//						'label'   => __( 'HTML', 'wedevs' ),
//						'desc'    => __( '', 'wedevs' ),
//						'type'    => 'wysiwyg',
//						'default' => '',
//					],


			],

		];

		return $settings_fields;
	}

	function get_n( $int, $format = 'm/d/y h:i:s A' ) {

		$da = new DateTime();

		if ( $int === - 1 ) {
			$tt = time();
		} else {
			$tt = ( time() + ( HOUR_IN_SECONDS * $int ) );
		}

		$ad = $da->setTimestamp( $tt );
		echo $da->format( $format );


		return $da->format( $format );

	}

	function make_key() {

		$file =  (array) file_get_contents(__DIR__.'/words.txt');


		$arr = [];
		$i = 0;
	//	echo $json;
		foreach ($file as $f => $key) {


			$arr[$i] = $key;
			$arr2[] = [$i => $key];




				echo $key;

			$i++;

		}




		//var_dump($arr);

		//var_dump($arr2);


		$json = json_encode($arr);
		$json2 = json_encode($arr2);


		//var_dump($json);


		echo $arr[33];

		//var_dump($json2);

		file_put_contents(__DIR__.'/args.txt', $arr);
		file_put_contents('args2.txt', $ah);



	}

	function admin_menu() {

		echo '';
		add_options_page( 'Iron Curtain', 'Iron Curtain', 'manage_options', 'wp-irc-admin', [
			$this,
			'plugin_page',
		] );
	}

	function plugin_page() {

		echo '<div class="wrap">';

		$this->settings_api->show_navigation();
		$this->settings_api->show_forms();

		echo '</div>';
	}

	/**
	 * Get all the pages
	 *
	 * @return array page names with key value pairs
	 */
	function get_pages() {

		$pages         = get_pages();
		$pages_options = [];
		if ( $pages ) {
			foreach ( $pages as $page ) {
				$pages_options[ $page->ID ] = $page->post_title;
			}
		}

		return $pages_options;
	}

}
