jQuery(document).ready(function() {
    WCTCF_ReorderList();
    WCTCF_Set_Tab_Visibility_Handlers();
    WCTCF_Save_Custom_Fields_Click_Handler();
});

function WCTCF_ReorderList() {
    jQuery(".wp-list-table tbody").sortable({
    	stop: function( event, ui ) {WCTCF_saveOrderClick(); }
    }).disableSelection();
}

function WCTCF_saveOrderClick() {
    // ----- Retrieve the li items inside our sortable list
    var items = jQuery(".wp-list-table tbody tr");

    var linkIDs = [items.size()];
    var index = 0;

    // ----- Iterate through each li, extracting the ID embedded as an attribute
    items.each(
        function(intIndex) {
            linkIDs[intIndex] = jQuery(this).attr("id").substring(5);
            jQuery(this).find('.menu_order').html(intIndex+1);
            index++;
        });

    var data = 'IDs=' + JSON.stringify(linkIDs) + '&action=ewd_wctcf_tabs_update_order';
    jQuery.post(ajaxurl, data, function(response) {});

    //$get("<%=txtExampleItemsOrder.ClientID %>").value = linkIDs.join(",");
}

function WCTCF_Set_Tab_Visibility_Handlers() {
    jQuery('.ewd-wctcf-visibility-toggle').on('click', function() {
        var visbility = jQuery(this).data('visibilityvalue');
        var postid = jQuery(this).data('postid');

        var data = 'visbility=' + visbility + '&postid=' + postid + '&action=ewd_wctcf_tabs_update_visbility';
        jQuery.post(ajaxurl, data, function(response) {});

        if (visbility == "Show") {var HTML = "Show (<span class='ewd-wctcf-visibility-toggle' data-visibilityvalue='Hide' data-postid='" + postid + "'>Hide</span>)";}
        else {var HTML = "Hide (<span class='ewd-wctcf-visibility-toggle' data-visibilityvalue='Show' data-postid='" + postid + "'>Show</span>)";}
        jQuery(this).parent().html(HTML);

        WCTCF_Set_Tab_Visibility_Handlers();
    })
}

function WCTCF_Save_Custom_Fields_Click_Handler() {
    jQuery('.ewd-wctcf-save-button').on('click', function(event) {
        var Post_ID = jQuery('#ewd-wctcf-post-id').val();

        var Fields = [];
        jQuery('.ewd-wctcf-custom-field-row').each(function(index, el) {
            var Custom_Field_ID = jQuery(this).data('customfieldid');

            var CF_Toggle = jQuery('#ewd-wctcf-cf-toggle-'+Custom_Field_ID).val();
            var CF_Value = jQuery('#ewd-wctcf-input-'+Custom_Field_ID).val();

            var CF_Array = {ID:Custom_Field_ID, Value:CF_Value, Toggle:CF_Toggle};
            Fields.push(CF_Array);
        });
        var data = 'CF_Array=' + JSON.stringify(Fields) + '&Post_ID=' + Post_ID + '&action=ewd_wctcf_save_cf_data';
        jQuery.post(ajaxurl, data, function(response) {});

        event.preventDefault();
    })
}

jQuery(document).ready(function() {
    jQuery('.ewd-us-spectrum').spectrum({
        showInput: true,
        showInitial: true,
        preferredFormat: "hex",
        allowEmpty: true
    });

    jQuery('.ewd-us-spectrum').css('display', 'inline');

    jQuery('.ewd-us-spectrum').on('change', function() {
        if (jQuery(this).val() != "") {
            jQuery(this).css('background', jQuery(this).val());
            var rgb = EWD_US_hexToRgb(jQuery(this).val());
            var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
            if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
            else {jQuery(this).css('color', '#000000');}
        }
        else {
            jQuery(this).css('background', 'none');
        }
    });

    jQuery('.ewd-us-spectrum').each(function() {
        if (jQuery(this).val() != "") {
            jQuery(this).css('background', jQuery(this).val());
            var rgb = EWD_US_hexToRgb(jQuery(this).val());
            var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
            if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
            else {jQuery(this).css('color', '#000000');}
        }
    });
});

function EWD_US_hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}