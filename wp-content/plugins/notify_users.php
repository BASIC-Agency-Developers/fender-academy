<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/fender/wp-load.php' );
strip_tags($_GET['check']) == 'cuandoseymariadoloresx48!' or die( 'No script kiddies please!' );

global $wpdb;
$query = $wpdb->prepare( "
    SELECT user_id, meta_value 
    FROM {$wpdb->usermeta}
    WHERE  meta_key = %s
", '_lpr_quiz_completed');
$entries = $wpdb->get_results( $query );

foreach ($entries as $entry){
	$taken_quizes = unserialize($entry->meta_value);

	if (!user_id_exists($entry->user_id)){
		continue;
	}
	$check = 0;
	$info = '';

	foreach($taken_quizes as $quiz => $date){
		$last_taken = $taken_quizes[$quiz];
		$now = time();
		$time_diff = $now - $last_taken < 30*24*60*60;

		if (!$time_diff){
		//if ($time_diff){ //dev test
			//we can send email
			$check++;
			if ( get_permalink($quiz) !== false )
				$info .= '&raquo; <a href="'.get_permalink($quiz).'">'. get_the_title($quiz) .'</a><br><br>';
		}

	}	

	$user_info = get_userdata($entry->user_id);
	//creating the email
	$to = $user_info->user_email;

	$subject = 'You can retake quizes';

	$headers = "From: admin@fender.com \r\n";
	$headers .= "Reply-To: admin@fender.com \r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$message = '<html><body>';
	$message .= '<h2>You are eligible to retake the following quizes:</h2>';
	$message .= $info;
	$message .= '</body></html>';

	mail($to, $subject, $message, $headers);
}


function user_id_exists($user){
    global $wpdb;
    $count = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->users WHERE ID = %d", $user));
    if($count == 1){ 
    	return true; 
    } else { 
    	return false; 
    }
}