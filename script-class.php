<?php
class WCM_script{
	
	public function __construct(){

		add_action( 'admin_enqueue_scripts', array($this,'wpdocs_theme_name_scripts88' ));
	}
	
	/**
	 *@Proper way to enqueue scripts and styles
	 */
	public function wpdocs_theme_name_scripts88() {
		
		wp_enqueue_style('admin-css',plugins_url( 'assets/css/admin/style.css',__FILE__));
		wp_enqueue_script( 'WCP-dragable', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js', null, null, true );
		wp_enqueue_script( 'my_custom_script', plugins_url( 'assets/js/admin.js', __FILE__ ) );
	}

}
new WCM_script;


 