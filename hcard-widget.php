<?php
/**
 * Plugin Name: hCard Widget
 * Plugin URI: http://lautman.ca
 * Description: Creates widget that outputs contact information in Schema.org compliant format.
 * Version: 2.1.1
 * Author: michaellautman
 * Author URI: http://lautman.ca
 * Plugin Type: Piklist
 *

 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume 
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *

 * @license http://www.gnu.org/licenses/old-licenses/gpl-3.0.html
 */

/* Launch the plugin. */

/***DO NOT DELETE OR EDIT*/

/*Include the Piklist Checker*/
add_action('init', 'hcard_piklist_checker');
function hcard_piklist_checker()
{
  if(is_admin())
  {
   include_once('class-piklist-checker.php');
 
   if (!piklist_checker::check(__FILE__))
   {
     return;
   }
  }
}

/***START BUILDING YOUR PLUGIN*/

/**Register The Admin Page**/

add_filter('piklist_admin_pages','hcard_admin_pages');
function hcard_admin_pages($pages) 
  {
    $pages[] = array(
      'page_title' => __('hCard Widget', 'piklist')
      ,'menu_title' => 'hCard Widget'
      ,'capability' => defined('PIKLIST_SETTINGS_CAP') ? PIKLIST_SETTINGS_CAP : 'manage_options'
	
      ,'menu_slug' => 'hcard-admin'
      ,'single_line' => false
      //,'menu_icon' => piklist_admin::responsive_admin() == true ? plugins_url('piklist/parts/img/piklist-menu-icon.svg') : plugins_url('piklist/parts/img/piklist-icon.png')
      ,'page_icon' => plugins_url('piklist/parts/img/piklist-page-icon-32.png')
    );
	
	$pages[] = array(
      'page_title' => __('hCard Widget Settings')
      ,'menu_title' => __('hCard Settings', 'piklist')
      ,'sub_menu' => 'hcard-admin' 
      ,'capability' => 'manage_options'
      ,'menu_slug' => 'hcard-settings'
      ,'setting' => 'hcard_widget_settings'
      ,'menu_icon' => plugins_url('piklist/parts/img/piklist-icon.png')
      ,'page_icon' => plugins_url('piklist/parts/img/piklist-page-icon-32.png')
      ,'single_line' => true
      ,'default_tab' => 'Basic'
      ,'save_text' => 'Save Settings'
    );
	return $pages;
}

