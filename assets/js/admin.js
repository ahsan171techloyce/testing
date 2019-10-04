jQuery( function() {
	
    /*
     * @Show hide div of left side on click arrow icone
     * @ Main Form creation page
     * */
    jQuery( ".wcm-form-layout-left" ).on('click','.main-title .dashicons-arrow-down',function(){
        jQuery(this).parent().parent().next().slideToggle();
    });
    /*
     * @Sort divs
     * @ Main Form creation page
     * */
    jQuery( "#sortable" ).sortable({
      revert: true
    });
    /*
     * @Drag divs
     * @ Main Form creation page
     * */
    jQuery( ".draggable" ).draggable({
        connectToSortable: "#sortable",
        cursor: "crosshair",
        helper: "clone",
        //revert: "invalid",
	helper: function( event ) {
           var counter=jQuery('#couter-check').val();
            var current_type=jQuery(event.target).attr('field-type');
            if(current_type==='Text'){
                var random = Math.floor(Math.random() * 99999999) + 1; 
                var html='<div class="main-field-content" id="parent-'+counter+'">\n\
                            <div class="main-title"><span class="label-txt-area">'+current_type+'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>\n\
                            <div class="fields-layout">\n\
                                <div class="field-label field-group"><label>Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label>Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><input type="checkbox" name="field_data_array['+counter+'][check_required]" value="1" ></div>\n\
                                <div class="field-required field-group"><input type="text" name="field_data_array['+counter+'][field_message]" placeholder="Enter error message"></div></div>\n\
                        </div>';
                return jQuery(html);
            }
            else{
                return jQuery( "<li class='ui-state-default'><input type='text'></li>" );
            }
        },
	  
	  stop: function( event, ui ) {
		 jQuery(event.target).addClass("active-fields");
                var current_couter=jQuery('#couter-check').val();
                jQuery('#couter-check').val(parseInt(current_couter)+parseInt(1));
		//var currentobj=jQuery(event.target).addClass("class");
		//jQuery(this).addClass("ui-state-highlight33333").find("p").html("Dropped in " + this.id);
	  }
    });
    //jQuery( "ul, li" ).disableSelection();
    
    /*
     * @Submit Main form to create the forms
     * @ Main Form creation page
     * */
    jQuery("#creat-form-data").submit(function(event){
        event.preventDefault(); //prevent default action 
        var frm = jQuery('#creat-form-data');
        
        jQuery.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
            success: function (data) {
                console.log('Submission was successful.');
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });
    });
    
} );
/*
 * @Get label field value and put into main title
 * @ Main Form creation page
 * */
function label_field_value(obj){
   
    var parentID=obj.getAttribute('data-parent');
    jQuery('#'+parentID+' .label-txt-area').text(obj.value);
}
function open_media_window() {
    wp.media.editor.insert('this is testing here');
        
}
