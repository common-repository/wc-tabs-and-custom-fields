<?php
/* Creates the admin page, and fills it in based on whether the user is looking at
*  the overview page or an individual item is being edited */
function EWD_WCTCF_Output_Custom_Fields_Page() {
		global $WCTCF_Full_Version;
		
		include( plugin_dir_path( __FILE__ ) . '../html/AdminCFHeader.php');
		if (isset($_GET['Action']) and $_GET['Action'] == "EWD_WCTCF_Field_Details") {include( plugin_dir_path( __FILE__ ) . '../html/CustomFieldDetailsPage.php');}
		else {include( plugin_dir_path( __FILE__ ) . '../html/CustomFieldsPage.php');}
		include( plugin_dir_path( __FILE__ ) . '../html/AdminFooter.php');
}
?>