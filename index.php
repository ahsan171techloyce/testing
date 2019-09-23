<?php
/*
Plugin Name: WP Custom Manger
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: WP Custom Manger deals with all types of Custom Option, Create Slider, Contact form.This plugin also provide facility to interact with third party.
Version:     1.2
Author:      Ahsan Ali
Author URI:  https://developer.wordpress.org/
Text Domain: wporg
Domain Path: /languages
License:     GPL2
*/
define( 'PLUGIN_ROOT_DIR', plugin_dir_path( __FILE__ ) );
class WCM_Main{

  // Constructor
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'WCM_add_main_menu' ));
        register_activation_hook( __FILE__, array( $this, 'WCM_install' ) );
        register_deactivation_hook( __FILE__, array( $this, 'WCM_uninstall' ) );
    }

    /*
      * Actions perform at loading of admin menu
      */
    function WCM_add_main_menu() {
		add_menu_page( 'WCM', 'WCM', 'manage_options', 'WCM-dashbord',  array($this,'WCM_description_callback_func'));
    

    }

    /*
     * Actions perform on loading of menu pages
     */
    function WCM_description_callback_func() {



    }

    /*
     * Actions perform on activation of plugin
     */
    function WCM_install() {



    }

    /*
     * Actions perform on de-activation of plugin
     */
    function WCM_uninstall() {



    }

}
new WCM_Main;
require_once(dirname( __FILE__ ) . '/script-class.php' );
require_once(dirname( __FILE__ ) . '/admin/FormClass/WCM_FormMain.php' );