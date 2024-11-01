<?php

add_action( 'save_post', 'EWD_WCTCF_Save_Meta_Box_Data' );
function EWD_WCTCF_Save_Meta_Box_Data($post_id) {
	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	/* if ( ! isset( $_POST['EWD_US_meta_box_nonce'] ) ) {
		return;
	} */

	// Verify that the nonce is valid.
	/* if ( ! wp_verify_nonce( $_POST['EWD_US_meta_box_nonce'], 'EWD_US_Save_Meta_Box_Data' ) ) {
		return;
	} */

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. If there's no product name, don't save any other information.*/
	// Sanitize user input.
	if (get_post_meta($post_id, "EWD_WCTCF_Tab_Order", true) == "") {update_post_meta($post_id, "EWD_WCTCF_Tab_Order", 999);}
	if (get_post_meta($post_id, "wctcf_tab_visbility", true) == "") {update_post_meta($post_id, "wctcf_tab_visbility", "Show");}
}