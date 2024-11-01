<?php 
	$Custom_Fields = get_option("EWD_WCTCF_Custom_Fields");
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}

	foreach ($Custom_Fields as $Custom_Field) {
		if ($Custom_Field['Field_ID'] == $_GET['Field_ID']) {$Field = $Custom_Field;}
	}
?>
		
	<div class="OptionTab ActiveTab" id="EditCustomField">
			
		<div id="col-left">
		<div class="col-wrap">
		<div class="form-wrap TagDetail">
			<a href="edit.php?post_type=product&page=wctcf-custom-fields" class="NoUnderline">&#171; <?php _e("Back", 'EWD_WCTCF') ?></a>
			<h3>Edit <?php echo $Field['Field_Name']; ?></h3>
			<form id="addtag" method="post" action="edit.php?post_type=product&page=wctcf-custom-fields&Action=EWD_WCTCF_EditCustomField" class="validate" enctype="multipart/form-data">
				<input type="hidden" name="action" value="Edit_Custom_Field" />
				<input type="hidden" name="Field_ID" value="<?php echo $Field['Field_ID']; ?>" />
				<?php wp_nonce_field(); ?>
				<?php wp_referer_field(); ?>
				<div class="form-field form-required">
						<label for="Field_Name"><?php _e("Name", 'EWD_WCTCF') ?></label>
						<input name="Field_Name" id="Field_Name" type="text" value="<?php echo $Field['Field_Name'];?>" size="60" />
						<p><?php _e("The name of the field you will see.", 'EWD_WCTCF') ?></p>
				</div>
				<div class="form-field form-required">
						<label for="Field_Slug"><?php _e("Slug", 'EWD_WCTCF') ?></label>
						<input name="Field_Slug" id="Field_Slug" type="text" value="<?php echo $Field['Field_Slug'];?>" size="60" />
						<p><?php _e("An all-lowercase name that will be used to insert the field.", 'EWD_WCTCF') ?></p>
				</div>
				<div class="form-field">
						<label for="Field_Type"><?php _e("Type", 'EWD_WCTCF') ?></label>
						<select name="Field_Type" id="Field_Type">
								<option value='text' <?php if ($Field['Field_Type'] == "text") {echo "selected=selected";} ?>><?php _e("Short Text", 'EWD_WCTCF') ?></option>
								<option value='mediumint' <?php if ($Field['Field_Type'] == "mediumint") {echo "selected=selected";} ?>><?php _e("Integer", 'EWD_WCTCF') ?></option>
								<option value='select' <?php if ($Field['Field_Type'] == "select") {echo "selected=selected";} ?>><?php _e("Select Box", 'EWD_WCTCF') ?></option>
								<option value='radio' <?php if ($Field['Field_Type'] == "radio") {echo "selected=selected";} ?>><?php _e("Radio Button", 'EWD_WCTCF') ?></option>
								<option value='checkbox' <?php if ($Field['Field_Type'] == "checkbox") {echo "selected=selected";} ?>><?php _e("Checkbox", 'EWD_WCTCF') ?></option>
								<option value='textarea' <?php if ($Field['Field_Type'] == "textarea") {echo "selected=selected";} ?>><?php _e("Text Area", 'EWD_WCTCF') ?></option>
								<option value='file' <?php if ($Field['Field_Type'] == "file") {echo "selected=selected";} ?>><?php _e("File", 'EWD_WCTCF') ?></option>
								<option value='date' <?php if ($Field['Field_Type'] == "date") {echo "selected=selected";} ?>><?php _e("Date", 'EWD_WCTCF') ?></option>
								<option value='datetime' <?php if ($Field['Field_Type'] == "datetime") {echo "selected=selected";} ?>><?php _e("Date/Time", 'EWD_WCTCF') ?></option>
						</select>
						<p><?php _e("The input method for the field and type of data that the field will hold.", 'EWD_WCTCF') ?></p>
				</div>
				<div class="form-field">
						<label for="Field_Description"><?php _e("Description", 'EWD_WCTCF') ?></label>
						<textarea name="Field_Description" id="Field_Description" rows="2" cols="40"><?php echo $Field['Field_Description'];?></textarea>
						<p><?php _e("The description of the field, which you will see as the instruction for the field.", 'EWD_WCTCF') ?></p>
				</div>
				<div class="form-field">
						<label for="Field_Values"><?php _e("Input Values", 'EWD_WCTCF') ?></label>
						<input name="Field_Values" id="Field_Values" type="text" value="<?php echo $Field['Field_Values'];?>"  size="60" />
						<p><?php _e("A comma-separated list of acceptable input values for this field. These values will be the options for select, checkbox, and radio inputs. All values will be accepted if left blank.", 'EWD_WCTCF') ?></p>
				</div>
				<div class="form-field">
						<label for="Field_Displays"><?php _e("Display?", 'EWD_WCTCF') ?></label>
						<select name="Field_Displays" id="Field_Displays">
								<option value='No' <?php if ($Field['Field_Displays'] == "No") {echo "selected=selected";} ?>><?php _e("No", 'EWD_WCTCF') ?></option>
								<option value='Yes' <?php if ($Field['Field_Displays'] == "Yes") {echo "selected=selected";} ?>><?php _e("Yes", 'EWD_WCTCF') ?></option>
						</select>
						<p><?php _e("Should this field be displayed on the main shop page?", 'EWD_WCTCF') ?></p>
				</div>
				<div class="form-field">
						<label for="Field_Searchable"><?php _e("Searchable?", 'EWD_WCTCF') ?></label>
						<select name="Field_Searchable" id="Field_Searchable">
								<option value='No' <?php if ($Field['Field_Searchable'] == "No") {echo "selected=selected";} ?>><?php _e("No", 'EWD_WCTCF') ?></option>
								<option value='Yes' <?php if ($Field['Field_Searchable'] == "Yes") {echo "selected=selected";} ?>><?php _e("Yes", 'EWD_WCTCF') ?></option>
						</select>
						<p><?php _e("Should this field be searchable in your shop?", 'EWD_WCTCF') ?></p>
				</div>
				<div class="form-field">
						<label for="Field_Display_Tabbed"><?php _e("Display in Tabbed Layout?", 'EWD_WCTCF') ?></label>
						<select name="Field_Display_Tabbed" id="Field_Display_Tabbed">
								<option value='No' <?php if ($Field['Field_Display_Tabbed'] == "No") {echo "selected=selected";} ?>><?php _e("No", 'EWD_WCTCF') ?></option>
								<option value='Yes' <?php if ($Field['Field_Display_Tabbed'] == "Yes") {echo "selected=selected";} ?>><?php _e("Yes", 'EWD_WCTCF') ?></option>
						</select>
						<p><?php _e("Should this field be displayed in the 'Additional Information' tab of the product page?", 'EWD_WCTCF') ?></p>
				</div>					
				<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes', 'EWD_WCTCF') ?>"  /></p>					
			</form>			
		</div>			
		</div>			
		</div>
	</div>