<?php
/* The file contains all of the functions which make changes to the WordPress tables */
function EWD_WCTCF_AddCustomField() {
	$Custom_Fields = get_option("EWD_WCTCF_Custom_Fields");
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}

	$Field['Field_ID'] = EWD_WCTCF_Get_Highest_ID($Custom_Fields) +1;

	$Field['Field_Name'] = $_POST['Field_Name'];
	$Field['Field_Slug'] = $_POST['Field_Slug'];
	$Field['Field_Type'] = $_POST['Field_Type'];
	$Field['Field_Description'] = $_POST['Field_Description'];
	$Field['Field_Values'] = $_POST['Field_Values'];
	$Field['Field_Displays'] = $_POST['Field_Displays'];
	$Field['Field_Searchable'] = $_POST['Field_Searchable'];
	$Field['Field_Display_Tabbed'] = $_POST['Field_Display_Tabbed'];

	$Custom_Fields[] = $Field;
	update_option("EWD_WCTCF_Custom_Fields", $Custom_Fields);

	$update_message = __("Field has been succesfully created.", 'EWD_WCTCF');
	$update['Message'] = $update_message;
	$update['Message_Type'] = "Update";
	return $update;
}

function EWD_WCTCF_EditCustomField() {
	$Custom_Fields = get_option("EWD_WCTCF_Custom_Fields");
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}

	$Field['Field_ID'] = $_POST['Field_ID'];
	$Field['Field_Name'] = $_POST['Field_Name'];
	$Field['Field_Slug'] = $_POST['Field_Slug'];
	$Field['Field_Type'] = $_POST['Field_Type'];
	$Field['Field_Description'] = $_POST['Field_Description'];
	$Field['Field_Values'] = $_POST['Field_Values'];
	$Field['Field_Displays'] = $_POST['Field_Displays'];
	$Field['Field_Searchable'] = $_POST['Field_Searchable'];
	$Field['Field_Display_Tabbed'] = $_POST['Field_Display_Tabbed'];

	foreach ($Custom_Fields as $key => $Custom_Field) {
		if ($Custom_Field['Field_ID'] == $_POST['Field_ID']) {$Custom_Fields[$key] = $Field;}
	}

	update_option("EWD_WCTCF_Custom_Fields", $Custom_Fields);

	$update_message = __("Field has been succesfully edited.", 'EWD_WCTCF');
	$update['Message'] = $update_message;
	$update['Message_Type'] = "Update";
	return $update;
}

function EWD_WCTCF_DeleteCustomField($Field_ID) {
	$Custom_Fields = get_option("EWD_WCTCF_Custom_Fields");
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}

	foreach ($Custom_Fields as $key => $Custom_Field) {
		if ($Custom_Field['Field_ID'] == $Field_ID) {unset($Custom_Fields[$key]);}
	}

	$update_message = __("Field has been succesfully deleted.", 'EWD_WCTCF');
	$update['Message'] = $update_message;
	$update['Message_Type'] = "Update";
	return $update;
}

function EWD_WCTCF_MassDeleteCustomFields() {
	if (is_array($_POST['Fields_Bulk'])) {
		foreach ($_POST['Fields_Bulk'] as $Field_ID) {
			EWD_WCTCF_DeleteCustomField($Field_ID);
		}
	}

	$update_message = __("Fields fave been succesfully deleted.", 'EWD_WCTCF');
	$update['Message'] = $update_message;
	$update['Message_Type'] = "Update";
	return $update;
}

function EWD_WCTCF_UpdateOptions() {
	global $WCTCF_Full_Version;

	if (isset($_POST['custom_css'])) {update_option('EWD_WCTCF_Custom_CSS', stripslashes_deep($_POST['custom_css']));}
	
	$update_message = __("Options have been succesfully updated.", 'EWD_WCTCF');
	$update['Message'] = $update_message;
	$update['Message_Type'] = "Update";
	return $update;
}

function EWD_WCTCF_Get_Highest_ID($Custom_Fields) {
	foreach ($Custom_Fields as $Custom_Field) {
		$Max_ID = max($Max_ID, $Custom_Field['Field_ID']);
	}

	return $Max_ID;
}

?>