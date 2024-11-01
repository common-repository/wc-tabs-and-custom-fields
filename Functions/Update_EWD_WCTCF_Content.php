<?php
/* This file is the action handler. The appropriate function is then called based 
*  on the action that's been selected by the user. The functions themselves are all
* stored either in Prepare_Data_For_Insertion.php or Update_Admin_Databases.php */
		
function Update_EWD_WCTCF_Content() {
global $ewd_wctcf_message;
if (isset($_GET['Action'])) {
		switch ($_GET['Action']) {
			case "EWD_WCTCF_AddCustomField":
       			$ewd_wctcf_message = EWD_WCTCF_AddCustomField();
				break;
			case "EWD_WCTCF_EditCustomField":
       			$ewd_wctcf_message = EWD_WCTCF_EditCustomField();
				break;
			case "EWD_WCTCF_Field_Details":
				break;
			case "EWD_WCTCF_DeleteCustomField":
       			$ewd_wctcf_message = EWD_WCTCF_DeleteCustomField($_POST['Field_ID']);
				break;
			case "EWD_WCTCF_MassDeleteCustomFields":
       			$ewd_wctcf_message = EWD_WCTCF_MassDeleteCustomFields();
				break;
			default:
				$ewd_wctcf_message = __("The form has not worked correctly. Please contact the plugin developer.", 'EWD_WCTCF');
				break;
		}
	}
}

?>