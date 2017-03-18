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
	
	// Switch function triggered through html
	public function do_switch(){
		add_action('admin_init', array($this , 'set_debug_status_on');
		if(is_admin() && current_user_can('administrator')){

			$response = $array();
			// strengthen security by checking the nonce
			//if (check_ajax_referer( 'debug-nonce', 'nonce' )){
				// Check the debug status
				$debug_status = WP_DEBUG;

				// change the debug status
				if($debug_status){
					set_debug_status_status(false);
				}else if (!$debug_status){
					set_debug_status_status(true);
				}

			//}
				
			$data = array("debug_status" => $debug_status); 

			header( "Content-Type: application/json" );
			echo json_encode($data);

			// Always die in functions echoing Ajax content die();
			die();
		}
	}
	// enqueue scripts 
	public function do_enqueue_scripts() {

		// first, check to see if jquery-ui is already loaded 
		if( !wp_script_is('jquery-ui') ) { 
		    wp_enqueue_script( 'jquery-ui' , 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js' );
		}  
		wp_enqueue_script('switch-button', plugin_dir_url( __FILE__ ). 'views/js/jquery.switchButton.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script('do-script', plugin_dir_url( __FILE__ ). 'views/js/debug-on.js', array('jquery'), null, true );

		wp_localize_script('do-script','ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajaxnonce')
			));
	}

	// enqueue styles 
	public function do_enqueue_styles() {
		wp_enqueue_style('do-style', plugin_dir_url( __FILE__ ). 'views/css/debug-on.css');
	}

	// debug status setters
	public function set_debug_status($status){
		if(is_bool($status)){
			
			if($status){
				
				// add_option( 'myhack_extraction_length', '255', '', 'yes' );  

			}else{

			}
		}
	}

}

// Create an instance of our class to kick off the whole thing
$debugOn = new DebugOn();