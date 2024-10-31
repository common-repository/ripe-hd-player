<?php

/******************************************************************
/* Created Tabular Menus
******************************************************************/
function hitasoft_player_admin_tabs($current = 'hitasoft_player') {
	//$tabs  = array('hitasoft_player' => 'HD hitasoft_player', 'videos' => 'Videos', 'playlist' => 'Playlist', 'license' => 'License', 'documentation' => 'Documentation');
	$tabs  = array('videos' => 'Videos', 'documentation' => 'Documentation');
	$links = array();
	
	foreach( $tabs as $tab => $name ) {
		if( $tab == $current) {
			$links[] = "<a class='nav-tab nav-tab-active' href='?page=$tab'>$name</a>";
		} else {
			$links[] = "<a class='nav-tab' href='?page=$tab'>$name</a>";
		}
	}
	
	echo '<div id="icon-upload" class="icon32"></div>';
	echo "<h2 class='nav-tab-wrapper'>";
	foreach( $links as $link ) {
		echo $link;
	}
	echo "</h2>";
	
}

?>