<?php
class WCM_FormMainAjax{
    public function __construct(){
       add_action( 'wp_ajax_wcm_create_form', array($this,'WCM_create_form_handler_callback' ));
    }


    /*
    * @Display main menu html forms.
    */
     public function WCM_create_form_handler_callback() {
         print_r($_POST);
         die;
     }
	
}
new WCM_FormMainAjax;


 