<?php

/******************************************************************
/* User Function
******************************************************************/
function hitasoft_player_plugin_shortcode( $atts ) { 
	global $wpdb;
	if(!$atts['id']) $atts['id'] = 1;;
	
 	$siteurl = get_option('siteurl');
	$src     = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/HDPlayer.swf';
	
	$configFile     = "config=".$siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/config.php?id='.$atts['id'];
	
	$results = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."hitasoft_player_videos WHERE id=".$atts['id']);
	
	
	$embed .= '<embed src="'.$src .'" quality="high" bgcolor="#000000" width="'.$results->width.'" height="'.$results->height.'" name="HDPlayer" align="middle" allowScriptAccess="sameDomain" wmode="window" allowFullScreen="true" type="application/x-shockwave-flash" flashvars="'.$configFile.'" pluginspage="http://www.adobe.com/go/getflashplayer" />';

	return $embed;
}

add_shortcode('hitasoft_player', 'hitasoft_player_plugin_shortcode');

?>