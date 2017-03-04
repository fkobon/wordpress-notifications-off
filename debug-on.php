<?
/**
 * Plugin Name: Debug On
 * Plugin URI: https://github.com/samuelguebo/debug-on
 * Description: This plugin allows you to easily turn on and off the debug mode in WordPress.
 * Version: 0.0.1
 * Author: Samuel Guebo
 * Author URI: https://github.com/samuelguebo/
 * License: GPL3
 */

// make sure it's not accessed directly
defined( 'ABSPATH' ) or die( 'You are not going any further!' );

include ('class-debug-on-menu.php'); // dependenci

Class DebugOn{

	// add Actions hooks in the constructor

	public function __construct() {
		add_action( "admin_menu", array( $this, "do_enqueue_scripts") );
		add_action( "admin_menu", array( $this, "do_enqueue_styles") );

		add_action("wp_ajax_do_add_domain_content", array( $this, "do_switch")) ;

		
		// setting up the menu
		$DebugOnMenu = new DebugOnMenu;
		add_action( "admin_menu", array($DebugOnMenu, 'create_menu') );
	}
	
	// Switch option via Ajax
	public function do_switch(){
		if(is_admin()){
			
			// 1. Sanitize and check data

			// 2. Check if the option is already set

			// 3. Save option to wordpress
		}
	}
	// enqueue scripts 
	public function do_enqueue_scripts() {
		wp_enqueue_script('do-script', plugin_dir_url( __FILE__ ). 'views/js/debug-on.js', array('jquery'), null, true );
		wp_enqueue_script('switch-button', plugin_dir_url( __FILE__ ). 'views/js/jquery.switchButton.js', array('jquery'), null, true );
		wp_enqueue_script('	jquery-ui-core');

		wp_localize_script('do-script','ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajaxnonce')
			));
	}

	// enqueue styles 
	public function do_enqueue_styles() {
		wp_enqueue_style('do-style', plugin_dir_url( __FILE__ ). 'views/css/debug-on.css');
		wp_enqueue_style('do-font-awesome', plugin_dir_url( __FILE__ ). 'views/css/font-awesome.min.css');
	}

}

// Create an instance of our class to kick off the whole thing
$debugOn = new DebugOn();