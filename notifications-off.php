<?
/**
 * Plugin Name: Notifications Off
 * Plugin URI: https://github.com/samuelguebo/notifications-off
 * Description: This plugin allows you to easily turn off and on notifications in WordPress dashboard.
 * Version: 0.0.1
 * Author: Samuel Guebo
 * Author URI: https://github.com/samuelguebo/
 * License: GPL3
 */

// make sure it's not accessed directly
defined( 'ABSPATH' ) or die( 'You are not going any further!' );

include ('class.notifications-off-menu.php'); // dependenci

Class NotificationsOff{

	// add Actions hooks in the constructor

	public function __construct() {
		add_action( "admin_menu", array( $this, "no_enqueue_scripts") );
		add_action( "admin_menu", array( $this, "no_enqueue_styles") );
		add_action( "admin_head", array( $this, "no_hide_notifications") );

		add_action("wp_ajax_no_switch", array( $this, "no_switch")) ;
		register_uninstall_hook( __FILE__, array($this, "no_uninstall" ));

		
		// setting up the menu
		$NotificationsOffMenu = new NotificationsOffMenu;
		add_action( "admin_menu", array($NotificationsOffMenu, 'create_menu') );
	}
	
	// Switch function triggered through html
	public function no_switch(){

		
		//if(is_admin() && current_user_can('administrator')){

			//$data = array();
			// strengthen security by checking the nonce
			//if (check_ajax_referer( 'notifications-nonce', 'nonce' )){

				$notifications_status = get_option( 'no_notifications_status' );


				if( $notifications_status === 'on' ){
					update_option( 'no_notifications_status', 'off'); 
				}else if ( $notifications_status === 'off' ){
					update_option( 'no_notifications_status', 'on'); 
				}

				//if(is_bool($status) === true){


			// set the default value
			
			
			

			//}
				
			$data = array("notifications_status" => $notifications_status); 

			header( "Content-Type: application/json" );
			echo json_encode($data);

			// Always die in functions echoing Ajax content die();
			die();
		//}

		
	}
	// enqueue scripts 
	public function no_enqueue_scripts() {

		// first, check to see if jquery-ui is already loaded 
		if( !wp_script_is('jquery-ui') ) { 
			wp_enqueue_script( 'jquery-ui' , 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js' );
		}  
		wp_enqueue_script('switch-button', plugin_dir_url( __FILE__ ). 'views/js/jquery.switchButton.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script('do-script', plugin_dir_url( __FILE__ ). 'views/js/notifications-off.js', array('jquery'), null, true );

		wp_localize_script('do-script','ajax_var', array(
			'url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('ajaxnonce')
			));
	}

	// enqueue styles 
	public function no_enqueue_styles() {
		wp_enqueue_style('do-style', plugin_dir_url( __FILE__ ). 'views/css/notifications-off.css');
	}


	// removing or enabling notifications, the functions will be hooked into admin_head 
	public function no_hide_notifications(){
		//if(! current_user_can('update_core')){return;}
	
		
		$notifications_status = sanitize_text_field(get_option( 'no_notifications_status' ));
		
		if( $notifications_status === 'off' ){
			
			if (current_user_can('update_core')) {
		        remove_action( 'admin_notices', 'update_nag', 3 );
				remove_action( 'network_admin_notices', 'update_nag', 3 );

				// if all the above fail, remove the notices section via css
				echo "<style> #wpbody-content .notice, .update-nag , .error, .updated{ display:none !important; } </style>";
    		}
		}elseif ($notifications_status === 'on') {
			// do nothing
		}else{
			delete_option( 'no_notifications_status' );
		}

		// Set the inital value if no option is set
		if (FALSE === get_option('no_notifications_status')) {
			add_option('no_notifications_status', 'off');
		}
	}

	public function no_uninstall(){
		delete_option( 'no_notifications_status' );
	}		

}

// Create an instance of our class to kick off the whole thing
$NotificationsOff = new NotificationsOff();