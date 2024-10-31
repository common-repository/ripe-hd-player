<?php

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

/******************************************************************
/* Install the DB Table
******************************************************************/
function hitasoft_player_db_install() {
	global $wpdb;
	global $installed_hitasoft_player_version;
	global $hitasoft_player_version;	

	if ($installed_hitasoft_player_version != $hitasoft_player_version) {
    	$table_name = $wpdb->prefix . "hitasoft_player_videos";
		$sql = "CREATE TABLE " . $table_name . " (
  		`id` int(5) NOT NULL AUTO_INCREMENT,
	  `playlistid` int(5) NOT NULL,
	  `title` varchar(255) NOT NULL,
	  `type` varchar(20) NOT NULL,
	  `video` varchar(255) NOT NULL,
	  `description` text NOT NULL,
	  `width` int(11) NOT NULL,
	  `height` int(11) NOT NULL,
	  `playerControls` tinyint(4) NOT NULL,
	  `sidebarControls` tinyint(4) NOT NULL,
	  `emailFriend` tinyint(4) NOT NULL,
	  `videoSize` tinyint(4) NOT NULL,
	  `embedVideo` tinyint(4) NOT NULL,
	  `videoTitle` tinyint(4) NOT NULL,
	  `hdOnOff` tinyint(4) NOT NULL,
	  `ToolTip` tinyint(4) NOT NULL,
	  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  UNIQUE KEY `id` (`id`)
	);";
   		dbDelta($sql);
		
		add_option( "hitasoft_player_version", $hitasoft_player_version );
	}
}

/******************************************************************
/* Add data to the installed DB Table
******************************************************************/
function hitasoft_player_db_install_data() {
	global $wpdb;
	global $installed_hitasoft_player_version;
	global $hitasoft_player_version;

	if ($installed_hitasoft_player_version != $hitasoft_player_version) {
		$table_name = $wpdb->prefix . "hitasoft_player_videos";	
		$wpdb->insert( $table_name, array( 
		'id'               => 1,
		'title'            => 'Sample Video',
		'type'             => 'video',
		'video'            => 'http://www.hitasoft.com/files/avengersthe_trlr_01_480p_dl.mov',
		'description'      => 'This is Hitasoft Player Video',
		'width'		       => 600,
		'height'           => 300,
		'playerControls'   => 1,
		'sidebarControls'  => 1,
		'emailFriend'   => 1,
		'videoSize'  => 1,
		'embedVideo'   => 1,
		'videoTitle'  => 1,
		'hdOnOff'   => 1,
		'ToolTip'  => 1,
		));
	}
}

/******************************************************************
/* Check for Update
******************************************************************/
function hitasoft_player_update_db_check() {
	 global $hitasoft_player_version;
     if (get_site_option('hitasoft_player_version') != $hitasoft_player_version) {
        update_option( "hitasoft_player_version", $hitasoft_player_version );
     }
}
    
?>