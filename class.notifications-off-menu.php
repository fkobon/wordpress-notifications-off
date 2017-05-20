<?
Class NotificationsOffMenu{
	
	public function __construct() {
		// empty constructor

	}

	public function create_menu() {
		add_menu_page( 'Notifications Off Plugin',
			'Notifications Off','administrator', 
			'menu-notifications-off-home',
			'',
			plugin_dir_url( __FILE__ ) .'views/img/menu-icon.png'
		);

		add_submenu_page( 'menu-notifications-off-home', 
			'Settings', 'Notifications status settings',
			'manage_options', 
			'menu-notifications-off-home', 
			array( $this, "menu_notifications_off_home")
		);
	}

	public function menu_notifications_off_home() {
		include plugin_dir_path( __FILE__ ) .'views/menu-home.php';
	}
}