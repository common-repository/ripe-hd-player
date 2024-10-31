<?php

global $wpdb;
$table_name = $wpdb->prefix . "hitasoft_player_videos";
$data       = array();

$playlist   = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."hitasoft_player_playlist");

/******************************************************************
/* Execute Actions
******************************************************************/
switch($_GET['opt']) {
	case 'add'   :
		require_once('__add.php');
		break;
	case 'edit'  :
		require_once('__edit.php');
		break;
	case 'delete':
		require_once('__delete.php');
		break;
	default:
		require_once('__grid.php');		
}

?>