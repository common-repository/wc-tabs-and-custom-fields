<?php
/* Creates the admin page, and fills it in based on whether the user is looking at
*  the overview page or an individual item is being edited */
function EWD_WCTCF_Output_Tabs_Page() {
		global $WCTCF_Full_Version;
		
		include( plugin_dir_path( __FILE__ ) . '../html/AdminTabHeader.php');
		if (isset($_GET['Action']) and $GET_['Action'] == "EWD_WCTCF_Tab_Details") {include( plugin_dir_path( __FILE__ ) . '../html/TabDetailsPage.php');}
		else {include( plugin_dir_path( __FILE__ ) . '../html/TabsPage.php');}
		include( plugin_dir_path( __FILE__ ) . '../html/AdminFooter.php');
}
?>