<?
Class DebugOnMenu{
	
	public function __construct() {
		// empty constructor

	}

	public function create_menu() {
		add_menu_page('Debug On Plugin','Debug On','administrator', 'menu-debug-on-home','','dashicons-clipboard');

		add_submenu_page( 'menu-debug-on-home', 'Settings', 'Debug status settings',
			'manage_options', 'menu-debug-on-home', array( $this, "menu_debug_on_home"));
	}

	public function menu_debug_on_home() {
		include plugin_dir_path( __FILE__ ) .'views/debug-on-menu-home.php';
	}
}