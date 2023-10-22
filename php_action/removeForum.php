<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$forumId = $_POST['forumId'];

if($forumId) { 

 $sql = "UPDATE forum SET forum_status = 2 WHERE forum_id = {$forumId}";

 $forumItem = "UPDATE forum_item SET forum_item_status = 2 WHERE  forum_id = {$forumId}";

 if($connect->query($sql) === TRUE && $connect->query($forumItem) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the University";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST