<?php 

/**
 * Plugin Name:     WP Reservation Form
 * Plugin URI:      http://boostpress.com         
 * Description:     Using for reservation fom
 * Version:         0.1            
 * Requires at least: 6.4.1 
 * Requires PHP:    8.0 
 * Author:          Watcharamet Chitsanukup Srinethiroth  
 * Author URI:      http://select2web.com
 */

 class WP_Reservation_Form 
 {
    public function __construct()
    {
        // Rendering admin menu
        add_action ('admin_menu', array($this, 'newmenu'));

        // Append banner to content
        add_filter( 'the_content', array($this, 'change_content') );

    }


    public function newmenu() 
    {
        add_management_page('Some page title', 'My Custom Menu', 'install_plugins', 'some_unique_string', 'my_custom_page_render_function', '');
    }


    public function change_content ( $content ) 
    {
        $content .= '<h1>Banner</h1>';
        return $content;
    }


 }

 new WP_Reservation_Form();
 