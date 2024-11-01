<?php 
function EWD_WCTCF_Sort_Custom_Fields($a, $b) {
	if ($_GET['Order'] == "DESC") {
		return $a[$_GET['OrderBy']] - $b[$_GET['OrderBy']];
	}
	else {
		return $b[$_GET['OrderBy']] - $a[$_GET['OrderBy']];
	}
}
?>

<div id="col-right">
<div class="col-wrap">

<!-- Display a list of the products which have already been created -->
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php 
	$Custom_Fields = get_option("EWD_WCTCF_Custom_Fields");
	if (!is_array($Custom_Fields)) {$Custom_Fields = array();}

	if (isset($_GET['OrderBy'])) {
		usort($Custom_Fields, 'EWD_WCTCF_Sort_Custom_Fields');
	}
?>

<form action="edit.php?post_type=product&page=wctcf-custom-fields&Action=EWD_WCTCF_MassDeleteCustomFields" method="post">    
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'EWD_WCTCF') ?></option>
						<option value='delete'><?php _e("Delete", 'EWD_WCTCF') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'EWD_WCTCF') ?>"  />
		</div>
</div>

<table class="wp-list-table widefat fixed tags sorttable custom-fields-list" cellspacing="0">
		<thead>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='field-name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Field_Name" and $_GET['Order'] == "ASC") { echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Name&Order=DESC'>";}
										 			else {echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Name&Order=ASC'>";} ?>
											  <span><?php _e("Field Name", 'EWD_WCTCF') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Slug" and $_GET['Order'] == "ASC") { echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Slug&Order=DESC'>";}
										 			else {echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Slug&Order=ASC'>";} ?>
											  <span><?php _e("Field Slug", 'EWD_WCTCF') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Type" and $_GET['Order'] == "ASC") { echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Type&Order=DESC'>";}
										 			else {echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Type&Order=ASC'>";} ?>
											  <span><?php _e("Type", 'EWD_WCTCF') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Description" and $_GET['Order'] == "ASC") { echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Description&Order=DESC'>";}
										 			else {echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'EWD_WCTCF') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</thead>

		<tfoot>
				<tr>
						<th scope='col' id='cb' class='manage-column column-cb check-column'  style="">
								<input type="checkbox" /></th><th scope='col' id='field-name' class='manage-column column-name sortable desc'  style="">
										<?php if ($_GET['OrderBy'] == "Field_Name" and $_GET['Order'] == "ASC") { echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Name&Order=DESC'>";}
										 			else {echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Name&Order=ASC'>";} ?>
											  <span><?php _e("Field Name", 'EWD_WCTCF') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Slug" and $_GET['Order'] == "ASC") { echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Slug&Order=DESC'>";}
										 			else {echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Slug&Order=ASC'>";} ?>
											  <span><?php _e("Field Slug", 'EWD_WCTCF') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='type' class='manage-column column-type sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Type" and $_GET['Order'] == "ASC") { echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Type&Order=DESC'>";}
										 			else {echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Type&Order=ASC'>";} ?>
											  <span><?php _e("Type", 'EWD_WCTCF') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
						<th scope='col' id='description' class='manage-column column-description sortable desc'  style="">
									  <?php if ($_GET['OrderBy'] == "Field_Description" and $_GET['Order'] == "ASC") { echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Description&Order=DESC'>";}
										 			else {echo "<a href='edit.php?post_type=product&page=wctcf-custom-fields&OrderBy=Field_Description&Order=ASC'>";} ?>
											  <span><?php _e("Description", 'EWD_WCTCF') ?></span>
												<span class="sorting-indicator"></span>
										</a>
						</th>
				</tr>
		</tfoot>

	<tbody id="the-list" class='list:tag'>
		
		 <?php
				if ($Custom_Fields) { 
	  			  foreach ($Custom_Fields as $Field) {
								echo "<tr id='field-item-" . $Field['Field_ID'] ."' class='custom-field-list-item'>";
								echo "<th scope='row' class='check-column'>";
								echo "<input type='checkbox' name='Fields_Bulk[]' value='" . $Field['Field_ID'] ."' />";
								echo "</th>";
								echo "<td class='name column-name'>";
								echo "<strong>";
								echo "<a class='row-title' href='edit.php?post_type=product&page=wctcf-custom-fields&Action=EWD_WCTCF_Field_Details&Selected=CustomField&Field_ID=" . $Field['Field_ID'] ."' title='Edit " . $Field['Field_Name'] . "'>" . $Field['Field_Name'] . "</a></strong>";
								echo "<br />";
								echo "<div class='row-actions'>";
								echo "<span class='delete'>";
								echo "<a class='delete-tag' href='edit.php?post_type=product&page=wctcf-custom-fields&Action=EWD_WCTCF_DeleteCustomField&Field_ID=" . $Field['Field_ID'] ."'>" . __("Delete", 'EWD_WCTCF') . "</a>";
		 						echo "</span>";
								echo "</div>";
								echo "<div class='hidden' id='inline_" . $Field['Field_ID'] ."'>";
								echo "<div class='name'>" . $Field['Field_Name'] . "</div>";
								echo "</div>";
								echo "</td>";
								echo "<td class='description column-slug'>" . $Field['Field_Slug'] . "</td>";
								echo "<td class='description column-type'>" . $Field['Field_Type'] . "</td>";
								echo "<td class='description column-description'>" . substr($Field['Field_Description'], 0, 60);
								if (strlen($Field['Field_Description']) > 60) {echo "...";}
								echo "</td>";
								echo "</tr>";
						}
				}
		?>

	</tbody>
</table>

<div class="tablenav bottom">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'EWD_WCTCF') ?></option>
						<option value='delete'><?php _e("Delete", 'EWD_WCTCF') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'EWD_WCTCF') ?>"  />
		</div>
		<br class="clear" />
</div>
</form>

<br class="clear" />
</div>
</div> <!-- /col-right -->


<!-- Form to upload a list of new products from a spreadsheet -->
<div id="col-left">
<div class="col-wrap">

<div class="form-wrap">
<h2><?php _e("Add New Field", 'EWD_WCTCF') ?></h2>
<!-- Form to create a new field -->
<form id="addtag" method="post" action="edit.php?post_type=product&page=wctcf-custom-fields&Action=EWD_WCTCF_AddCustomField&DisplayPage=CustomFields" class="validate" enctype="multipart/form-data">
<input type="hidden" name="action" value="Add_Custom_Field" />
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>
<div class="form-field form-required">
	<label for="Field_Name"><?php _e("Name", 'EWD_WCTCF') ?></label>
	<input name="Field_Name" id="Field_Name" type="text" value="" size="60" />
	<p><?php _e("The name of the field you will see.", 'EWD_WCTCF') ?></p>
</div>
<div class="form-field form-required">
	<label for="Field_Slug"><?php _e("Slug", 'EWD_WCTCF') ?></label>
	<input name="Field_Slug" id="Field_Slug" type="text" value="" size="60" />
	<p><?php _e("An all-lowercase name that will be used to insert the field.", 'EWD_WCTCF') ?></p>
</div>
<div class="form-field">
	<label for="Field_Type"><?php _e("Type", 'EWD_WCTCF') ?></label>
	<select name="Field_Type" id="Field_Type">
			<option value='text'><?php _e("Short Text", 'EWD_WCTCF') ?></option>
			<option value='mediumint'><?php _e("Integer", 'EWD_WCTCF') ?></option>
			<option value='select'><?php _e("Select Box", 'EWD_WCTCF') ?></option>
			<option value='radio'><?php _e("Radio Button", 'EWD_WCTCF') ?></option>
			<option value='checkbox'><?php _e("Checkbox", 'EWD_WCTCF') ?></option>
			<option value='textarea'><?php _e("Text Area", 'EWD_WCTCF') ?></option>
			<!--<option value='file'><?php _e("File", 'EWD_WCTCF') ?></option>-->
			<option value='date'><?php _e("Date", 'EWD_WCTCF') ?></option>
			<option value='datetime'><?php _e("Date/Time", 'EWD_WCTCF') ?></option>
	</select>
	<p><?php _e("The input method for the field and type of data that the field will hold.", 'EWD_WCTCF') ?></p>
</div>
<div class="form-field">
	<label for="Field_Description"><?php _e("Description", 'EWD_WCTCF') ?></label>
	<textarea name="Field_Description" id="Field_Description" rows="2" cols="40"></textarea>
	<p><?php _e("The description of the field, which you will see as the instruction for the field.", 'EWD_WCTCF') ?></p>
</div>
<div>
		<label for="Field_Values"><?php _e("Input Values", 'EWD_WCTCF') ?></label>
		<input name="Field_Values" id="Field_Values" type="text" size="60" />
		<p><?php _e("A comma-separated list of acceptable input values for this field. These values will be the options for select, checkbox, and radio inputs. All values will be accepted if left blank.", 'EWD_WCTCF') ?></p>
</div>
<div class="form-field">
	<label for="Field_Displays"><?php _e("Display?", 'EWD_WCTCF') ?></label>
	<select name="Field_Displays" id="Field_Displays">
			<option value='No'><?php _e("No", 'EWD_WCTCF') ?></option>
			<option value='Yes'><?php _e("Yes", 'EWD_WCTCF') ?></option>
	</select>
	<p><?php _e("Should this field be displayed on the main shop page?", 'EWD_WCTCF') ?></p>
</div>

<div class="form-field">
	<label for="Field_Searchable"><?php _e("Searchable?", 'EWD_WCTCF') ?></label>
	<select name="Field_Searchable" id="Field_Searchable">
			<option value='No'><?php _e("No", 'EWD_WCTCF') ?></option>
			<option value='Yes'><?php _e("Yes", 'EWD_WCTCF') ?></option>
	</select>
	<p><?php _e("Should this field be searchable in your shop?", 'EWD_WCTCF') ?></p>
</div>

<div class="form-field">
	<label for="Field_Display_Tabbed"><?php _e("Display on Product Page?", 'EWD_WCTCF') ?></label>
	<select name="Field_Display_Tabbed" id="Field_Display_Tabbed">
			<option value='No'><?php _e("No", 'EWD_WCTCF') ?></option>
			<option value='Yes'><?php _e("Yes", 'EWD_WCTCF') ?></option>
	</select>
	<p><?php _e("Should this field be displayed in the 'Additional Information' tab of the product page?", 'EWD_WCTCF') ?></p>
</div>

<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="<?php _e('Add New Field', 'EWD_WCTCF') ?>"  /></p></form>

</div>

<br class="clear" />
</div>
</div><!-- /col-left -->