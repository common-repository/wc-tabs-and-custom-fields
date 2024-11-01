<?php

add_filter( 'woocommerce_product_tabs', 'EWD_WCTCF_Create_Product_Tabs', 98);
function EWD_WCTCF_Create_Product_Tabs( $tabs ) {
	global $product;
	
	$args = array(
		'post_type' => 'wc_tab',
		'post_count' => -1,
	);

	$Query = new WP_Query($args);
	$Posts = $Query->posts;
	
	if (sizeOf($Posts) > 0) {
		foreach ($Posts as $Post) {
			if (get_post_meta($Post->ID, "wctcf_tab_visbility", true ) == "Show") {
				$tabs[$Post->post_name] = array(
					'title' 	=> $Post->post_title,
					'priority' 	=> get_post_meta($Post->ID, 'EWD_WCTCF_Tab_Order'),
					'callback' 	=> 'EWD_WCTCF_Add_WC_Tab_Content',
					'callback_parameters' => $Post->ID
				);
			}
		}
	}

	return $tabs;
}

function EWD_WCTCF_Add_WC_Tab_Content($tab_name, $tab) {
	global $product;

	$Use_Product = get_option("EWD_WCTCF_Use_Product");

	if ($Use_Product == "Yes") {$Product_Post = get_post($product->get_id());}
	else {$Product_Post = get_post(get_the_id());}

	$post_id = $tab['callback_parameters'];

	$post = get_post($post_id);

	$Callback_Function = get_post_meta($post_id, 'EWD_WCTCF_Tab_Callback', true);
	if ($Callback_Function != "No") {
		if (function_exists($Callback_Function)) {
			$Callback_Function();
		}

		return;
	}

	$Custom_Fields = get_option("EWD_WCTCF_Custom_Fields");
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}

	$Tab_Content = apply_filters('the_content', $post->post_content);

	$Tab_Content = EWD_WCTCF_Replace_Product_Shortcodes($Tab_Content, $Product_Post);

	$Output = "";
	if ($tab_name != "description" and $tab_name != "additional_information") {$Output .= "<h2>" . $post->post_title . "</h2>";}
	if ($tab_name != "description" and $tab_name != "additional_information") {$Output .= "<p>";}
	$Output .= do_shortcode($Tab_Content);
	if ($tab_name != "description" and $tab_name != "additional_information") {$Output .= "</p>";}
	
	echo $Output;
}

function EWD_WCTCF_Replace_Product_Shortcodes($Content, $Product_Post) {
	$Custom_Fields = get_option("EWD_WCTCF_Custom_Fields");
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}

	$Attributes = wc_get_attribute_taxonomies();

	$Content = str_replace("[wc_default_description]", woocommerce_product_description_tab(), $Content);
	$Content = str_replace("[wc_default_additional_information]", woocommerce_product_additional_information_tab(), $Content);
	$Content = str_replace("[wc_default_reviews]", EWD_WCTCF_Get_Woo_Comments(), $Content);

	$Content = str_replace("[product-name]", $Product_Post->post_title, $Content);
	$Content = str_replace("[product-slug]", $Product_Post->post_name, $Content);
	$Content = str_replace("[product-description]", $Product_Post->post_content, $Content);
	$Content = str_replace("[product-excerpt]", $Product_Post->post_excerpt, $Content);
	$Content = str_replace("[product-url]", get_permalink($Product_Post->ID), $Content);
	$Content = str_replace("[product-link]", "<a href='" . get_permalink($Product_Post->ID) . "'>". get_permalink($Product_Post->ID) . "</a>", $Content);

	foreach ($Custom_Fields as $Custom_Field) {
		$Field_Value = get_post_meta($Product_Post->ID, 'EWD_WCTCF_' . $Custom_Field['Field_ID'], true);
		$Content = str_replace("[" . $Custom_Field['Field_Slug']. "]", $Field_Value, $Content);
	}

	foreach ($Attributes as $Attribute) {
		$Attribute_Value_Array =  wc_get_product_terms($Product_Post->ID, 'pa_' . $Attribute->attribute_name);
		foreach ($Attribute_Value_Array  as $Array_Value) {
			$Attribute_Value .= $Array_Value . ",";
		}
		$Attribute_Value = substr($Attribute_Value, 0, -1);

		$Content = str_replace("[" . $Attribute->attribute_name . "]", $Attribute_Value, $Content);
	}

	return $Content;
}

if (!function_exists('woocommerce_product_description_tab')) {
	function woocommerce_product_description_tab() {
		global $product;
	
		$Use_Product = get_option("EWD_WCTCF_Use_Product");
	
		if ($Use_Product == "Yes") {$Product_Post = get_post($product->get_id());}
		else {$Product_Post = get_post(get_the_id());}
	
		$Content = EWD_WCTCF_wc_get_template('single-product/tabs/description.php'); 

		return trim($Content);
	}
}

if (!function_exists('woocommerce_product_additional_information_tab')) {
	function woocommerce_product_additional_information_tab() {
		global $product;
	
		$Use_Product = get_option("EWD_WCTCF_Use_Product");
	
		if ($Use_Product == "Yes") {$Product_Post = get_post($product->get_id());}
		else {$Product_Post = get_post(get_the_id());}
	
		$Content = EWD_WCTCF_wc_get_template('single-product/tabs/additional-information.php');
	
		$Content = EWD_WCTCF_Add_CFs_To_Addtl_Information($Product_Post, $Content);
	
		return trim($Content);
	}
}

function EWD_WCTCF_Get_Woo_Comments() {
	global $product;
	
	$Use_Product = get_option("EWD_WCTCF_Use_Product");
	
	if ($Use_Product == "Yes") {$Product_Post = get_post($product->get_id());}
	else {$Product_Post = get_post(get_the_id());}

    $comments = get_comments(array('ID' => $Product_Post->ID));

    return wp_list_comments(array('callback' => 'woocommerce_comments', 'echo' => false), $comments);
}

if (!function_exists('woocommerce_comments')) {
	function woocommerce_comments($comment, $args, $depth) {
		$GLOBALS['comment'] = $comment;
	
		$Content = EWD_WCTCF_wc_get_template('single-product/review.php', array('comment' => $comment, 'args' => $args, 'depth' => $depth)); 

		echo $Content;
	}
}

function EWD_WCTCF_wc_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
    if ( $args && is_array( $args ) ) {
        extract( $args );
    }

    $located = wc_locate_template( $template_name, $template_path, $default_path );

    if ( ! file_exists( $located ) ) {
        _doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $located ), '2.1' );
        return;
    }

    // Allow 3rd party plugin filter template file from their plugin.
    $located = apply_filters( 'wc_get_template', $located, $template_name, $args, $template_path, $default_path );

    ob_start();

    do_action( 'woocommerce_before_template_part', $template_name, $template_path, $located, $args );

    include( $located );

    do_action( 'woocommerce_after_template_part', $template_name, $template_path, $located, $args );

    return ob_get_clean();
}

function EWD_WCTCF_Add_CFs_To_Addtl_Information($Product_Post, $Content) {
	$Custom_Fields = get_option("EWD_WCTCF_Custom_Fields");
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}

	foreach ($Custom_Fields as $Custom_Field) {
		if ($Custom_Field['Field_Display_Tabbed'] == "Yes") {
			$Field_Value = get_post_meta($Product_Post->ID, 'EWD_WCTCF_' . $Custom_Field['Field_ID'], true);
			$Field_Toggle = get_post_meta($Product_Post->ID, 'EWD_WCTCF_' . $Custom_Field['Field_ID'] . "_Toggle", true);

			if ($Field_Toggle == "Yes") {
				$CF_String .= "<tr class>";
				$CF_String .= "<th>" . $Custom_Field['Field_Name'] . "</th>";
				$CF_String .= "<td><p>" . $Field_Value . "</p></td>";
				$CF_String .= "</tr>";
			}
		}
	}

	$CF_String .= "</table>";

	return str_replace("</table>", $CF_String, $Content);
}