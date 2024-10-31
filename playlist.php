<?php

/******************************************************************
/*Bootstrap file for getting the ABSPATH constant to wp-load.php
/*This is requried when a plugin requires access not via the admin screen.
******************************************************************/
$path  = ''; 
if ( !defined('WP_LOAD_PATH') ) {
    $classic_root = dirname(dirname(dirname(dirname(__FILE__)))) . '/' ;
    if (file_exists( $classic_root . 'wp-load.php') ) {
    	define( 'WP_LOAD_PATH', $classic_root);
	} else if (file_exists( $path . 'wp-load.php') ) {
    	define( 'WP_LOAD_PATH', $path);
	} else {
    	exit("Could not find wp-load.php");
	}
}

require_once( WP_LOAD_PATH . 'wp-load.php');
global $wpdb;	

if($_GET['videoid']) {
	$config  = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."hitasoft_player_videos WHERE id=".$_GET['videoid']);
} else {
	$config  = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."hitasoft_player_videos WHERE playlistid=".$_GET['playlistid']);
}
$count   = count($config);
$siteurl = get_option('siteurl');
$br      = "\n";	

/******************************************************************
/*Cast Numeric values as Boolean
******************************************************************/
function castAsBoolean($val){
	if($val == 1) {
		return 'true';
	} else {
		return 'false';
	}
}

/******************************************************************
/*Write Data as XML
******************************************************************/
ob_clean();
header("content-type:text/xml;charset=utf-8");
echo '<?xml version="1.0" encoding="utf-8"?>'.$br;
echo '<playlist>'.$br;

for ($i=0, $n=$count; $i < $n; $i++) {
	$item = $config[$i];
	$br;
	echo '<media>'.$br;
	echo '<id>'.$item->id.'</id>'.$br;
	echo '<type>'.$item->type.'</type>'.$br;
	echo '<video>'.$item->video.'</video>'.$br;
	if($item->hdvideo) {
		echo '<hd>'.$item->hdvideo.'</hd>'.$br;
	}
	echo '<streamer>'.$item->streamer.'</streamer>'.$br;
	if($item->dvr) {
		echo '<dvr>'.$item->dvr.'</dvr>'.$br;
	}
	echo '<thumb>'.$item->thumb.'</thumb>'.$br;
	if($item->token) {
		echo '<token>'.$item->token.'</token>'.$br;
	}
	echo '<preview>'.$item->preview.'</preview>'.$br;
	echo '<title>'.$item->title.'</title>'.$br;
	echo '</media>'.$br.$br;
}

echo '</playlist>'.$br;
exit();

?>