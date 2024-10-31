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

$results = $wpdb->get_row("SELECT * FROM ".$wpdb->prefix."hitasoft_player_videos WHERE id=".$_GET['id']);
$siteurl = get_option('siteurl');
$br      = "\n";	

$configUrl     = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__));

$configFile     = "config=".$siteurl . "/wp-content/plugins/" . basename(dirname(__FILE__)) . "/config.php";

$embedcode = '<embed src="'.$configUrl .'/HDPlayer.swf" quality="high" bgcolor="#000000" width="'.$results->width.'" height="'.$results->height.'" name="HDPlayer" align="middle" allowScriptAccess="sameDomain" wmode="window" allowFullScreen="true" type="application/x-shockwave-flash" flashvars="'.$configFile.'" pluginspage="http://www.adobe.com/go/getflashplayer" />';

$varPlayerControl = ($results->playerControls > 0)?'true':'false';
$varSidebarControl = ($results->sidebarControls > 0)?'true':'false';
$varEmailFriend = ($results->emailFriend > 0)?'true':'false';
$varVideoSize = ($results->videoSize > 0)?'true':'false';
$varEmbedVideo = ($results->embedVideo > 0)?'true':'false';
$varVideoTitle = ($results->videoTitle > 0)?'true':'false';
$varHDonoff = ($results->hdOnOff > 0)?'true':'false';
$varToolTip = ($results->ToolTip > 0)?'true':'false';

/******************************************************************
/*Write Data as XML
******************************************************************/
ob_clean();
header("content-type:text/xml;charset=utf-8");
$html  = '<?xml version="1.0" encoding="utf-8"?>'.$br;
$html .= '<HDPlayer>'.$br;
$html .= '<Skins>'.$br;
$html .= '<Skin  Name="SkinFile" Path="'.$configUrl.'/skin/hdskin.swf"/>'.$br;
$html .= '</Skins>'.$br;
$html .= '<DisplaySettings>'.$br;
$html .= '<Controls>'.$br;
$html .= '<Control Name="playerControls" Visible="'.$varPlayerControl.'" AutoHide="true" JSApiEnabled="true"/>'.$br;
$html .= '<Control Name="sidebarControls" Visible="'.$varSidebarControl.'" AutoHide="true">'.$br;
$html .= '<ControlItem Name="emailFriend" Enabled="'.$varEmailFriend.'" />'.$br;
$html .= '<ControlItem Name="videoSize" Enabled="'.$varVideoSize.'" />'.$br;
$html .= '<ControlItem Name="embedVideo" Enabled="'.$varEmbedVideo.'" />'.$br;
$html .= '<ControlItem Name="videoTitle" Enabled="'.$varVideoTitle.'"/>'.$br;
$html .= '<ControlItem Name="hdOnOff" Enabled="'.$varHDonoff.'" />'.$br;
$html .= '<ControlItem Name="ToolTip" Enabled="'.$varToolTip.'" />'.$br;
$html .= '</Control>'.$br;	
$html .= '</Controls>'.$br;
$html .= '<Logo FilePath="logo.swf" URL="http://www.hitasoft.com"  Target="_blank" Opacity="50"/>'.$br;
$html .= '<Language XmlPath="'.$configUrl.'/xml/lang/en-EN.xml" default=""/>'.$br;
$html .= '</DisplaySettings>'.$br;
$html .= '<AdvertiseMents>'.$br;
$html .= '<PreRoll Type="image" DurationInSeconds="5" Enabled="true">'.$br;	
$html .= '</PreRoll>'.$br;
$html .= '<MidRoll  Enabled="true" Duration="5">'.$br;
$html .= '</MidRoll>'.$br;
$html .= '<PostRoll Type="image" DurationInSeconds="5" Enabled="true">'.$br;	
$html .= '</PostRoll>'.$br;
$html .= '</AdvertiseMents>'.$br;
$html .= '<ButtonControls>'.$br;
$html .= '<EmbedCode><![CDATA[<embed src="HDPlayer.swf" quality="high" bgcolor="#000000" width="560" height="310" name="HDPlayer" align="middle" allowScriptAccess="sameDomain" allowFullScreen="true" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer" />]]></EmbedCode>'.$br;
$html .= '<LinkCode><![CDATA['.$siteurl.']]></LinkCode>'.$br;
$html .= '<Share EmailPHPPath="email.php"/>'.$br;
$html .= '</ButtonControls>'.$br;
$html .= '<VideoPlayBack DefaultVolume="10" HardwareFullScreenScaling="false"  StreamingType="http" RtmpServer="">'.$br;
$html .= '<Video>'.$br;
$html .= '<File HDVideoPath="'.$results->video.'" AutoPlay="false" VideoTitle="'.$results->title.'" VideoDescription="'.$results->description.'" TitleClickUrl="http://www.hitasoft.com/newhome/" VideoSource="" VideoQuality=""/>'.$br;

$html .= '</Video>'.$br;
$html .= '</VideoPlayBack>'.$br;
$html .= '<RelatedVideoList XmlPath="http://www.hd-player.net/files/hdplayer/xml/videolist.xml" Enabled="true"/>'.$br;
$html .= '<SocialNetworkShare>'.$br;
$html .= '<FaceBook APIUrl="http://www.facebook.com/sharer.php?" ShareContent=""/>'.$br;
$html .= '<Twitter APIUrl="http://twitter.com/share?url=" ShareContent=""/>'.$br;
$html .= '<Delicious APIUrl="http://delicious.com/post?url=" ShareContent="www.hitasoft.com/newhome"/>'.$br;
$html .= '</SocialNetworkShare>'.$br;
$html .= '</HDPlayer>'.$br;
echo $html;
exit();
/*$varFolderPath = "xml/".$results->id;
if(is_dir($varFolderPath)==false){
	mkdir($varFolderPath, 0777);
}
$myFile = $varFolderPath."/config.xml";
$fh = fopen($myFile, 'w') or die("can't open file");
fwrite($fh, $html);
fclose($fh);*/
?>