<?php
/******************************************************************
Plugin Name:Hitasoft FLV Player
Plugin URI:http://www.hitasoft.com/
Description:Video Player extension for your Wordpress websites.
Version:1.1
Author:Hitasoft
Author URI:http://www.hitasoft.com
******************************************************************/

require_once('installer.php');
require_once('uninstaller.php');
require_once('shortcode.php');
require_once('tabs.php');

global $hitasoft_player_version;
global $installed_hitasoft_player_version;

$hitasoft_player_version = "1.1";
$installed_hitasoft_player_version = get_site_option('hitasoft_player_version');

/******************************************************************
/* Add Custom CSS file
******************************************************************/
function hitasoft_player_plugin_css() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/hitasoft_player.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

/******************************************************************
/* Creating Menus
******************************************************************/
function hitasoft_player_plugin_menu() {
	add_menu_page("Ripe HD Player", "Ripe HD Player", "administrator", "videos", "hitasoft_player_plugin_pages");
	//add_submenu_page("hitasoft_player", "Hitasot Player Videos", "Videos", "administrator", "videos", "hitasoft_player_plugin_pages");
	add_submenu_page("hitasoft_player", "Hitasot Player Documentation", "Documentation", "administrator", "documentation", "hitasoft_player_plugin_pages");
}

/******************************************************************
/* Assigning Menu Pages
******************************************************************/
function hitasoft_player_plugin_pages() {
	hitasoft_player_admin_tabs($_GET["page"]);
	require_once (dirname(__FILE__) . "/" . $_GET["page"] . "/__default.php");
}

/******************************************************************
/* Implementing Hooks
******************************************************************/
if (is_admin()) {
	add_action('admin_head', 'hitasoft_player_plugin_css');
  	add_action("admin_menu", "hitasoft_player_plugin_menu");
	register_activation_hook(__FILE__,'hitasoft_player_db_install');
	register_activation_hook(__FILE__,'hitasoft_player_db_install_data');
	add_action('plugins_loaded', 'hitasoft_player_update_db_check');
	register_uninstall_hook(__FILE__, 'hitasoft_player_db_uninstall');
}

?>