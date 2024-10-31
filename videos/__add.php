<?php
	
/******************************************************************
/* Inserting (or) Updating the DB Table when edited
******************************************************************/
if($_POST['edited'] == 'true' && check_admin_referer( 'hitasoft_player-nonce')) {
	unset($_POST['edited'], $_POST['save'], $_POST['_wpnonce'], $_POST['_wp_http_referer']);
	$wpdb->insert($table_name, $_POST);
	echo '<script>window.location="?page=videos";</script>';
}
	
?>
<div class="wrap">
  <br />
<?php _e( "Ripe HD FLV Player is the famous flash based video player running on most popular websites. For More details visit <a href='http://www.hitasoft.com/' target='_blank'>Hitasoft Player</a>." ); ?>
    <br />
  <br />
  <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="return hitasoft_player_validate();">
  	<?php wp_nonce_field('hitasoft_player-nonce'); ?>
    <?php  echo "<h3>" . __( 'Skin Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="15">
      <tr>
        <td><input type="checkbox" id="playerControls" name="playerControls" value="<?php if($data->playerControls > 0){echo 0; } else { echo 1; }?>" <?php if($data->playerControls==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Player Control" ); ?></td>
        <td><input type="checkbox" id="sidebarControls" name="sidebarControls" value="<?php if($data->sidebarControls > 0){echo 0; } else { echo 1; }?>" <?php if($data->sidebarControls==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Sidebar Controls" ); ?></td>
        <td><input type="checkbox" id="emailFriend" name="emailFriend" value="<?php if($data->emailFriend > 0){echo 0; } else { echo 1; }?>" <?php if($data->emailFriend==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Email Friend" ); ?></td>
        <td><input type="checkbox" id="videoSize" name="videoSize" value="<?php if($data->videoSize > 0){echo 0; } else { echo 1; }?>" <?php if($data->videoSize==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Video Size" ); ?></td>
      </tr>
      <tr>
        <td><input type="checkbox" id="embedVideo" name="embedVideo" value="<?php if($data->embedVideo > 0){echo 0; } else { echo 1; }?>" <?php if($data->embedVideo==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Embed Video" ); ?></td>
        <td><input type="checkbox" id="videoTitle" name="videoTitle" value="<?php if($data->videoTitle > 0){echo 0; } else { echo 1; }?>" <?php if($data->videoTitle==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Video Title" ); ?></td>
        <td><input type="checkbox" id="hdOnOff" name="hdOnOff" value="<?php if($data->hdOnOff > 0){echo 0; } else { echo 1; }?>" <?php if($data->hdOnOff==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("HD On Off" ); ?></td>
        <td><input type="checkbox" id="ToolTip" name="ToolTip" value="<?php if($data->ToolTip > 0){echo 0; } else { echo 1; }?>" <?php if($data->ToolTip==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Tool Tip" ); ?></td>
      </tr>
    </table>
    <?php  echo "<h3>" . __( 'Video Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="10">
      <tr>
        <td width="30%"><?php _e("Player Size" ); ?></td>
        <td><?php _e("Width" ); ?>
          &nbsp;&nbsp;
          <input type="text" id="width" name="width" value="<?php echo $data->width; ?>" size="5" />
          &nbsp;&nbsp;
          <?php _e("Height" ); ?>
          &nbsp;&nbsp;
          <input type="text" id="height" name="height" value="<?php echo $data->height; ?>" size="5"/></td>
      </tr>
      <tr>
        <td width="30%"><?php _e("Video Title " ); ?></td>
        <td><input type="text" id="title" name="title" value="<?php echo $data->title; ?>" size="50"></td>
      </tr>
      <tr>
        <td class="key">Video type</td>
        <td>
        	<select id="type" name="type" onchange="javascript:changeType(this.options[this.selectedIndex].id);">
            <option value="video" id="video" >Direct URL</option>
            </select>
        </td>
      </tr>
      <tr>
        <td width="30%"><?php _e("Video URL " ); ?></td>
        <td><input type="text" id="_video" name="video" size="50"></td>
      </tr>
      <tr>
        <td width="30%"><?php _e("Video Description " ); ?></td>
        <td><textarea id="description" name="description" cols="50" rows="10"></textarea></td>
      </tr>
      
    </table>
    <br />
    <input type="hidden" name="edited" value="true" />
    <input type="submit" class="button-primary" name="save" value="<?php _e("Save Options" ); ?>" />
    &nbsp; <a href="?page=videos" class="button-secondary" title="cancel">
    <?php _e("Cancel" ); ?>
    </a>
  </form>
</div>
<script type="text/javascript">

changeType("video");

function changeType(typ) {

	document.getElementById('_hdvideo').style.display="none";
	/*document.getElementById('_streamer').style.display="none";
	document.getElementById('_dvr').style.display="none";
	document.getElementById('_token').style.display="none";*/

	switch(typ) {
		case 'video' :
			document.getElementById('_hdvideo').style.display="";
			break;
		}
}

function hitasoft_player_validate() {
	var type            = document.getElementById("type");
    var method          = type.options[type.selectedIndex].value;
	var videoExtensions = ['flv', 'mp4' , '3g2', '3gp', 'aac', 'f4b', 'f4p', 'f4v', 'm4a', 'm4v', 'mov', 'sdp', 'vp6', 'smil'];
	var imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
	var isAllowed       = true;
	
	if(document.getElementById('title').value == '') {
		alert("Warning! You must Provide a Title for the Video.");
		return false;
	}
	
	if(document.getElementById('video').value == '') {
		alert("Warning! You have not added any Video to the Player.");
		return false;
	}
	
	if(method == 'video') {
		isAllowed = checkExtension('VIDEO', document.getElementById('_video').value, videoExtensions);
		if(isAllowed == false) 	return false;
		
		if(document.getElementById('hdvideo').value) {
			isAllowed = checkExtension('VIDEO', document.getElementById('hdvideo').value, videoExtensions);
			if(isAllowed == false) 	return false;
		}
	}
	
	return true;
	
}

function checkExtension(type, filePath, validExtensions) {
    var ext = filePath.substring(filePath.lastIndexOf('.') + 1).toLowerCase();

    for(var i = 0; i < validExtensions.length; i++) {
        if(ext == validExtensions[i]) return true;
    }

    alert(type + ' :   The file extension ' + ext.toUpperCase() + ' is not allowed!');
    return false;	
 }
</script>