<?php

/******************************************************************
/* UnInstall the hitasoft_player Tables
******************************************************************/
function hitasoft_player_db_uninstall() {
	global $wpdb;
	global $hitasoft_player_version;

	$table_name = $wpdb->prefix . "hitasoft_player_videos";
	$wpdb->query("DROP TABLE IF EXISTS $table_name");
	
	delete_option( "hitasoft_player_version", $hitasoft_player_version );
}
    
?>