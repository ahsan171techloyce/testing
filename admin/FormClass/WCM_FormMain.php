<?php
require_once(PLUGIN_ROOT_DIR.'/WCM_OptionList.php' );
class WCM_FormMain{
    public function __construct(){

        add_action('admin_menu', array($this,'WCM_form_menu_add_pages'));
        add_action( 'init', array($this,'WCM_create_form_post_type'),10);
        add_action('add_meta_boxes', array($this,'WCM_create_form_meta_box'));
        add_action('save_post', array($this,'WCM_create_form_meta_box_save_postdata'));
        add_action('media_buttons', array($this,'add_my_media_button'));
        
    }

    /*
    * @Fucntion to create main menu page
    */
    public function WCM_form_menu_add_pages() {
        add_submenu_page( 'WCM-dashbord', 'All Forms', 'All Forms', 'manage_options', 'edit.php?post_type=wcm_forms', NULL);
    }
    /*
     * @Register custom post type
     * Show all forms
     */
    public function WCM_create_form_post_type(){
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
    public function WCM_create_form_meta_box() {
       add_meta_box(
           'WCM_form_create_area', // $id
           'Create Form', // $title
           array($this,'show_WCM_create_form_meta_box'),  // $callback
           'wcm_forms',                 // $page
           'normal',                  // $context
           'high'                     // $priority
       );
       add_meta_box(
           'WCM_form_html_structure_create_area', // $id
           'Add Html Structure', // $title
           array($this,'show_WCM_create_frontend_html_form_meta_box'),  // $callback
           'wcm_forms',                 // $page
           'normal',                  // $context
           'low'                     // $priority
       );
    }

    function show_WCM_create_form_meta_box() {
        global $post;
        $field_data_array=get_post_meta($post->ID,'field_data_array',true);
        $counter=get_post_meta($post->ID,'counter',true);
        $field_data_array=maybe_unserialize($field_data_array);
        wp_nonce_field( basename( __FILE__ ), 'wcm_form_nonce' );
        $OptionList_obj=new WCM_OptionList;
        $OptionList_obj_dragable=$OptionList_obj->WCM_form_menu_dragable_option_array();

        $html.='<div class="wcm-form-layout">';
                $html.='<div class="wcm-formbox wcm-form-layout-left">';
                            $html.='<ul id="sortable">';
                             $html.='<input type="hidden" name="counter" id="couter-check" value="'.(!empty($counter) ? $counter : '0').'">';
                                if(!empty($field_data_array)){
                                    foreach($field_data_array as $key => $value){
                                    $html.='<div class="main-field-content" id="parent-'.(!empty($key) ? $key : '0').'">
                                                <div class="main-title"><span class="label-txt-area">'.(!empty($value['field_label']) ? $value['field_label'] : 'Label '.$key).'</span><div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
                                                <div class="fields-layout">
                                                    <div class="field-label field-group"><label>Enter Lable Name</label><input type="text" class="label-text" onkeyup="label_field_value(this);" data-parent="parent-'.$key.'" name="field_data_array['.$key.'][field_label]" value="'.$value['field_label'].'" placeholder="Field label"></div>
                                                    <div class="field-name field-group"><label>Enter Field Name</label><input type="text" name="field_data_array['.$key.'][field_name]" value="'.$value['field_name'].'" placeholder="Enter Field Name"></div>
                                                    <div class="field-required field-group"><input type="checkbox" name="field_data_array['.$key.'][check_required]" value="1" '.(!empty($value['check_required']) && $value['check_required']==1  ? 'checked' : '').'></div>
                                                    <div class="field-required field-group"><input type="text" name="field_data_array['.$key.'][field_message]" value="'.$value['field_message'].'" placeholder="Enter error message"></div>
                                                 </div>
                                         </div>';
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
    
    
    public function show_WCM_create_frontend_html_form_meta_box(){
        wp_editor( 'Please publish form first then add html structure here', 'mettaabox_ID', $settings = array('textarea_name'=>'MyInputNAME') );
    }
    public function WCM_create_form_meta_box_save_postdata($post_id){
        
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
    public function add_my_media_button() {
        echo '<a href="javascript:;" id="insert-my-media" class="button" onclick="open_media_window()">Add my media</a>';
    }
   	
}
new WCM_FormMain;
