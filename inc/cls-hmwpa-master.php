<?php
/**
 * Our main plugin class
*/
class HMWPA_Master {

	protected $hmwpa_loader;
	protected $hmwpa_version;

	/**
	 * Class Constructor
	*/
	function __construct(){
		$this->hmwpa_version = HMWPA_VERSION;
		$this->hmwpa_load_dependencies();
		$this->hmwpa_trigger_admin_hooks();
		$this->hmwpa_trigger_front_hooks();
	}

	private function hmwpa_load_dependencies(){
		require_once HMWPA_PATH . 'admin/' . HMWPA_CLS_PRFX . 'admin.php';
		require_once HMWPA_PATH . 'front/' . HMWPA_CLS_PRFX . 'front.php';
		require_once HMWPA_PATH . 'inc/' . HMWPA_CLS_PRFX . 'loader.php';
		$this->hmwpa_loader = new HMWPA_Loader();
	}

	private function hmwpa_trigger_admin_hooks(){
		$hmwpa_admin = new HMWPA_Admin($this->hmwpa_version());
		$this->hmwpa_loader->add_action( 'admin_menu', $hmwpa_admin, HMWPA_PRFX . 'admin_menu' );
		$this->hmwpa_loader->add_action( 'admin_enqueue_scripts', $hmwpa_admin, HMWPA_PRFX . 'enqueue_assets' );
	}

	function hmwpa_trigger_front_hooks(){
		$hmwpa_front = new HMWPA_Front($this->hmwpa_version());
		$this->hmwpa_loader->add_action( 'wp_enqueue_scripts', $hmwpa_front, HMWPA_PRFX . 'front_assets' );
		$this->hmwpa_loader->add_action( 'wp_ajax_load_scroll_post', $hmwpa_front, HMWPA_PRFX . 'load_scroll_post' );
		$this->hmwpa_loader->add_action( 'wp_ajax_nopriv_load_scroll_post', $hmwpa_front, HMWPA_PRFX . 'load_scroll_post' );
		$this->hmwpa_loader->add_action( 'wp_footer', $hmwpa_front, HMWPA_PRFX . 'load_view' );
	}

	function hmwpa_run(){
		$this->hmwpa_loader->hmwpa_run();
	}

	function hmwpa_version(){
		return $this->hmwpa_version;
	}

	function hmwpa_unregister_settings(){
		global $wpdb;
	
		$tbl = $wpdb->prefix . 'options';
		$search_string = HMWPA_PRFX . '%';
		
		$sql = $wpdb->prepare( "SELECT option_name FROM $tbl WHERE option_name LIKE %s", $search_string );
		$options = $wpdb->get_results( $sql , OBJECT );
	
		if(is_array($options) && count($options)) {
			foreach( $options as $option ) {
				delete_option( $option->option_name );
				delete_site_option( $option->option_name );
			}
		}
	}
}
?>
