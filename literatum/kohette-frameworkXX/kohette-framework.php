<?php
/*
Plugin Name: Kohette Framework
Plugin URI: 
Description: Load the theme configuration and custom functions & features.
Author: Rafael Martín
Author URI: http://kohette.com/
Version: 1.0.0
License: GNU General Public License v3.0
License URI: http://www.opensource.org/licenses/gpl-license.php
*/




class kohette_framework {

    private $theme_config;
    public $prefix;
    public $textdomain;

    function kohette_framework($theme_config) {

    		$this->set_theme_config($theme_config);
          	$this->load_framework_functions(); // load custom functions
          	$this->load_framework_modules(); // load framework handy classes
            $this->create_theme_options_page();
            

    }



    /**
    * set the basic configuration of the theme
    */
    private function set_theme_config($theme_config) {
		
        $this->theme_config = $theme_config;
    	if (isset($theme_config['prefix'])) $this->prefix = $theme_config['prefix'];
    	if (isset($theme_config['textdomain'])) $this->textdomain = $theme_config['textdomain'];

        // declare some basic constants to use around the theme
        define("THEME_TEXTDOMAIN", $this->textdomain);
        define("THEME_PREFIX", $this->prefix);

    }


    /**
    * load framework custom functions
    */
    private function load_framework_functions() {
		include('functions/basic-functions.php');
    }



    /**
    * load framework handy classes
    */
    private function load_framework_modules() {

    	foreach (glob(dirname(__FILE__). "/modules/*", GLOB_ONLYDIR) as $filename) {
        	include('modules/' . basename($filename) . '/' . basename($filename) . '.php') ;
		};

    }


    /**
    * create the theme options admin page/menu
    */
    private function create_theme_options_page() {

        $args = array();
        $args['id']             = 'theme-options';
        $args['page_title']     = 'Theme Options';
        $args['menu_title']     = 'Theme options';
        $args['page']           = ''; //array( &$this, 'default_theme_options_page');

        $new_admin_page = new KTT_admin_menu($args);

        

    }

    function default_theme_options_page() {
        global $submenu;

    }



    /**
    * theme activation hook
    */
    function theme_activation_hook() {

        global $pagenow;
        if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {

            set_default_options();

        }
    }



    /**
    * include the plugin file in the theme
    */
    private function run_activate_plugin( $plugin_source ) {
	    include($plugin_source);
	}



	/**
    * load the list of plugins
    */
    function load_plugins($plugins) {

    	require_once(ABSPATH . 'wp-admin/includes/plugin.php');

    	foreach ($plugins as $plugin => $plugin_config) {

    		$plugin_data = get_plugin_data($plugin_config['source']);

    		$this->run_activate_plugin($plugin_config['source']);

    	}

    }




}



    
