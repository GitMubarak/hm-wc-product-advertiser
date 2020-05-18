<?php
/**
 * Plugin Name:	HM Wc Product Advertiser
 * Plugin URI:	http://wordpress.org/plugins/hm-wc-product-advertiser/
 * Description:	This plugin will display product randomly at the bottom right corner when scroll down your browser.
 * Version:		1.1
 * Author:		Hossni Mubarak
 * Author URI:	http://www.hossnimubarak.com
 * License:		GPL-2.0+
 * License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'HMWPA_PATH', plugin_dir_path( __FILE__ ) );
define( 'HMWPA_ASSETS', plugins_url( '/assets/', __FILE__ ) );
define( 'HMWPA_SLUG', plugin_basename( __FILE__ ) );
define( 'HMWPA_PRFX', 'hmwpa_' );
define( 'HMWPA_CLS_PRFX', 'cls-hmwpa-' );
define( 'HMWPA_TXT_DOMAIN', 'hm-wc-product-advertiser' );
define( 'HMWPA_VERSION', '1.1' );

require_once HMWPA_PATH . 'inc/' . HMWPA_CLS_PRFX . 'master.php';
$hmwpa = new HMWPA_Master();
$hmwpa->hmwpa_run();
register_deactivation_hook( __FILE__, array($hmwpa, HMWPA_PRFX . 'unregister_settings') );
