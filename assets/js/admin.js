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
                                <div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['+counter+'][field_message]" placeholder="Enter error message"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Valid Regular Expresion(Optional)</label><input type="text" name="field_data_array['+counter+'][field_exp]" placeholder="Valid Regular Expresion"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['+counter+'][field_default_val]" class="full-width"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['+counter+'][character_lenght]"> </div>\n\
								<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label> <input type="checkbox" name="field_data_array['+counter+'][check_required]" value="1" > </div>\n\
                                <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][field_type]" value="Text"></div></div>\n\
                        </div>';
                return jQuery(html);
            }
            else if(current_type==='Paragraph Text'){
               var random = Math.floor(Math.random() * 99999999) + 1; 
                var html='<div class="main-field-content" id="parent-'+counter+'">\n\
                            <div class="main-title"><span class="label-txt-area">'+current_type+'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>\n\
                            <div class="fields-layout">\n\
                                <div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][field_type]" value="Paragraph Text"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['+counter+'][field_message]" placeholder="Enter error message"></div>\n\
								<div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['+counter+'][character_lenght]"> </div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Required(Optional)</label><input type="checkbox" name="field_data_array['+counter+'][check_required]" value="1" ></div>\n\
								<div class="field-required field-group"><label class="f-b-600">Default Value</label><textarea name="field_data_array['+counter+'][field_default_val]" class="full-width"></textarea></div></div>\n\
                        </div>';
                return jQuery(html);

            }
            else if(current_type==='Drop Down'){
                var random = Math.floor(Math.random() * 99999999) + 1; 
                var html='<div class="main-field-content" id="parent-'+counter+'">\n\
                            <div class="main-title"><span class="label-txt-area">'+current_type+'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>\n\
                            <div class="fields-layout">\n\
                                <div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['+counter+'][field_message]" placeholder="Enter error message"></div>\n\
                                <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][field_type]" value="Drop Down"></div>\n\
                                <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][option_counter]" class="option-counter" value="0"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Required(Optional)</label><input type="checkbox" name="field_data_array['+counter+'][check_required]" value="1" ></div>\n\
								<div class="field-required field-group append-fields-option">\n\
                                    <div class="optional-fields-area">\n\
                                        <div class="field-option-name"><input type="text" placeholder="Enter Option Name" name="field_data_array['+counter+'][field_option][0][option_name]"></div>\n\
                                        <div class="field-option-val"><input type="text" placeholder="Enter Option Value" name="field_data_array['+counter+'][field_option][0][option_value]"></div>\n\
                                        <div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'+counter+'" data-append="append-fields-option" data-counter="'+counter+'" data-type="dropdown" data-counter="'+counter+'">+</span><span data-mparent="parent-'+counter+'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:hidden">-</span></div>\n\
                                    </div>\n\
                                </div>\n\
                                </div>\n\
                            </div>';
                return jQuery(html);

            }
            else if(current_type==='Multi Select'){
                 var random = Math.floor(Math.random() * 99999999) + 1; 
                var html='<div class="main-field-content" id="parent-'+counter+'">\n\
                            <div class="main-title"><span class="label-txt-area">'+current_type+'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>\n\
                            <div class="fields-layout">\n\
                                <div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><input type="checkbox" name="field_data_array['+counter+'][check_required]" value="1" ></div>\n\
                                <div class="field-required field-group"><input type="text" name="field_data_array['+counter+'][field_message]" placeholder="Enter error message"></div>\n\
                                <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][field_type]" value="Multi Select"></div>\n\
                                 <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][option_counter]" class="option-counter" value="0"></div>\n\
								<div class="field-required field-group append-fields-option">\n\
                                    <div class="optional-fields-area">\n\
                                        <div class="field-option-name"><input type="text" placeholder="Enter Option Name"></div>\n\
                                        <div class="field-option-val"><input type="text" placeholder="Enter Option Value"></div>\n\
                                        <div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'+counter+'" data-append="append-fields-option" data-type="dropdown" data-counter="'+counter+'">+</span><span data-mparent="parent-'+counter+'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:hidden">-</span></div>\n\
                                    </div>\n\
                                </div>\n\
                                </div>\n\
                            </div>';
                return jQuery(html);


            }
            else if(current_type==='Number'){
				var random = Math.floor(Math.random() * 99999999) + 1; 
                var html='<div class="main-field-content" id="parent-'+counter+'">\n\
                            <div class="main-title"><span class="label-txt-area">'+current_type+'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>\n\
                            <div class="fields-layout">\n\
                                <div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['+counter+'][field_message]" placeholder="Enter error message"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Valid Regular Expresion(Optional)</label><input type="text" name="field_data_array['+counter+'][field_exp]" placeholder="Valid Regular Expresion"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['+counter+'][field_default_val]" class="full-width"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['+counter+'][character_lenght]"> </div>\n\
								<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label> <input type="checkbox" name="field_data_array['+counter+'][check_required]" value="1" > </div>\n\
                                <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][field_type]" value="Number"></div></div>\n\
                        </div>';
                return jQuery(html);
            }
            else if(current_type==='Checkboxes'){
                var random = Math.floor(Math.random() * 99999999) + 1; 
                var html='<div class="main-field-content" id="parent-'+counter+'">\n\
                            <div class="main-title"><span class="label-txt-area">'+current_type+'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>\n\
                            <div class="fields-layout">\n\
                                <div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><input type="checkbox" name="field_data_array['+counter+'][check_required]" value="1" ></div>\n\
                                <div class="field-required field-group"><input type="text" name="field_data_array['+counter+'][field_message]" placeholder="Enter error message"></div>\n\
                                <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][field_type]" value="Checkboxes"></div>\n\
                                 <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][option_counter]" class="option-counter" value="0"></div>\n\
								<div class="field-required field-group append-fields-option">\n\
                                    <div class="optional-fields-area">\n\
                                        <div class="field-option-name"><input type="text" placeholder="Enter Label Name"></div>\n\
                                        <div class="field-option-val"><input type="text" placeholder="Enter Value"></div>\n\
                                        <div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'+counter+'" data-append="append-fields-option" data-type="Checkboxes" data-counter="'+counter+'">+</span><span data-mparent="parent-'+counter+'" data-append="append-fields-option" data-type="Checkboxes" class="wcm_remove-option" style="visibility:hidden">-</span></div>\n\
                                    </div>\n\
                                </div>\n\
                                </div>\n\
                            </div>';
                return jQuery(html);


            }
            else if(current_type==='Radio Buttons'){
                var random = Math.floor(Math.random() * 99999999) + 1; 
                var html='<div class="main-field-content" id="parent-'+counter+'">\n\
                            <div class="main-title"><span class="label-txt-area">'+current_type+'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>\n\
                            <div class="fields-layout">\n\
                                <div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><input type="checkbox" name="field_data_array['+counter+'][check_required]" value="1" ></div>\n\
                                <div class="field-required field-group"><input type="text" name="field_data_array['+counter+'][field_message]" placeholder="Enter error message"></div>\n\
                                <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][field_type]" value="Radio Buttons"></div>\n\
                                 <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][option_counter]" class="option-counter" value="0"></div>\n\
								<div class="field-required field-group append-fields-option">\n\
                                    <div class="optional-fields-area">\n\
                                        <div class="field-option-name"><input type="text" placeholder="Enter Label Name"></div>\n\
                                        <div class="field-option-val"><input type="text" placeholder="Enter Value"></div>\n\
                                        <div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'+counter+'" data-append="append-fields-option" data-type="Radio Buttons" data-counter="'+counter+'">+</span><span data-mparent="parent-'+counter+'" data-append="append-fields-option" data-type="Radio Buttons" class="wcm_remove-option" style="visibility:hidden">-</span></div>\n\
                                    </div>\n\
                                </div>\n\
                                </div>\n\
                            </div>';
                return jQuery(html);
            }
            else if(current_type==='Hidden'){
				var random = Math.floor(Math.random() * 99999999) + 1; 
                var html='<div class="main-field-content" id="parent-'+counter+'">\n\
                            <div class="main-title"><span class="label-txt-area">'+current_type+'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>\n\
                            <div class="fields-layout">\n\
                                <div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['+counter+'][field_default_val]" class="full-width"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['+counter+'][character_lenght]"> </div>\n\
                                 <div class="field-label field-group"><label class="f-b-600">Enter Parameter(optional)</label><input type="text" class="label-text" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_dynamic_parameter]" placeholder="Enter Parameter"></div>\n\
								<div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][field_type]" value="Hidden"></div></div>\n\
                        </div>';
                return jQuery(html);
            }
            else if(current_type==='HTML'){
				var random = Math.floor(Math.random() * 99999999) + 1; 
                var html='<div class="main-field-content" id="parent-'+counter+'">\n\
                            <div class="main-title"><span class="label-txt-area">'+current_type+'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>\n\
                            <div class="fields-layout">\n\
                                <div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'+counter+'" name="field_data_array['+counter+'][field_label]" placeholder="Field label"></div>\n\
                                <div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['+counter+'][field_name]" value="field_'+counter+'_'+random+'" placeholder="Enter Field Name"></div>\n\
                                <div class="field-required field-group"><input type="hidden" name="field_data_array['+counter+'][field_type]" value="HTML"></div>\n\
                                <div class="field-required field-group"><label class="f-b-600">HTML</label><textarea name="field_data_array['+counter+'][field_default_val]" class="full-width"></textarea></div></div>\n\
                        </div>';
                return jQuery(html);

            }
            else{
                //return jQuery( "<li class='ui-state-default'><input type='text'></li>" );
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
    
    /*****************************************************
     * 
     * @Add form option on click +
     * @Remove form option on click -
     */   
    jQuery(document).on('click','.wcm_add-option',function(){
       var parentdiv=jQuery(this).attr('data-mparent'); 
       var AppendAfter=jQuery(this).attr('data-append'); 
       var DataType=jQuery(this).attr('data-type');
       var parentcounter=jQuery(this).attr('data-counter');
	   var OptionCounter=jQuery('#'+parentdiv+' .option-counter').val();
	   
       var index=jQuery(this).parent().parent().index();
       if(DataType==='dropdown'){
		  var OptionCounterValue=parseInt(OptionCounter)+1;
         jQuery('<div class="optional-fields-area">\n\
            <div class="field-option-name"><input type="text" placeholder="Enter Option Name" name="field_data_array['+parentcounter+'][field_option]['+OptionCounterValue+'][option_name]"></div>\n\
            <div class="field-option-val"><input type="text" placeholder="Enter Option Value" name="field_data_array['+parentcounter+'][field_option]['+OptionCounterValue+'][option_value]"></div>\n\
            <div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="'+parentdiv+'" data-append="append-fields-option" data-type="dropdown" data-counter="'+parentcounter+'">+</span><span data-mparent="'+parentdiv+'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option">-</span></div>\n\
        </div>').insertAfter(jQuery('#'+parentdiv+' .'+AppendAfter+' .optional-fields-area:eq('+index+')'));
        jQuery('#'+parentdiv+' .option-counter').val(OptionCounterValue);
		}
        else if(DataType==='Checkboxes'){
			var OptionCounterValue=parseInt(OptionCounter)+1;
         jQuery('<div class="optional-fields-area">\n\
            <div class="field-option-name"><input type="text" placeholder="Enter Label Name" name="field_data_array['+parentcounter+'][field_option]['+OptionCounterValue+'][option_name]"></div>\n\
            <div class="field-option-val"><input type="text" placeholder="Enter Value" name="field_data_array['+parentcounter+'][field_option]['+OptionCounterValue+'][option_value]"></div>\n\
            <div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="'+parentdiv+'" data-append="append-fields-option" data-type="Checkboxes" data-counter="'+parentcounter+'">+</span><span data-mparent="'+parentdiv+'" data-append="append-fields-option" data-type="Checkboxes" class="wcm_remove-option">-</span></div>\n\
        </div>').insertAfter(jQuery('#'+parentdiv+' .'+AppendAfter+' .optional-fields-area:eq('+index+')'));
    
        }
        else if(DataType==='Radio Buttons'){
			var OptionCounterValue=parseInt(OptionCounter)+1;
         jQuery('<div class="optional-fields-area">\n\
            <div class="field-option-name"><input type="text" placeholder="Enter Label Name" name="field_data_array['+parentcounter+'][field_option]['+OptionCounterValue+'][option_name]"></div>\n\
            <div class="field-option-val"><input type="text" placeholder="Enter Value" name="field_data_array['+parentcounter+'][field_option]['+OptionCounterValue+'][option_value]"></div>\n\
            <div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="'+parentdiv+'" data-append="append-fields-option" data-type="Radio Buttons" data-counter="'+parentcounter+'">+</span><span data-mparent="'+parentdiv+'" data-append="append-fields-option" data-type="Radio Buttons" class="wcm_remove-option">-</span></div>\n\
        </div>').insertAfter(jQuery('#'+parentdiv+' .'+AppendAfter+' .optional-fields-area:eq('+index+')'));
    
        }
    });
    jQuery(document).on('click','.wcm_remove-option',function(){
       var parentdiv=jQuery(this).attr('data-mparent'); 
       var AppendAfter=jQuery(this).attr('data-append'); 
       var DataType=jQuery(this).attr('data-type');
       var index=jQuery(this).parent().parent().index();
       if(DataType==='dropdown'){
            jQuery('#'+parentdiv+' .'+AppendAfter+' .optional-fields-area:eq('+index+')').remove();
        }
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
