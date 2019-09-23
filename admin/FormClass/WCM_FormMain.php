<?php
require_once(PLUGIN_ROOT_DIR.'/WCM_OptionList.php' );
class WCM_FormMain{
	public function __construct(){
		add_action('admin_menu', array($this,'WCM_form_menu_add_pages'));
	}
	
	/*
	* @Fucntion to create main menu page
	*/
	public function WCM_form_menu_add_pages() {
		add_submenu_page( 'WCM-dashbord', 'Manage Form', 'Manage Form', 'manage_options', 'WCM_form-manager', array($this,'WCM_form_menu_add_pages_callback' )); 

	}

	/*
	* @Display main menu html forms.
	*/
	 public function WCM_form_menu_add_pages_callback() {
		$OptionList_obj=new WCM_OptionList;
		$OptionList_obj_dragable=$OptionList_obj->WCM_form_menu_dragable_option_array();
		
		$html.='<div class="page-title">Creat Form</div>';
		$html.='<div class="wcm-form-layout">';
			$html.='<div class="wcm-formbox wcm-form-layout-left">';
				$html.='<form>';
					$html.='<ul id="sortable">';
					$html.='</ul>';
					
					$html.='<input type="submit" name="submit" class="submit-btn">';	
				$html.='</form>';
			$html.='</div>';
			$html.='<div class="wcm-formbox wcm-form-layout-right">';
				$html.='<ul class="list-field">';
						$html.='<li>';
								$html.='<ol class="field_type">';
								foreach($OptionList_obj_dragable as $single_item){
									$rand=wp_rand(1,100000000000);
									$html.='<li class="draggable"  field-type="'.$single_item.'">
										<div class="main-field-content">
											<div class="main-title">'.$single_item.'<div class="align-right"><span class="dashicons dashicons-arrow-down"></span></div></div>
											<div class="fields-layout">
												<div class="field-label"><label>Enter Lable Name</label><input type="text" name="field_label" placeholder="Field label"></div>
												<div class="field-name"><label>Enter Field Name</label><input type="text" name="field_name" placeholder="Field Name" value="name_'.$rand.'"></div>
												<div class="field-required"><input type="checkbox" name="field_required" value="1"></div>
											</div>
										</div>
									</li>';
									
								}
							$html.='</ol>';
					$html.='</li>';
				$html.='</ul>';
			$html.='</div>';
			
		$html.='</div>';
		echo $html;
	 }
	 public function test(){
		 echo "okkkkk";
	 }
}
new WCM_FormMain;


 