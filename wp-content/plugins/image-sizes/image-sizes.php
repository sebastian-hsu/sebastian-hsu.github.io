<?php
/*
Plugin Name: Image Sizes
Description: So, it creates multiple sizes of an image while uploading? Here is the solution!
Plugin URI: https://codebanyan.com
Author: Nazmul Ahsan
Author URI: https://nazmulahsan.me
Version: 1.2.1
License: GPL2
Text Domain: image-sizes
Domain Path: /languages
*/

/*

    Copyright (C) 2016  Nazmul Ahsan  n.mukto@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
* main class for the plugin
*/
class CB_Image_Sizes {
	
	public static $_instance;
	public $name;
	public $version;

	public function __construct() {
		$this->name = 'image-sizes';
		$this->version = '1.2.1';
		self::inc();
		self::hooks();
	}

	public function inc() {
		require dirname( __FILE__ ) . '/admin/image-sizes-settings.php';
	}

	public function hooks(){
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'intermediate_image_sizes_advanced', array( $this, 'image_sizes' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action( 'wp_ajax_imgsz_survey', array( $this, 'survey' ) );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
	}

	/**
	 * Trigger when activates
	 *
	 * @since 1.1
	 */
	public function activate() {
		
		if( get_option( 'imgsz_survey_agreed' ) == 1 ) :
		
		$base_url = 'https://codebanyan.com';

		$params = array(
			'item'			=> 'image-sizes',
			'siteurl'		=> explode( '://', get_option( 'siteurl' ) )[1],
			'is_active'		=> 1,
		);

		$endpoint = add_query_arg( $params, $base_url );
		@file_get_contents( $endpoint );
		
		endif;
	}

	/**
	 * Trigger when deactivates
	 *
	 * @since 1.1
	 */
	public function deactivate() {
		if( get_option( 'imgsz_survey_agreed' ) == 1 ) :
		
		$base_url = 'https://codebanyan.com';

		$params = array(
			'item'			=> 'image-sizes',
			'siteurl'		=> explode( '://', get_option( 'siteurl' ) )[1],
			'is_active'		=> 0,
		);

		$endpoint = add_query_arg( $params, $base_url );
		@file_get_contents( $endpoint );
		
		endif;
	}

	/**
	 * Enqueue CSS and JS files
	 *
	 * @since 1.1
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->name, plugins_url( 'assets/js/script.js', __FILE__ ), array( 'jquery' ), $this->version, true );
	}

	/**
	 * unset image size(s)
	 *
	 * @since 1.0
	 */
	public function image_sizes( $sizes ){
		$disables = mdc_get_option( 'disables', 'prevent_image_sizes' ) ? : array();
		if( count( $disables ) ) :
		foreach( $disables as $disable ){
			unset( $sizes[ $disable ] );
		}
		endif;
		return $sizes;
	}

    /**
     * Show admin notices
     *
     * @since 1.1
     */
    public function admin_notices() {
        if( get_option( 'imgsz_survey' ) != 1 ) :
        ?>
        <div class="notice notice-success is-dismissible imgsz-survey-notice survey-notice">
            <p>
                <p><strong><?php _e( 'Help us improve your experience', 'image-sizes' ); ?></strong></p>
                <span><?php _e( 'We want to know what types of sites use our plugin. So that we can improve <strong>Image Sizes</strong> accordingly. Help us with your site URL and a few basic information. It doesn\'t include your password or any kind of sercret data. Would you like to help us?', 'image-sizes' ); ?></span>
            </p>
            <p>
                <button class="button button-primary imgsz-survey" data-participate="1"><?php _e( 'Okay! Don\'t bother me again.', 'image-sizes' ); ?></button>
            </p>
        </div>
        <?php
        endif;
    }

	/**
	 * Gather user data
	 *
	 * @since 1.1
	 */
	public function survey() {
		if( isset( $_POST['participate'] ) && $_POST['participate'] == 1 ) {
			$base_url = 'https://codebanyan.com';

			$params = array(
				'init'			=> 1,
				'item'			=> 'image-sizes',
				'siteurl'		=> explode( '://', get_option( 'siteurl' ) )[1],
				'admin_email'	=> get_option( 'admin_email' ),
			);

			echo $endpoint = add_query_arg( $params, $base_url );
			@file_get_contents( $endpoint );
			update_option( 'imgsz_survey_agreed', 1 );
		}

		update_option( 'imgsz_survey', 1 );
		wp_die();
	}

	/**
	 * i18n
	 *
	 * @since 1.1
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'image-sizes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}
	
	/**
	 * Instantiate the plugin
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

CB_Image_Sizes::instance();