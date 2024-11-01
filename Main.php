<?php
/*
Plugin Name: WC Tabs and Custom Fields
Plugin URI: http://www.EtoileWebDesign.com/plugins/woocommerce-tabs-and-custom-fields/
Description: Create custom tabs, re-arrange default ones, and create custom fields for product filtering
Author: Etoile Web Design
Author URI: http://www.EtoileWebDesign.com/
Terms and Conditions: http://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: EWD_WCTCF
Version: 0.1
*/

global $ewd_wctcf_message;
global $WCTCF_Full_Version;

$EWD_WCTCF_Version = '1.1.0';

define( 'EWD_WCTCF_CD_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'EWD_WCTCF_CD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

//define('WP_DEBUG', true);

register_activation_hook(__FILE__,'Set_EWD_WCTCF_Options');
register_activation_hook(__FILE__,'EWD_WCTCF_Create_Default_Tabs');

/* Hooks neccessary admin tasks */
if ( is_admin() ){
	add_action('admin_head', 'EWD_WCTCF_Admin_Options');
	add_action('widgets_init', 'Update_EWD_WCTCF_Content');
	add_action('admin_notices', 'EWD_WCTCF_Error_Notices');
}

function EWD_WCTCF_Enable_Sub_Menu() {
	//add_submenu_page('edit.php?post_type=product', 'WCTCF Tabs', 'Tabs', 'edit_posts', 'wctcf-tabs', 'EWD_WCTCF_Output_Tabs_Page');
	add_submenu_page('edit.php?post_type=product', 'WCTCF Fields', 'Custom Fields', 'edit_posts', 'wctcf-custom-fields', 'EWD_WCTCF_Output_Custom_Fields_Page');
}
add_action('admin_menu' , 'EWD_WCTCF_Enable_Sub_Menu');

/* Add localization support */
function EWD_WCTCF_localization_setup() {
		load_plugin_textdomain('EWD_WCTCF', false, dirname(plugin_basename(__FILE__)) . '/lang/');
}
add_action('after_setup_theme', 'EWD_WCTCF_localization_setup');

add_action( 'admin_enqueue_scripts', 'Add_EWD_WCTCF_Scripts', 10, 1 );
function Add_EWD_WCTCF_Scripts($hook) {
	global $post;

	if (isset($_GET['post_type']) && $_GET['post_type'] == 'wc_tab') {
		wp_enqueue_script(  'jquery-ui-core' );
       	wp_enqueue_script(  'jquery-ui-sortable' );
		$url_one = plugins_url("js/ewd-wctcf-admin-js.js", __FILE__);
		wp_enqueue_script('wctcf-admin', $url_one, array('jquery', 'jquery-ui-core', 'jquery-ui-sortable'));
		wp_enqueue_script('spectrum', plugins_url("js/spectrum.js", __FILE__), array('jquery'));
	}

    if ($hook == 'edit.php' or $hook == 'post-new.php' or $hook == 'post.php') {
        if ($post->post_type == 'product') {     
			wp_enqueue_script('spectrum', plugins_url("js/ewd-wctcf-wc-product-admin-js.js", __FILE__, array('jquery')));
		}
	}
}

add_action( 'wp_enqueue_scripts', 'Add_EWD_WCTCF_FrontEnd_Scripts' );
function Add_EWD_WCTCF_FrontEnd_Scripts() {
	wp_register_script('ewd-wctcf-js', plugins_url( '/js/ewd-wctcf-js.js' , __FILE__ ), array( 'jquery' ));	
	wp_enqueue_script('ewd-wctcf-js');
}


add_action( 'wp_enqueue_scripts', 'EWD_WCTCF_Add_Stylesheet' );
function EWD_WCTCF_Add_Stylesheet() {
    global $WCTCF_Full_Version;

    wp_register_style( 'ewd-wctcf-style', plugins_url('css/ewd-wctcf-product-page.css', __FILE__) );
    wp_enqueue_style( 'ewd-wctcf-style' );
}

function EWD_WCTCF_Admin_Options() {
	wp_enqueue_style( 'ewd-wctcf-admin', plugins_url("css/Admin.css", __FILE__));
	wp_enqueue_style( 'spectrum', plugins_url("css/spectrum.css", __FILE__));
}

add_action('activated_plugin','save_wctcf_error');
function save_wctcf_error(){
		update_option('plugin_error',  ob_get_contents());
		file_put_contents("Error.txt", ob_get_contents());
}

function Set_EWD_WCTCF_Options() {
	if (get_option("EWD_WCTCF_Full_Version") == "") {update_option("EWD_WCTCF_Full_Version", "Yes");}
	if (get_option("EWD_WCTCF_Install_Flag") == "") {update_option("EWD_WCTCF_Install_Flag", "Yes");}
}

$WCTCF_Full_Version = get_option("EWD_WCTCF_Full_Version");

if (isset($_POST['Upgrade_To_Full'])) {
	add_action('admin_init', 'EWD_WCTCF_Upgrade_To_Full');
}

include "Functions/Error_Notices.php";
include "Functions/EWD_WCTCF_Add_Tabs_Columns.php";
include "Functions/EWD_WCTCF_Add_WC_Admin_Product_Tabs.php";
include "Functions/EWD_WCTCF_Create_WC_Product_Page_Tabs.php";
include "Functions/EWD_WCTCF_Output_Custom_Fields_Page.php";
include "Functions/EWD_WCTCF_Output_Tabs_Page.php";
include "Functions/EWD_WCTCF_Process_Ajax.php";
include "Functions/EWD_WCTCF_Save_Post_Meta.php";
include "Functions/Register_EWD_WCTCF_Posts_Taxonomies.php";
include "Functions/Update_EWD_WCTCF_Admin_Databases.php";
include "Functions/Update_EWD_WCTCF_Content.php";

if ($EWD_WCTCF_Version != get_option('EWD_WCTCF_Version')) {
	Set_EWD_WCTCF_Options();
	//EWD_WCTCF_Version_Update();
}
?>