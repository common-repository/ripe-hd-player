<?php

/******************************************************************
/* Inserting (or) Updating the DB Table when edited
******************************************************************/
if($_POST['edited'] == 'true' && check_admin_referer( 'hitasoft_player-nonce')) {
	unset($_POST['group'], $_POST['edited'], $_POST['save'], $_POST['_wpnonce'], $_POST['_wp_http_referer']);
	$wpdb->insert($table_name, $_POST);
	echo '<script>window.location="?page=hitasoft_player";</script>';
}

/******************************************************************
/* Getting Input from the DB Table
******************************************************************/
$data = $wpdb->get_row("SELECT * FROM $table_name WHERE id=1");
	
?>
<div class="wrap">
  <br />
  <?php _e( "Ripe HD FLV Player is the famous flash based video player running on most popular websites. For More details visit <a href='http://www.hitasoft.com/' target='_blank'>Hitasoft Player</a>." ); ?>
  
  <br />
  <br />
  <form method="POST" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="return hitasoft_player_validate();" >
  	<?php wp_nonce_field('hitasoft_player-nonce'); ?>
    <?php  echo "<h3>" . __( 'Player Settings' ) . "</h3>"; ?>
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
        <td><?php _e("Skin Mode" ); ?></td>
        <td><select id="skinmode" name="skinmode">
            <option value="float" id="float">Float</option>
            <option value="static" id="static">Static</option>
          </select>
          <?php echo '<script>document.getElementById("'.$data->skinmode.'").selected="selected"</script>'; ?> </td>
        </td>
      </tr>
      <tr>
        <td><?php _e("Stretch Type" ); ?></td>
        <td><select id="stretchtype" name="stretchtype">
            <option value="fill" id="fill">Fill</option>
            <option value="uniform" id="uniform">Uniform</option>
            <option value="none" id="none">Original</option>
            <option value="exactfit" id="exactfit">Exact Fit</option>
          </select>
          <?php echo '<script>document.getElementById("'.$data->stretchtype.'").selected="selected"</script>'; ?> </td>
        </td>
      </tr>
      <tr>
        <td><?php _e("Buffer Time" ); ?></td>
        <td><input type="text" id="buffertime" name="buffertime" value="<?php echo $data->buffertime; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("Volume Level" ); ?></td>
        <td><input type="text" id="volumelevel" name="volumelevel" value="<?php echo $data->volumelevel; ?>" size="50"></td>
      </tr>
      <tr>
        <td><?php _e("AutoPlay" ); ?></td>
        <td><input type="checkbox" id="autoplay" name="autoplay" value="1" <?php if($data->autoplay==1){echo 'checked="checked" ';}?>></td>
      </tr>
    </table>
    <?php  echo "<h3>" . __( 'Skin Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="15">
      <tr>
        <td><input type="checkbox" id="controlbar" name="controlbar" value="1" <?php if($data->controlbar==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Control Bar" ); ?></td>
        <td><input type="checkbox" id="playpause" name="playpause" value="1" <?php if($data->playpause==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("PlayPause Dock" ); ?></td>
        <td><input type="checkbox" id="progressbar" name="progressbar" value="1" <?php if($data->progressbar==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Progress Bar" ); ?></td>
        <td><input type="checkbox" id="timer" name="timer" value="1" <?php if($data->timer==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Timer Dock" ); ?></td>
      </tr>
      <tr>
        <td><input type="checkbox" id="share" name="share" value="1" <?php if($data->share==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Share Dock" ); ?></td>
        <td><input type="checkbox" id="volume" name="volume" value="1" <?php if($data->volume==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Volume Dock" ); ?></td>
        <td><input type="checkbox" id="fullscreen" name="fullscreen" value="1" <?php if($data->fullscreen==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Fullscreen Dock" ); ?></td>
        <td><input type="checkbox" id="playdock" name="playdock" value="1" <?php if($data->playdock==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("Play Dock" ); ?></td>
      </tr>
      <tr>
        <td><input type="checkbox" id="playlist" name="playlist" value="1" <?php if($data->playlist==1){echo 'checked="checked" ';}?>></td>
        <td><?php _e("PlayList" ); ?></td>
      </tr>
    </table>
    <?php  echo "<h3>" . __( 'Video Settings' ) . "</h3>"; ?>
    <table cellpadding="0" cellspacing="15">
      <tr>      	
        <td><input type="radio" name="group" onchange="changeType('videoid');" <?php if($data->videoid){echo 'checked="checked" ';}?>>
        <label>&nbsp;&nbsp;<?php _e("Single Video" ); ?></label></td>
        <td><input type="radio" name="group" onchange="changeType('playlistid');" <?php if($data->playlistid){echo 'checked="checked" ';}?>>
        <label>&nbsp;&nbsp;<?php _e("Playlist" ); ?></label></td>
	  </tr>
      <tr id="_videoid">
      	<td><?php _e("Video ID" ); ?></td>
        <td><input type="text" id="videoid" name="videoid" value="<?php echo $data->videoid; ?>" size="50"></td>
      </tr>
      <tr id="_playlistid">
        <td class="key"><?php _e("Choose your Playlist" ); ?></td>
        <td><select id="playlistid" name="playlistid" >
            <option value="0" id="0" selected="selected" >None</option>
            <?php
            $k=count( $playlist);
            for ($i=0; $i < $k; $i++)
            {
               $row = $playlist[$i];
            ?>
            <option value="<?php echo $row->id; ?>" id="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
            <?php } ?>
          </select>
      	</td>
      </tr>
      <tr id="_playlistautoplay">
      	<td><?php _e("Playlist Autoplay" ); ?></td>
        <td><input type="checkbox" id="playlistautoplay" name="playlistautoplay" value="1" <?php if($data->playlistautoplay==1){echo 'checked="checked" ';}?>></td>
      </tr>
      <tr id="_playlistopen">
      	<td><?php _e("Playlist Open" ); ?></td>
        <td><input type="checkbox" id="playlistopen" name="playlistopen" value="1" <?php if($data->playlistopen==1){echo 'checked="checked" ';}?>></td>
      </tr>
      <tr id="_playlistrandom">
      	<td><?php _e("Playlist Random" ); ?></td>
        <td><input type="checkbox" id="playlistrandom" name="playlistrandom" value="1" <?php if($data->playlistrandom==1){echo 'checked="checked" ';}?>></td>
      </tr>
     </table> 
    <br />
    <input type="hidden" name="edited" value="true" />
    <input type="submit" class="button-primary" name="save" value="<?php _e("Save Options" ); ?>" />
    &nbsp; <a href="?page=hitasoft_player" class="button-secondary" title="cancel">
    <?php _e("Cancel" ); ?>
    </a>
  </form>
</div>
<script type="text/javascript">
changeType('videoid');

function changeType(type) {
	document.getElementById('_videoid').style.display="none";
	document.getElementById('_playlistid').style.display="none";
	document.getElementById('_playlistautoplay').style.display="none";
	document.getElementById('_playlistopen').style.display="none";
	document.getElementById('_playlistrandom').style.display="none";
	switch(type) {
		case 'playlistid':
			document.getElementById('_playlistid').style.display="";
			document.getElementById('_playlistautoplay').style.display="";
			document.getElementById('_playlistopen').style.display="";
			document.getElementById('_playlistrandom').style.display="";
			break;
		default:
			document.getElementById('_videoid').style.display="";
	}
}

function hitasoft_player_validate() {
	if(document.getElementById('_videoid').style.display == 'none') {
		document.getElementById('videoid').value = 0;
	} else {
		document.getElementById('playlistid').value = 0;
	}
	
	if(document.getElementById('width').value < 180 || document.getElementById('height').value < 180) {
		alert("Warning! The Player size should be atleast 180 * 180");
		return false;
	}
	
	if(document.getElementById('videoid').value == '' && document.getElementById('playlistid').value == '') {
		alert("Warning! You have not added any Video (or) Playlist to the Player.");
		return false;
	}
	
	return true;
}
</script>