<?php
function EWD_WCTCF_Add_Tabs_Product_Tab($array) {
	$Tabs = array(
						'label' => __('Tabs', 'EWD_WCTCF'),
						'target' => 'tabs_product_data',
						'class' => array()
		);

	$array['tabs'] = $Tabs;

	return $array;
}
add_filter( 'woocommerce_product_data_tabs', 'EWD_WCTCF_Add_Tabs_Product_Tab', 10, 1 );

function EWD_WCTCF_Add_Custom_Fields_Product_Tab($array) {
	$Custom_Fields = array(
						'label' => __('Custom Fields', 'EWD_WCTCF'),
						'target' => 'custom_fields_product_data',
						'class' => array()
		);

	$array['custom_fields'] = $Custom_Fields;

	return $array;
}
add_filter( 'woocommerce_product_data_tabs', 'EWD_WCTCF_Add_Custom_Fields_Product_Tab', 10, 1 );

function EWD_WCTCF_Output_Tabs_Product_Tab() {
	echo "<div id='tabs_product_data' class='panel woocommerce_options_panel'>";
	echo "By George, you've done it!";
	echo "</div>";
}
add_action('woocommerce_product_data_panels', 'EWD_WCTCF_Output_Tabs_Product_Tab');

function EWD_WCTCF_Output_Custom_Fields_Product_Page() {
	global $post, $thepostid; 

	$Custom_Fields = get_option("EWD_WCTCF_Custom_Fields");
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}

	echo "<div id='custom_fields_product_data' class='panel woocommerce_options_panel'>";
	echo "<form id='ewd-wctcf-custom-fields-form'>";
	echo "<input type='hidden' id='ewd-wctcf-post-id' value='" . $thepostid . "' />";
	echo "<table class='form-table'>";
	echo "<tr>";
	echo "<th>" . __("Field Name", 'EWD_WCTCF') . "</th>";
	echo "<th>" . __("Value", 'EWD_WCTCF') . "</th>";
	echo "</tr>";
	foreach ($Custom_Fields as $Field) {
		$Value = get_post_meta($thepostid, 'EWD_WCTCF_' . $Field['Field_ID'], true );
		$Product_Checked = get_post_meta($thepostid, 'EWD_WCTCF_' . $Field['Field_ID'] . '_Toggle', true );

		if ($Product_Checked == "Yes") {$Checked = "checked";}
		elseif ($Product_Checked == "No") {$Checked = "";}
		elseif ($Field['Field_Display_Tabbed']) {$Checked = "checked";}
		else {$Checked = "";}

		$ReturnString .= "<tr class='ewd-wctcf-custom-field-row' data-customfieldid='" . $Field['Field_ID'] . "''>";
		$ReturnString .= "<th>";
		$ReturnString .= "<input type='checkbox' id='ewd-wctcf-cf-toggle-" . $Field['Field_ID'] . "' name='" . $Field['Field_Name'] . "-Toggle' " . $Checked . "/>";
		$ReturnString .= "<label class='ewd-wctcf' for='" . $Field['Field_Name'] . "'>" . $Field['Field_Name'] . ":</label>";
		$ReturnString .= "</th>";
		if ($Field['Field_Type'] == "text" or $Field['Field_Type'] == "mediumint") {
		 	  $ReturnString .= "<td><input name='" . $Field['Field_Name'] . "' class='ewd-wctcf-input' id='ewd-wctcf-input-" . $Field['Field_ID'] . "' type='text' value='" . htmlspecialchars($Value, ENT_QUOTES) . "' size='60' /></td>";
		}
		elseif ($Field['Field_Type'] == "textarea") {
			$ReturnString .= "<td><textarea name='" . $Field['Field_Name'] . "' class='ewd-wctcf-input' id='ewd-wctcf-input-" . $Field['Field_ID'] . "' cols='60' rows='6'>" . $Value . "</textarea></td>";
		} 
		elseif ($Field['Field_Type'] == "select") { 
			$Options = explode(",", $Field['Field_Values']);
			$ReturnString .= "<td><select name='" . $Field['Field_Name'] . "' class='ewd-wctcf-input' id='ewd-wctcf-input-" . $Field['Field_ID'] . "' >";
 			foreach ($Options as $Option) {
				$ReturnString .= "<option value='" . $Option . "' ";
				if (trim($Option) == trim($Value)) {$ReturnString .= "selected='selected'";}
				$ReturnString .= ">" . $Option . "</option>";
			}
			$ReturnString .= "</select></td>";
		} 
		elseif ($Field['Field_Type'] == "radio") {
			$Counter = 0;
			$Options = explode(",", $Field['Field_Values']);
			$ReturnString .= "<td>";
			foreach ($Options as $Option) {
				if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
				$ReturnString .= "<input type='radio' class='ewd-wctcf-input' id='ewd-wctcf-input-" . $Field['Field_ID'] . "' name='" . $Field['Field_Name'] . "' value='" . $Option . "'  ";
				if (trim($Option) == trim($Value)) {$ReturnString .= "checked";}
				$ReturnString .= ">" . $Option;
				$Counter++;
			} 
			$ReturnString .= "</td>";
		} 
		elseif ($Field['Field_Type'] == "checkbox") {
			$Counter = 0;
			$Options = explode(",", $Field['Field_Values']);
			$Values = explode(",", $Value);
			$ReturnString .= "<td>";
			foreach ($Options as $Option) {
				if ($Counter != 0) {$ReturnString .= "<label class='radio'></label>";}
				$ReturnString .= "<input type='checkbox' class='ewd-wctcf-input' id='ewd-wctcf-input-" . $Field['Field_ID'] . "'  name='" . $Field['Field_Name'] . "[]' value='" . $Option . "' ";
				if (in_array($Option, $Values)) {$ReturnString .= "checked";}
				$ReturnString .= ">" . $Option . "</br>";
				$Counter++;
			}
			$ReturnString .= "</td>";
		}
		elseif ($Field['Field_Type'] == "file") {
			$ReturnString .= "<td><input class='ewd-wctcf-input' name='" . $Field['Field_Name'] . "' type='file' value='" . $Value . "' /><br/>Current Filename: " . $Value . "</td>";
		}
		elseif ($Field['Field_Type'] == "date") {
			$ReturnString .= "<td><input class='ewd-wctcf-input' id='ewd-wctcf-input-" . $Field['Field_ID'] . "' name='" . $Field['Field_Name'] . "' type='date' value='" . $Value . "' /></td>";
		} 
		elseif ($Field['Field_Type'] == "datetime") {
			$ReturnString .= "<td><input class='ewd-wctcf-input' id='ewd-wctcf-input-" . $Field['Field_ID'] . "' name='" . $Field['Field_Name'] . "' type='datetime-local' value='" . $Value . "' /></td>";
		}
	}
	echo $ReturnString;
	echo "</table>";
	echo "</form>";
	echo "<button class='ewd-wctcf-save-button'>" . __('Save Fields', 'EWD_WCTCF') . "</button>";
	echo "<div>";
}

add_action('woocommerce_product_data_panels', 'EWD_WCTCF_Output_Custom_Fields_Product_Page');
?>