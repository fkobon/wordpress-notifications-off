<?
Class DebugOnMenu{
	
	public function __construct() {
		// empty constructor

	}

	public function create_menu() {
		add_menu_page('Debug On Plugin','Debug On','administrator', 'menu-domain-home','','dashicons-admin-site');

		add_submenu_page( 'menu-domain-home', 'Settings', 'Domain Monitor settings',
			'manage_options', 'menu-domain-home', array( $this, "menu_domain_home"));
	}

	public function menu_domain_home() {
		include plugin_dir_path( __FILE__ ) .'views/domain-menu-home.php';
	}
}