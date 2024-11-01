<?php
add_action( 'init', 'EWD_WCTCF_Create_Tabs_Posttype' );
function EWD_WCTCF_Create_Tabs_Posttype() {
		$labels = array(
				'name' => __('Tabs', 'EWD_WCTCF'),
				'singular_name' => __('Tab', 'EWD_WCTCF'),
				'menu_name' => __('Tabs', 'EWD_WCTCF'),
				'add_new' => __('Add New', 'EWD_WCTCF'),
				'add_new_item' => __('Add New Tab', 'EWD_WCTCF'),
				'edit_item' => __('Edit Tab', 'EWD_WCTCF'),
				'new_item' => __('New Tab', 'EWD_WCTCF'),
				'view_item' => __('View Tab', 'EWD_WCTCF'),
				'search_items' => __('Search Tabs', 'EWD_WCTCF'),
				'not_found' =>  __('Nothing found', 'EWD_WCTCF'),
				'not_found_in_trash' => __('Nothing found in Trash', 'EWD_WCTCF'),
				'parent_item_colon' => ''
		);

		$args = array(
				'labels' => $labels,
				'public' => false,
				'publicly_queryable' => false,
				'show_ui' => true,
				'query_var' => true,
				'has_archive' => false,
				'menu_icon' => null,
				'rewrite' => array('slug' => 'wc_tab'),
				'capability_type' => 'post',
				'show_in_menu' => 'edit.php?post_type=product',
				'menu_position' => null,
				'menu_icon' => 'dashicons-format-status',
				'supports' => array('title','editor','thumbnail')
	  ); 

	register_post_type( 'wc_tab' , $args );
}

function EWD_WCTCF_Add_Admin_Columns($cols) {
	$cols['menu_order'] = "Order";
	return $cols;
}
add_action('manage_edit-wc_tab_columns', 'EWD_WCTCF_Add_Admin_Columns');

function EWD_WCTCF_Return_Admin_Columns($column){
	global $post;
	switch ($column) {
		case 'menu_order':
			echo get_post_meta($post->ID, "EWD_WCTCF_Tab_Order", true);
			break;
		default:
			break;
	}
}
add_action('manage_wc_tab_posts_custom_column','EWD_WCTCF_Return_Admin_Columns');

function EWD_WCTCF_Sort_By_Order($query) {
	if (is_admin() and isset($_GET['post_type']) and $_GET['post_type'] == 'wc_tab' and !isset($_GET['orderby'])) {
		$query->set( 'meta_key', 'EWD_WCTCF_Tab_Order' );
		$query->set( 'orderby', 'meta_value_num' );
		$query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'EWD_WCTCF_Sort_By_Order' );

function EWD_WCTCF_Create_Default_Tabs() {
	$Tabs_Query = new WP_Query(array('post_type' => 'wc_tab', 'posts_per_page' => -1));
	
	if ($Tabs_Query->found_posts == 0) {
		$Default_Tabs_Array = array(
			'description' => array(
				'title' => __('Description', 'woocommerce'),
				'priority' => 1,
				'callback' => 'wc_default_description'
			),
			'additional_information' => array(
				'title' => __('Additional Information', 'woocommerce'),
				'priority' => 2,
				'callback' => 'wc_default_additional_information'
			),
			'reviews' => array(
				'title' => __('Reviews', 'woocommerce'),
				'priority' => 3,
				'callback' => 'wc_default_reviews'
			)
		);

		$WC_Tabs = apply_filters('woocommerce_product_tabs', $Default_Tabs_Array);

		foreach ($WC_Tabs as $slug => $WC_Tab) {
			if (strpos($WC_Tab['callback'], 'wc_default') === 0) {
				$Content = "[" . $WC_Tab['callback'] . "]";
				$Callback = "No";
			}
			else {
				$Content = "[tab-default]";
				$Callback = $WC_Tab['callback'];
			}

			$Tab_Post = array(
				'post_title' => $WC_Tab['title'],
				'post_name' => $slug,
				'post_type' => 'wc_tab',
				'post_content' => $Content,
				'post_status' => 'publish'
			);
		
			$Post_ID = wp_insert_post($Tab_Post);

			update_post_meta($Post_ID, "EWD_WCTCF_Tab_Order", $WC_Tab['priority']);
			update_post_meta($Post_ID, "EWD_WCTCF_Tab_Callback", $Callback);
			update_post_meta($Post_ID, "wctcf_tab_visbility", "Show");
		}
	}
}
?>
