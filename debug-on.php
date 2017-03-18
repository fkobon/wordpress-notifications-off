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
		add_action( "admin_menu", array( $this, "do_get_debug_status") );

		add_action("wp_ajax_do_switch", array( $this, "do_switch")) ;

		
		// setting up the menu
		$DebugOnMenu = new DebugOnMenu;
		add_action( "admin_menu", array($DebugOnMenu, 'create_menu') );
	}
	
	// Switch function triggered through html
	public function do_switch(){

		
		//if(is_admin() && current_user_can('administrator')){

			//$data = array();
			// strengthen security by checking the nonce
			//if (check_ajax_referer( 'debug-nonce', 'nonce' )){
				// Check the debug status
				if (FALSE === get_option('do_debug_status')) {
					add_option('do_debug_status', 'disactivated');
				}

				$debug_status = get_option( 'do_debug_status' );


				if( $debug_status === 'activated' ){
					update_option( 'do_debug_status', 'disactivated'); 
				}else if ( $debug_status === 'disactivated' ){
					update_option( 'do_debug_status', 'activated'); 
				}

				//if(is_bool($status) === true){


			// set the default value
			
			
			

			//}
				
			$data = array("debug_status" => $debug_status); 

			header( "Content-Type: application/json" );
			echo json_encode($data);

			// Always die in functions echoing Ajax content die();
			die();
		//}

		
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

	// debug status get to be hooked into 
	public function do_get_debug_status(){
		//if(! current_user_can('update_core')){return;}
	
		
		$debug_status = sanitize_text_field(get_option( 'do_debug_status' ));
		
		if( $debug_status === 'activated' ){
			define('WP_DEBUG', true);
		}else if ( $debug_status === 'disactivated' ){
			// disallow notifications
		}
		
	}	

}

// Create an instance of our class to kick off the whole thing
$debugOn = new DebugOn();