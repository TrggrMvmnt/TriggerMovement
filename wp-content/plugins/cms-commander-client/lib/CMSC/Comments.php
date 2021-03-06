<?php
class CMSC_Comments extends CMSC_Core
{
    function __construct()
    {
        parent::__construct();
    }
	
	function bulk_action($args) {	
	
        $comments = get_comments('status=spam');
        foreach ($comments as $comment) {
			$comment_id = $comment->comment_ID;
			wp_delete_comment( $comment_id, 1 );
        }
		
        $comments = get_comments('status=trash');
        foreach ($comments as $comment) {
			$comment_id = $comment->comment_ID;
			wp_delete_comment( $comment_id, 1 );
        }
		
		return true;
	}
	
	function get($args) {

		if(!empty($args['num'])) {$num_comments = $args['num'];} else {$num_comments = 20;}
		if(!empty($args['status'])) {$status = $args['status'];} else {$status = "hold";}

        $comments = get_comments('status='.$status.'&number=' . $num_comments);
        foreach ($comments as &$comment) {
            $commented_post      = get_post($comment->comment_post_ID);
            $comment->post_title = $commented_post->post_title;
			$comment->post_link = $commented_post->guid;
			unset($comment->comment_agent);
			unset($comment->comment_author_IP);
			unset($comment->comment_type);		
			unset($comment->comment_karma);					
        }
        
        return $comments;	
	}
    
    function approve($args)
    {
		$args['status'] = "approve";
		return $this->change_status($args);
    }	
	
    function unapprove($args)
    {
		$args['status'] = "unapprove";
		return $this->change_status($args);
    }	

    function delete($args)
    {
		$args['status'] = "trash";
		return $this->change_status($args);
    }		
	
    function change_status($args)
    {

    	global $wpdb;
    	$comment_id = $args['comments'];
    	$status = $args['status']; 
    	
       	if ( 'approve' == $status )
			$status_sql = '1';
		elseif ( 'unapprove' == $status )
			$status_sql = '0';
		elseif ( 'spam' == $status )
			$status_sql =  'spam';
		elseif ( 'trash' == $status )
			$status_sql =  'trash';
		$sql = "update ".$wpdb->prefix."comments set comment_approved = '$status_sql' where comment_ID = '$comment_id'";
		$success = $wpdb->query($sql);
						
        return $success;
    }
	
    function create($args)
    {

		$comment_post_ID = $args["post_id"];

		if($args['postdate']) {
			$comment_date = $args['postdate'];	
		} else {
			$comment_date = current_time('mysql');
		}			
		
		list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = preg_split( '/([^0-9])/', $comment_date );	
		$comment_date = mktime($hour, $minute + rand(0, 59), $second + rand(0, 59), $today_month, $today_day, $today_year);
		$comment_date=date("Y-m-d H:i:s", $comment_date); 		
		$comment_date_gmt = $comment_date;					

		$rnd= rand(1,9999);
		$comment_author_email="someone$rnd@domain.com";
		$comment_author= $args["comment"]["author"];
		$comment_author_url='';  
		$comment_content="";
		$comment_content.= $args["comment"]["content"];
		$comment_type='';
		$user_ID='';
		$comment_approved = 1;
		$commentdata = compact('comment_post_ID', 'comment_date', 'comment_date_gmt', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'user_ID', 'comment_approved');
		return wp_insert_comment( $commentdata );	
    }	
  
}
?>