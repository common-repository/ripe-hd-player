<?php

require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );

class hitasoft_player_Table extends WP_List_Table {

	var $table_name;
	var $wpdb;
	var $category;
    
    function __construct(){
        global $status, $page;                
        parent::__construct( array( 'singular' => 'player', 'plural' => 'players', 'ajax' => false ) );        
    }
    
    function column_default($item, $column_name){
		switch($column_name) {
			case 'actions' :
				if($item->id == 1) {
					return '<div style="margin-top:9px;"><a class="button-secondary" href="?page=hitasoft_player&opt=edit&id='.$item->id.'" title="Edit">Edit</a></div>';
				} else {
					return '<div style="margin-top:9px;"><a class="button-secondary" href="?page=hitasoft_player&opt=edit&id='.$item->id.'" title="Edit">Edit</a>&nbsp;&nbsp;&nbsp;<a class="button-secondary" href="?page=hitasoft_player&opt=delete&id='.$item->id.'" title="Delete">Delete</a></div>';
				}
				break;
			case 'shortcode' :
				return '<div style="margin-top:4px;">[hitasoft_player id='.$item->id.']</div>';
				break;
			case 'playlistid' :
				if($item->playlistid == 0) {
					return '<div style="margin-top:9px;">0</div>';
				} else {
					return '<div style="margin-top:9px;">'.$this->category[$item->playlistid].'</div>';
				}				
				break;
			default :
				return '<div style="margin-top:4px;">'.$item->$column_name.'</div>';
				break;
		}
    }

    function column_cb($item){
        return sprintf( '<input type="checkbox" name="%1$s[]" value="%2$s" />', $this->_args['singular'], $item->id );
    }
	
	function get_columns(){
        $columns = array(
            'cb'          => '<input type="checkbox" />',
            'id'          => 'Player ID',
            'videoid'     => 'Video ID',
            'playlistid'  => 'Playlist Name',
			'width'       => 'Width',
			'height'      => 'Height',
			'shortcode'   => 'Short Code',
			'actions'     => 'Actions'
        );
        return $columns;
    }

    function get_bulk_actions() {
        $actions = array( 'delete' => 'Delete' );
        return $actions;
    }

    function process_bulk_action() {
		if( 'delete'===$this->current_action() ) {			
			foreach($_GET['player'] as $player) {
				$this->wpdb->query("DELETE FROM $this->table_name WHERE id=".$player);
        	}
			echo '<script>window.location="?page=hitasoft_player";</script>';
		}
    }

    function prepare_items( $data, $table_name, $wpdb, $category ) {
		$this->table_name = $table_name;
		$this->wpdb = $wpdb;
		$this->category = $category;

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();
        $this->_column_headers = array($columns, $hidden, $sortable);
		
        $this->process_bulk_action();

 		$per_page = 5;
        $current_page = $this->get_pagenum();
        $total_items = count($data);
        $data = array_slice($data,(($current_page-1)*$per_page),$per_page);
        $this->items = $data;

        $this->set_pagination_args( array( 'total_items' => $total_items, 'per_page' => $per_page, 'total_pages' => ceil($total_items/$per_page) ) );
    }
    
}
?>
<br />
<?php
	_e( "Hitasoft is the Fastest Growing Online Video Platform for your Websites. For More visit <a href='http://www.hitasoft.com/'>Hitasoft</a>." );
	$table = new hitasoft_player_Table();
	$data  = $wpdb->get_results("SELECT id,videoid,playlistid,width,height FROM $table_name");
	$category = array();
	for ($i=0, $n=count($playlist); $i < $n; $i++) {
		$category[$playlist[$i]->id] = $playlist[$i]->name;		
	}
	$table->prepare_items( $data, $table_name, $wpdb, $category );
?>
<br />
<br />
<div><a href="?page=hitasoft_player&opt=add" class="button-primary" title="addnew"><?php _e("Add New Player" ); ?></a></div>
<br />
<form id="hitasoft_player-filter" method="get" style="width:99%;">
<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
<?php $table->display() ?>
</form>