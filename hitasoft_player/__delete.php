<?php

/******************************************************************
/* Deleting the Table Row
******************************************************************/
if($_GET['page'] == 'hitasoft_player' && $_GET['opt'] == 'delete') {
	$wpdb->query("DELETE FROM $table_name WHERE id=".$_GET['id']);
	echo '<script>window.location="?page=hitasoft_player";</script>';
}

?>