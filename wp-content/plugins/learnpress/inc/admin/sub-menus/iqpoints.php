<?php
/**
 * @file
 */
session_start();

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

if(isset($_POST['submitMaxPoints'])){
	submitMaxPoints();
}else if(isset($_POST['resetPoints'])){
	resetPoints();
}


echo "<script type='text/javascript'>
	function double_confirm() {
	    var confirm1 = confirm('Are you sure?');
	    if (confirm1 == true) {
	        return confirm('Are you really sure?');
	    }
	    return false;
	}
</script>";


function learn_press_iqpoints_page() {
	
	if($_SESSION['iqMaximum']==true){
		echo '<h1 style="color:white;background-color:green;width:100%;height:50px;margin:auto;text-align:center;padding-top: 20px;">Maximum IQ Points have been saved!</h1>';
		$_SESSION['iqMaximum'] = false;
	}else if($_SESSION['resetPoints']==true){
		echo '<h1 style="color:white;background-color:green;width:100%;height:50px;margin:auto;text-align:center;padding-top: 20px;">IQ Points have been reset!</h1>';
		$_SESSION['resetPoints'] = false;
	}

	echo '<h2>IQ Points Page</h2>';
	echo '<form method="post">';
	echo '<input type="hidden" name="maxPoints" value="learn_press_iqpoints">';
	echo '<label>Enter Maximum Points:</label><input type="text" name="iqMaximum" min="0" value="'.get_option('lpr_max_points').'">';
	echo '<input type="submit" id="maxpoints-submit" class="button" value="save" name="submitMaxPoints">';
	echo '</form>';

	echo '<form method="post">';
	echo '<input type="hidden" name="resetPoints" value="learn_press_iqpoints">';
	echo '<input style="background-color:red;color:white" onclick="return double_confirm()" type="submit" id="maxpoints-submit" class="button" value="Reset IQ Points?" name="resetPoints">';
	echo '</form>';
	echo '<hr>';



	$myListTable = new Iqpoints_List_Table();
	$myListTable->prepare_items(); 

	
	echo '<form method="post">';
	    echo '<input type="hidden" name="page" value="learn_press_iqpoints">';
	    $myListTable->search_box( 'search', 'search_id' );
		$myListTable->display(); 
	echo '</form></div>'; 
}

function my_add_menu_items(){
	$hook = add_menu_page( 'My Plugin List Table', 'My List Table Example', 'activate_plugins', 'my_list_test', 'my_render_list_page' );
	add_action( "load-$hook", 'add_options' );
}

function add_options() {
  	global $myListTable;
  	$option = 'per_page';
  	$args = array(
        'label' => 'Books',
        'default' => 10,
        'option' => 'books_per_page'
        );
  	add_screen_option( $option, $args );
  	$myListTable = new My_Example_List_Table();
}
add_action( 'admin_menu', 'my_add_menu_items' );

function getUserCompleted(){
	global $wpdb;
	$wpdb->show_errors();	
	$search = $_POST['s'];

	if(isset($_POST['s'])){
		$results = $wpdb->get_results( "SELECT  um.user_id,u.user_nicename,um2.meta_value
									FROM ".$wpdb->prefix."usermeta  as um
									LEFT JOIN ".$wpdb->prefix."users as u
									ON um.user_id=u.ID 
									LEFT JOIN ".$wpdb->prefix."usermeta  as um2
									ON um2.user_id=u.ID AND um2.meta_key = '_lpr_iq_points'
									WHERE um.meta_key ='_lpr_quiz_completed' AND u.user_nicename LIKE  '%".$search."%' AND  um.meta_key IS NOT NULL", ARRAY_A);
	}else{
		$results = $wpdb->get_results( "SELECT  um.user_id,u.user_nicename,um2.meta_value
									FROM ".$wpdb->prefix."usermeta  as um
									LEFT JOIN ".$wpdb->prefix."users as u
									ON um.user_id=u.ID
									LEFT JOIN ".$wpdb->prefix."usermeta  as um2
									ON um2.user_id=u.ID AND um2.meta_key = '_lpr_iq_points'
									WHERE um.meta_key ='_lpr_quiz_completed' AND  um.meta_key IS NOT NULL", ARRAY_A);

	}

	return $results;
}

function submitMaxPoints(){
	update_option('lpr_max_points', $_POST['iqMaximum'] );
	$_SESSION['iqMaximum'] = true;
}

function resetPoints(){
	global $wpdb;
	$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."usermeta
								SET meta_value=%d 
								WHERE meta_key=%s",0,'_lpr_iq_points'));
	$wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."usermeta
								SET meta_value='' 
								WHERE meta_key=%s",'_lpr_quiz_completed'));
	$_SESSION['resetPoints'] = true;
}

class Iqpoints_List_Table extends WP_List_Table{
/**
 * IQ Points page
 */
	function __construct(){	
	    global $status, $page;
	        parent::__construct( array(
	            'singular'  => __( 'iq point', 'iqpoints' ),     
	            'plural'    => __( 'iq points', 'iqpoints' ),   
	            'ajax'      => false        
	    ) );
	    add_action( 'admin_head', array( &$this, 'admin_header' ) );            
    }

    function get_columns(){
        $columns = array(
            /*'cb'        => '<input type="checkbox" />',*/
            'user_id' => __( 'ID', 'mylisttable' ),
            'user_nicename'    => __( 'Name', 'mylisttable' ),
            'meta_value'      => __( 'IQ Points', 'mylisttable' )
        );
        return $columns;
    }

    function prepare_items() {
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );

		$tableData = array();
		$tableData = getUserCompleted();

		for($i=0;$i<count($tableData);$i++){
			if($tableData[$i]['meta_value']==NULL){
				$tableData[$i]['meta_value'] = 0;
			}
		}
		
		usort( $tableData, array( &$this, 'usort_reorder' ) );

		$per_page = 20;
		$current_page = $this->get_pagenum();
		$total_items = count( $tableData );

		$data = array_slice( $tableData,( ( $current_page-1 )* $per_page ), $per_page );
	
		$this->set_pagination_args( array(
		    'total_items' => $total_items,                  
		    'per_page'    => $per_page                     
		) );
		
		$this->items = $data;

	}

	 function column_default( $item, $column_name ) {
	    switch( $column_name ) { 
	        case 'user_id':
	        case 'user_nicename':
	        case 'meta_value':
	            return $item[ $column_name ];
	        default:
	            return print_r( $item, true ) ; 
	    }
	}

	function usort_reorder( $a, $b ) {
	  	
	 	 $orderby = ( ! empty( $_GET['orderby'] ) ) ? $_GET['orderby'] : 'user_id';
	  	
	 	 $order = ( ! empty($_GET['order'] ) ) ? $_GET['order'] : 'asc';
	 	 
	 	 $result = strcmp( $a[$orderby], $b[$orderby] );
	 	
	return ( $order === 'asc' ) ? $result : -$result;
	}

	function get_sortable_columns() {
	    $sortable_columns = array(
	    	'user_id'  => array('user_id',false),
	    	'user_nicename' => array('user_nicename',false),
	    	'meta_value'   => array('meta_value',false)
	  	);
	  	return $sortable_columns;
	}

}
