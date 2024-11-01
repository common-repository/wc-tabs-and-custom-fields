<?php

function EWD_WCTCF_Update_Tabs_Order() {
	$IDs = json_decode(stripslashes($_POST['IDs']));
	if (!is_array($IDs)) {$IDs = array();}

	foreach ($IDs as $Order => $Post_ID) {
		update_post_meta($Post_ID, 'EWD_WCTCF_Tab_Order', $Order+1);
	}

}
add_action('wp_ajax_ewd_wctcf_tabs_update_order', 'EWD_WCTCF_Update_Tabs_Order');

function EWD_WCTCF_Update_Tab_Visibility() {
	$visbility = $_POST['visbility'];
	$postid = $_POST['postid'];

	update_post_meta($postid, 'wctcf_tab_visbility', $visbility);
}
add_action('wp_ajax_ewd_wctcf_tabs_update_visbility', 'EWD_WCTCF_Update_Tab_Visibility');

function EWD_WCTCF_Save_Custom_Field_Post_Data() {
	$CF_Array = json_decode(stripslashes($_POST['CF_Array']));
	if (!is_array($CF_Array)) {$CF_Array = array();}
	$Post_ID = $_POST['Post_ID'];

	foreach ($CF_Array as $Custom_Field) {
		update_post_meta($Post_ID, 'EWD_WCTCF_' . $Custom_Field->ID, $Custom_Field->Value);
		update_post_meta($Post_ID, 'EWD_WCTCF_' . $Custom_Field->ID . '_Toggle', $Custom_Field->Toggle);
		if ($Custom_Field->Toggle) {update_post_meta($Post_ID, 'EWD_WCTCF_' . $Custom_Field->ID . '_Toggle', "Yes");}
		else {update_post_meta($Post_ID, 'EWD_WCTCF_' . $Custom_Field->ID . '_Toggle', "No");} 

		if ($Custom_Field->Toggle == "on") {echo $Custom_Field->Toggle;}
		else {echo $Custom_Field->Toggle;}
	}
}
add_action('wp_ajax_ewd_wctcf_save_cf_data', 'EWD_WCTCF_Save_Custom_Field_Post_Data');

?>