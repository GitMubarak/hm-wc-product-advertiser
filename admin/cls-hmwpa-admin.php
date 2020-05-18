<?php
/**
*	Admin Parent Class
*/
class HMWPA_Admin 
{	
	private $hmwpa_version;
	private $hmwpa_assets_prefix;

	function __construct( $version ){
		$this->hmwpa_version = $version;
		$this->hmwpa_assets_prefix = substr(HMWPA_PRFX, 0, -1) . '-';
	}
	
	/**
	*	Loading the admin menu
	*/
	public function hmwpa_admin_menu(){
		
		add_menu_page(	esc_html__('WC Prodcut Adv', HMWPA_TXT_DOMAIN),
						esc_html__('WC Prodcut Adv', HMWPA_TXT_DOMAIN),
						'manage_options',
						'hmwpa-admin-panel',
						array( $this, HMWPA_PRFX . 'load_admin_panel' ),
						'',
						100 
					);
	}
	
	/**
	*	Loading admin panel assets
	*/
	function hmwpa_enqueue_assets(){
		if (isset($_GET['page']) && $_GET['page'] == 'hmwpa-admin-panel'){
			wp_enqueue_style(
								$this->hmwpa_assets_prefix . 'admin-style',
								HMWPA_ASSETS . 'css/' . $this->hmwpa_assets_prefix . 'admin-style.css',
								array(),
								$this->hmwpa_version,
								FALSE
							);
			
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');

			if ( !wp_script_is( 'jquery' ) ) {
				wp_enqueue_script('jquery');
			}
			wp_enqueue_script(
								$this->hmwpa_assets_prefix . 'admin-script',
								HMWPA_ASSETS . 'js/' . $this->hmwpa_assets_prefix . 'admin-script.js',
								array('jquery'),
								$this->hmwpa_version,
								TRUE
							);
			$hmwpaAdminArray = array(
				'hmwpaIdsOfColorPicker' => array('#hmwpa_post_title_color', '#hmwpa_parent_border_color', '#hmwpa_background_color')
			);
			
			// handler, jsObject, data
			wp_localize_script( 'hmwpa-admin-script', 'hmwpaAdminScript', $hmwpaAdminArray );
		}
	}
	
	/**
	*	Loading admin panel view/forms
	*/
	function hmwpa_load_admin_panel(){
		require_once HMWPA_PATH . 'admin/view/' . $this->hmwpa_assets_prefix . 'settings.php';
	}

	protected function hmwpa_display_notification($type, $msg){ ?>
		<div class="hmwpa-alert <?php printf('%s', $type); ?>">
			<span class="hmwpa-closebtn">&times;</span> 
			<strong><?php esc_html_e(ucfirst($type), HMWPA_TXT_DOMAIN); ?>!</strong> <?php esc_html_e($msg, HMWPA_TXT_DOMAIN); ?>
		</div>
	<?php }
}
?>