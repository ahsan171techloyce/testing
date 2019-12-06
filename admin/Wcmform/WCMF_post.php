<?php
require_once(PLUGIN_ROOT_DIR.'/WCM_optionlist.php' );
class WCMF_post{
    public function __construct(){

        add_action('admin_menu', array($this,'WCMF_form_menu_add_pages'));
        add_action( 'init', array($this,'WCMF_create_form_post_type'),10);
        add_action('add_meta_boxes', array($this,'WCMF_create_form_meta_box'));
        add_action('save_post', array($this,'WCMF_create_form_meta_box_save_postdata'));
        add_action('media_buttons', array($this,'WCMF_add_my_media_button'));
        
    }

    /*
    * @Fucntion to create main menu page
    */
    public function WCMF_form_menu_add_pages() {
        add_submenu_page( 'WCM-dashbord', 'All Forms', 'All Forms', 'manage_options', 'edit.php?post_type=wcm_forms', NULL);
    }
    /*
     * @Register custom post type
     * Show all forms
     */
    public function WCMF_create_form_post_type(){
        $labels = array(
            'name'               => _x( 'Forms', 'post type general name', 'WCM' ),
            'singular_name'      => _x( 'Form', 'post type singular name', 'WCM' ),
            'menu_name'          => _x( 'Form', 'admin menu', 'WCM' ),
            'name_admin_bar'     => _x( 'Forms', 'add new on admin bar', 'WCM' ),
            'add_new'            => _x( 'Add New', 'team', 'WCM' ),
            'add_new_item'       => __( 'Add New Form', 'WCM' ),
            'new_item'           => __( 'New Form', 'WCM' ),
            'edit_item'          => __( 'Edit Form', 'WCM' ),
            'view_item'          => __( 'View Form', 'WCM' ),
            'all_items'          => __( 'All Form', 'WCM' ),
            'search_items'       => __( 'Search Form', 'WCM' ),
            'parent_item_colon'  => __( 'Parent Form:', 'WCM' ),
            'not_found'          => __( 'No Forms Form.', 'WCM' ),
            'not_found_in_trash' => __( 'No Forms found in Trash.', 'WCM' )
        );

        $args = array(
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => false, //<--- HERE
                'query_var'          => true,
                'rewrite'            => array( 'slug' => 'wcm_forms_list' ),
                'capability_type'    => 'post',
                'has_archive'        => true,
                'hierarchical'       => false,
                'menu_position'      => null,
                'supports'           => array('title')
        );

        register_post_type( 'wcm_forms', $args );
    }
    
    //making the meta box (Note: meta box != custom meta field)
    public function WCMF_create_form_meta_box() {
       add_meta_box(
           'WCM_form_create_area', // $id
           'Create Form', // $title
           array($this,'show_WCMF_create_form_meta_box'),  // $callback
           'wcm_forms',                 // $page
           'normal',                  // $context
           'high'                     // $priority
       );
       add_meta_box(
           'WCM_form_html_structure_create_area', // $id
           'Add Html Structure', // $title
           array($this,'show_WCMF_create_frontend_html_form_meta_box'),  // $callback
           'wcm_forms',                 // $page
           'normal',                  // $context
           'low'                     // $priority
       );
    }

    function show_WCMF_create_form_meta_box() {
        global $post;
        $field_data_array=get_post_meta($post->ID,'field_data_array',true);
		
        $counter=get_post_meta($post->ID,'counter',true);
		
        $field_data_array=maybe_unserialize($field_data_array);
		// echo '<pre>';
		// print_r($field_data_array);
		// die;
        wp_nonce_field( basename( __FILE__ ), 'wcm_form_nonce' );
        //$OptionList_obj=new WCM_OptionList;
        $OptionList_obj_dragable=WCM_optionlist::WCM_form_menu_dragable_option_array();

        $html.='<div class="wcm-form-layout">';
                $html.='<div class="wcm-formbox wcm-form-layout-left">';
                            $html.='<ul id="sortable">';
                             $html.='<input type="hidden" name="counter" id="couter-check" value="'.(!empty($counter) ? $counter : '0').'">';
                                if(!empty($field_data_array)){
                                    foreach($field_data_array as $key => $value){
										$counter=$key;
										$randon_number=rand(1,999999);
										$randon_number2=rand(10000,999999);
										switch ($value['field_type']) {
											case "Text":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
												<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
												<div class="fields-layout full-width">
													<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
													<div class="tabs-list full-width">
														<div class="tab-nav full-width">
															<ul class="full-width">
																<li><a href="#" class="active show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number.'-'. $key.'">Setting</a></li>
																<li><a href="#" class="show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number2.'-'. $key.'">Advance Setting</a></li>
															</ul>
														</div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number.'-'. $key.'">
														<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
														<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
														<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label> <input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'> </div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number2.'-'. $key.' hide">
														<div class="field-required field-group"><label class="f-b-600">Valid Regular Expresion(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_exp]" value="'.$value['field_exp'].'" placeholder="Valid Regular Expresion"></div>
														<div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['.$counter.'][field_default_val]" value="'.$value['field_default_val'].'" class="full-width"></div>
														<div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['.$counter.'][character_lenght]" value="'.$value['character_lenght'].'"> </div>
														<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Text"></div>
													</div>
												</div>
											</div>';
											break;
											case "Paragraph Text":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
													<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
													<div class="fields-layout">
														<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
														<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
														<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Paragraph Text"></div>
														<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
														<div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['.$counter.'][character_lenght]" value="'.$value['character_lenght'].'"> </div>
														<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label><input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'></div>
														<div class="field-required field-group"><label class="f-b-600">Default Value</label><textarea name="field_data_array['.$counter.'][field_default_val]" class="full-width" >'.$value['field_default_val'].'</textarea></div></div>
													</div>';
											break;
											case "Drop Down":
												$dropdown='';
												if(count($value['field_option']) > 0):
													foreach($value['field_option'] as $keydropdown => $dropdown_value):
														$dropdown.='<div class="optional-fields-area">
															<div class="field-option-name"><input type="text" placeholder="Enter Option Name" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_name]" value="'.$dropdown_value['option_name'].'"></div>
															<div class="field-option-val"><input type="text" placeholder="Enter Option Value" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_value]"  value="'.$dropdown_value['option_value'].'"></div>
															<div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-counter="'.$counter.'" data-type="dropdown" data-counter="'.$counter.'">+</span><span data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:visible">-</span></div>
														</div>';
													endforeach;
													else:
														$dropdown.='<div class="optional-fields-area">
															<div class="field-option-name"><input type="text" placeholder="Enter Option Name" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_name]" ></div>
															<div class="field-option-val"><input type="text" placeholder="Enter Option Value" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_value]" ></div>
															<div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-counter="'.$counter.'" data-type="dropdown" data-counter="'.$counter.'">+</span><span data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:visible">-</span></div>
														</div>';
												endif;
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
															<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
															<div class="fields-layout">
																<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
																<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
																<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Drop Down"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][option_counter]" class="option-counter" value="'.$value['option_counter'].'"></div>
																<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label><input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'></div>
																<div class="field-required field-group append-fields-option">'.
																	$dropdown.'
																</div>
															</div>
														</div>';
											break;
											case "Multi Select":
												$Multidropdown='';
												if(count($value['field_option']) > 0):
													foreach($value['field_option'] as $keydropdown => $dropdown_value):
														$Multidropdown.='<div class="optional-fields-area">
															<div class="field-option-name"><input type="text" placeholder="Enter Option Name" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_name]" value="'.$dropdown_value['option_name'].'"></div>
															<div class="field-option-val"><input type="text" placeholder="Enter Option Value" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_value]"  value="'.$dropdown_value['option_value'].'"></div>
															<div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-counter="'.$counter.'" data-type="dropdown" data-counter="'.$counter.'">+</span><span data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:visible">-</span></div>
														</div>';
													endforeach;
													else:
														$Multidropdown.='<div class="optional-fields-area">
															<div class="field-option-name"><input type="text" placeholder="Enter Option Name" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_name]" ></div>
															<div class="field-option-val"><input type="text" placeholder="Enter Option Value" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_value]" ></div>
															<div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-counter="'.$counter.'" data-type="dropdown" data-counter="'.$counter.'">+</span><span data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:visible">-</span></div>
														</div>';
												endif;
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
															<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
															<div class="fields-layout">
																<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
																<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
																<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Multi Select"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][option_counter]" class="option-counter" value="'.$value['option_counter'].'"></div>
																<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label><input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'></div>
																<div class="field-required field-group append-fields-option">'.
																	$Multidropdown.'
																</div>
															</div>
														</div>';
											break;
											case "Number":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
															<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
															<div class="fields-layout">
																<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
																<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
																<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
																<div class="field-required field-group"><label class="f-b-600">Valid Regular Expresion(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_exp]" value="'.$value['field_exp'].'" placeholder="Valid Regular Expresion"></div>
																<div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['.$counter.'][field_default_val]" value="'.$value['field_default_val'].'" class="full-width"></div>
																<div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['.$counter.'][character_lenght]" value="'.$value['character_lenght'].'"> </div>
																<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label> <input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'> </div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Number"></div>
															</div>
														</div>';
											break;
											case "Checkboxes":
												$Checkboxes='';
												if(count($value['field_option']) > 0):
													foreach($value['field_option'] as $keydropdown => $dropdown_value):
														$Checkboxes.='<div class="optional-fields-area">
															<div class="field-option-name"><input type="text" placeholder="Enter Label Name" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_name]" value="'.$dropdown_value['option_name'].'"></div>
															<div class="field-option-val"><input type="text" placeholder="Enter Label Value" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_value]"  value="'.$dropdown_value['option_value'].'"></div>
															<div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-counter="'.$counter.'" data-type="dropdown" data-counter="'.$counter.'">+</span><span data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:visible">-</span></div>
														</div>';
													endforeach;
													else:
														$Checkboxes.='<div class="optional-fields-area">
															<div class="field-option-name"><input type="text" placeholder="Enter Label Name" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_name]" ></div>
															<div class="field-option-val"><input type="text" placeholder="Enter Label Value" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_value]" ></div>
															<div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-counter="'.$counter.'" data-type="dropdown" data-counter="'.$counter.'">+</span><span data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:visible">-</span></div>
														</div>';
												endif;
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
															<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
															<div class="fields-layout">
																<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
																<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
																<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Checkboxes"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][option_counter]" class="option-counter" value="'.$value['option_counter'].'"></div>
																<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label><input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'></div>
																<div class="field-required field-group append-fields-option">'.
																	$Checkboxes.'
																</div>
															</div>
														</div>';
											break;
											case "Radio Buttons":
												$RadioButton='';
												if(count($value['field_option']) > 0):
													foreach($value['field_option'] as $keydropdown => $dropdown_value):
														$RadioButton.='<div class="optional-fields-area">
															<div class="field-option-name"><input type="text" placeholder="Enter Label Name" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_name]" value="'.$dropdown_value['option_name'].'"></div>
															<div class="field-option-val"><input type="text" placeholder="Enter Label Value" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_value]"  value="'.$dropdown_value['option_value'].'"></div>
															<div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-counter="'.$counter.'" data-type="dropdown" data-counter="'.$counter.'">+</span><span data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:visible">-</span></div>
														</div>';
													endforeach;
													else:
														$RadioButton.='<div class="optional-fields-area">
															<div class="field-option-name"><input type="text" placeholder="Enter Label Name" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_name]" ></div>
															<div class="field-option-val"><input type="text" placeholder="Enter Label Value" name="field_data_array['.$counter.'][field_option]['.$keydropdown .'][option_value]" ></div>
															<div class="field-option-add-remove"><span class="wcm_add-option" data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-counter="'.$counter.'" data-type="dropdown" data-counter="'.$counter.'">+</span><span data-mparent="parent-'.$counter.'" data-append="append-fields-option" data-type="dropdown" class="wcm_remove-option" style="visibility:visible">-</span></div>
														</div>';
												endif;
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
															<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
															<div class="fields-layout">
																<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
																<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
																<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Radio Buttons"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][option_counter]" class="option-counter" value="'.$value['option_counter'].'"></div>
																<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label><input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'></div>
																<div class="field-required field-group append-fields-option">'.
																	$RadioButton.'
																</div>
															</div>
														</div>';
											break;
											case "Hidden":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
															<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
															<div class="fields-layout">
																<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label"></div>
																<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
																<div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['.$counter.'][field_default_val]" class="full-width"></div>
																<div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['.$counter.'][character_lenght]"> </div>
																<div class="field-label field-group"><label class="f-b-600">Enter Parameter(optional)</label><input type="text" class="label-text" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_dynamic_parameter]" placeholder="Enter Parameter"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Hidden"></div>
															</div>
														</div>';
											break;
											case "HTML":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
															<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
															<div class="fields-layout">
																<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label"></div>
																<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
																<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="HTML"></div>
																<div class="field-required field-group"><label class="f-b-600">HTML</label><textarea name="field_data_array['.$counter.'][field_default_val]" class="full-width">'.$value['field_default_val'].'</textarea></div>
															</div>
														</div>';
											break;
											case "Phone":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
												<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
												<div class="fields-layout full-width">
													<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
													<div class="tabs-list full-width">
														<div class="tab-nav full-width">
															<ul class="full-width">
																<li><a href="#" class="active show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number.'-'. $key.'">Setting</a></li>
																<li><a href="#" class="show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number2.'-'. $key.'">Advance Setting</a></li>
															</ul>
														</div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number.'-'. $key.'">
														<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
														<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
														<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label> <input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'> </div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number2.'-'. $key.' hide">
														<div class="field-required field-group"><label class="f-b-600">Valid Regular Expresion(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_exp]" value="'.$value['field_exp'].'" placeholder="Valid Regular Expresion"></div>
														<div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['.$counter.'][field_default_val]" value="'.$value['field_default_val'].'" class="full-width"></div>
														<div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['.$counter.'][character_lenght]" value="'.$value['character_lenght'].'"> </div>
														<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Phone"></div>
													</div>
												</div>
											</div>';
											break;
											case "State":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
												<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
												<div class="fields-layout full-width">
													<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
													<div class="tabs-list full-width">
														<div class="tab-nav full-width">
															<ul class="full-width">
																<li><a href="#" class="active show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number.'-'. $key.'">Setting</a></li>
																<li><a href="#" class="show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number2.'-'. $key.'">Advance Setting</a></li>
															</ul>
														</div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number.'-'. $key.'">
														<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
														<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
														<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label> <input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'> </div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number2.'-'. $key.' hide">
														<div class="field-required field-group"><label class="f-b-600">Valid Regular Expresion(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_exp]" value="'.$value['field_exp'].'" placeholder="Valid Regular Expresion"></div>
														<div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['.$counter.'][field_default_val]" value="'.$value['field_default_val'].'" class="full-width"></div>
														<div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['.$counter.'][character_lenght]" value="'.$value['character_lenght'].'"> </div>
														<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="State"></div>
													</div>
												</div>
											</div>';
											break;
											case "ZipCode":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
												<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
												<div class="fields-layout full-width">
													<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
													<div class="tabs-list full-width">
														<div class="tab-nav full-width">
															<ul class="full-width">
																<li><a href="#" class="active show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number.'-'. $key.'">Setting</a></li>
																<li><a href="#" class="show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number2.'-'. $key.'">Advance Setting</a></li>
															</ul>
														</div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number.'-'. $key.'">
														<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
														<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
														<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label> <input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'> </div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number2.'-'. $key.' hide">
														<div class="field-required field-group"><label class="f-b-600">Valid Regular Expresion(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_exp]" value="'.$value['field_exp'].'" placeholder="Valid Regular Expresion"></div>
														<div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['.$counter.'][field_default_val]" value="'.$value['field_default_val'].'" class="full-width"></div>
														<div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['.$counter.'][character_lenght]" value="'.$value['character_lenght'].'"> </div>
														<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="ZipCode"></div>
													</div>
												</div>
											</div>';
											break;
											case "Email":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
												<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
												<div class="fields-layout full-width">
													<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
													<div class="tabs-list full-width">
														<div class="tab-nav full-width">
															<ul class="full-width">
																<li><a href="#" class="active show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number.'-'. $key.'">Setting</a></li>
																<li><a href="#" class="show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number2.'-'. $key.'">Advance Setting</a></li>
															</ul>
														</div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number.'-'. $key.'">
														<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
														<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
														<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label> <input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'> </div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number2.'-'. $key.' hide">
														<div class="field-required field-group"><label class="f-b-600">Valid Regular Expresion(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_exp]" value="'.$value['field_exp'].'" placeholder="Valid Regular Expresion"></div>
														<div class="field-required field-group"><label class="f-b-600">Default Value(Optional)</label><input type="text" placeholder="Default Value" name="field_data_array['.$counter.'][field_default_val]" value="'.$value['field_default_val'].'" class="full-width"></div>
														<div class="field-required field-group"><label class="f-b-600">Character Lenght(Optional)</label> <input type="text" name="field_data_array['.$counter.'][character_lenght]" value="'.$value['character_lenght'].'"> </div>
														<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="Email"></div>
													</div>
												</div>
											</div>';
											break;
											case "File":
												$html.='<div class="main-field-content" id="parent-'.$counter.'">
												<div class="main-title"><span class="label-txt-area">'.$value['field_label'].'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
												<div class="fields-layout full-width">
													<div class="field-label field-group"><label class="f-b-600">Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$counter.'" name="field_data_array['.$counter.'][field_label]" placeholder="Field label" value="'.$value['field_label'].'"></div>
													<div class="tabs-list full-width">
														<div class="tab-nav full-width">
															<ul class="full-width">
																<li><a href="#" class="active show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number.'-'. $key.'">Setting</a></li>
																<li><a href="#" class="show-hide" data-pid="parent-'.$counter.'" data-id="'.$randon_number2.'-'. $key.'">Advance Setting</a></li>
															</ul>
														</div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number.'-'. $key.'">
														<div class="field-name field-group"><label class="f-b-600">Enter Field Name</label><input type="text" name="field_data_array['.$counter.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
														<div class="field-required field-group"><label class="f-b-600">Error Message(Optional)</label><input type="text" name="field_data_array['.$counter.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
														<div class="field-required field-group"><label class="f-b-600">Required(Optional)</label> <input type="checkbox" name="field_data_array['.$counter.'][check_required]" value="1" '.($value['check_required']==1 ? 'checked' : '').'> </div>
													</div>
													<div class="settingsp full-width setting-'.$randon_number2.'-'. $key.' hide">
														<div class="field-required field-group"><label class="f-b-600">Max File Size(Optional)</label><input type="number" name="field_data_array['.$counter.'][field_exp]" value="'.$value['field_file_size'].'" placeholder="Enter Max File Size"></div>
														<div class="field-required field-group"><input type="hidden" name="field_data_array['.$counter.'][field_type]" value="File"></div>
													</div>
												</div>
											</div>';
											break;
											default:
												echo "No More fields here";
										}
									
                                    }
                                }
                            $html.='</ul>';	
                $html.='</div>';
                
                $html.='<div class="wcm-formbox wcm-form-layout-right">';
						$html.='<h3 class="text-center">'.apply_filters( 'change_admin_form_fields_right_main_title', 'Dragable Fields' ).'</h3>';
                        $html.='<ul class="list-field">';
                                    $html.='<li>';
                                        $html.='<ol class="field_type">';
                                            foreach($OptionList_obj_dragable['Dragable Fields'] as $single_item){
                                                $html.='<li class="draggable"  field-type="'.$single_item.'">'.$single_item.'</li>';
                                            }
                                        $html.='</ol>';
                                $html.='</li>';

                        $html.='</ul>';
                $html.='</div>';

        $html.='</div>';
        echo $html;
    }
    
    
    public function show_WCMF_create_frontend_html_form_meta_box(){
        wp_editor( 'Please publish form first then add html structure here', 'mettaabox_ID', $settings = array('textarea_name'=>'MyInputNAME') );
    }
    public function WCMF_create_form_meta_box_save_postdata($post_id){
        
		// echo '<pre>';
		// print_r($_POST['field_data_array']);
		// die;
		if (array_key_exists('wcm_form_nonce', $_POST)) {
           $couter= $_POST['counter'];
           $field_data_array=$_POST['field_data_array'];
           update_post_meta($post_id,'field_data_array',maybe_serialize($field_data_array));
           update_post_meta($post_id, 'counter',$couter);
        }
    }
    public function WCMF_add_my_media_button() {
		global $post;
        $field_data_array=get_post_meta($post->ID,'field_data_array',true);
        $field_data_array=maybe_unserialize($field_data_array);
		// echo '<pre>';
		// print_r($post);
		// die;
		$data="'this is testing form my side'";
        echo '<a href="javascript:;" id="insert-my-media" class="button" onclick="open_media_window('.$data.')">Add my media</a>';
    }
   	
}
new WCMF_post;
