jQuery(document).ready(function() {
	WCTCF_Save_Custom_Fields_Click_Handler();
});

function WCTCF_Save_Custom_Fields_Click_Handler() {
    jQuery('.ewd-wctcf-save-button').on('click', function(event) {
        var Post_ID = jQuery('#ewd-wctcf-post-id').val();
        
        var Fields = [];
        jQuery('.ewd-wctcf-custom-field-row').each(function(index, el) {
            var Custom_Field_ID = jQuery(this).data('customfieldid');

            var CF_Toggle = jQuery('#ewd-wctcf-cf-toggle-'+Custom_Field_ID).is(':checked');
            var CF_Value= jQuery('#ewd-wctcf-input-'+Custom_Field_ID).val();

            var CF_Array = {ID:Custom_Field_ID, Value:CF_Value, Toggle:CF_Toggle};
            Fields.push(CF_Array);
        });
        var data = 'CF_Array=' + JSON.stringify(Fields) + '&Post_ID=' + Post_ID + '&action=ewd_wctcf_save_cf_data';
        jQuery.post(ajaxurl, data, function(response) {});

        event.preventDefault();
    })
}