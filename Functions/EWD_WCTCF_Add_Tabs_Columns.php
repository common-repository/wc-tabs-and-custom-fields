<?php
// Add in a new column option for the URP post type
function EWD_WCTCF_Columns_Head($defaults) {
	$defaults['wctcf_tab_visbility'] = __('Show/Hide', 'EWD_WCTCF');

	return $defaults;
}
 
// Show the number of times the FAQ post has been clicked
function EWD_WCTCF_Columns_Content($column_name, $post_ID) {
	if ($column_name == 'wctcf_tab_visbility') {
		$num_views = EWD_WCTCF_Get_Visibility($post_ID);
		echo $num_views;
	}
}

function EWD_WCTCF_Register_Post_Column_Sortables( $column ) {
    $column['wctcf_tab_visbility'] = 'wctcf_tab_visbility';
    return $column;
}

function EWD_WCTCF_Sort_Visibility_Column( $vars ) 
{
    if ( isset( $vars['orderby'] ) && 'wctcf_tab_visbility' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'wctcf_tab_visbility', //Custom field key
            'orderby' => 'meta_value') //Custom field value
        );
    }

    return $vars;
}

// Get the number of times the FAQ post has been clicked
function EWD_WCTCF_Get_Visibility($post_ID) {
	$WCTCF_Visibility = get_post_meta($post_ID, 'wctcf_tab_visbility', true);
	if ($WCTCF_Visibility != "") {
        $Visbility_Return_Text = $WCTCF_Visibility . " (";
        if ($WCTCF_Visibility == "Show") {$Visbility_Return_Text .= "<span class='ewd-wctcf-visibility-toggle' data-visibilityvalue='Hide' data-postid='" . $post_ID . "'>" . __('Hide', 'EWD_WCTCF') . "</span>";}
		if ($WCTCF_Visibility == "Hide") {$Visbility_Return_Text .= "<span class='ewd-wctcf-visibility-toggle' data-visibilityvalue='Show' data-postid='" . $post_ID . "'>" . __('Show', 'EWD_WCTCF') . "</span>";}
        $Visbility_Return_Text .= ")";
        return $Visbility_Return_Text;
	}
	else {
		$Visbility_Return_Text = "N/A (";
        $Visbility_Return_Text .= "<span class='ewd-wctcf-visibility-toggle' data-visibilityvalue='Hide' data-postid='" . $post_ID . "'>" . __('Hide', 'EWD_WCTCF') . "</span> / ";
        $Visbility_Return_Text .= "<span class='ewd-wctcf-visibility-toggle' data-visibilityvalue='Show' data-postid='" . $post_ID . "'>" . __('Show', 'EWD_WCTCF') . "</span>";
        $Visbility_Return_Text .= ")";
        return $Visbility_Return_Text;
	}
}


add_filter( 'parse_query', 'EWD_WCTCF_Visibility_Filter_Post_Filter' );
function EWD_WCTCF_Visibility_Filter_Post_Filter( $query )
{
    global $typenow;
    global $pagenow;

    if (!isset($typenow) or $typenow != 'wctcf_review') {return;}

    if ( is_admin() && $pagenow=='edit.php' && isset($_GET['EWD_WCTCF_Visibility_Filter']) && $_GET['EWD_WCTCF_Visibility_Filter'] != '') {
        $query->query_vars['meta_value'] = $_GET['EWD_WCTCF_Visibility_Filter'];
        $query->query_vars['meta_key'] = "wctcf_tab_visbility";
    }
}

add_action( 'restrict_manage_posts', 'EWD_WCTCF_Visibility_Filter_Post_Filter_Restrict_Manage_Posts' );
function EWD_WCTCF_Visibility_Filter_Post_Filter_Restrict_Manage_Posts()
{
    global $wpdb;
    global $typenow;

    if (!isset($typenow) or $typenow != 'wc_tab') {return;}

?>
<select name="EWD_WCTCF_Visibility_Filter">
<option value=""><?php _e('Show All Tabs', 'EWD_WCTCF'); ?></option>
<option value='show'><?php _e('Visible', 'EWD_WCTCF'); ?></option>
<option value='hide'><?php _e('Hidden', 'EWD_WCTCF'); ?></option>
</select>
<?php
}

add_filter('manage_wc_tab_posts_columns', 'EWD_WCTCF_Columns_Head');
add_action('manage_wc_tab_posts_custom_column', 'EWD_WCTCF_Columns_Content', 10, 2);

add_filter( 'manage_edit-wc_tab_sortable_columns', 'EWD_WCTCF_Register_Post_Column_Sortables' );
add_filter( 'request', 'EWD_WCTCF_Sort_Visibility_Column' );

?>