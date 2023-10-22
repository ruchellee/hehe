<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$CourseId = $_POST['CourseId'];

if($CourseId) { 

 $sql = "UPDATE Course SET active = 2, status = 2 WHERE Course_id = {$CourseId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the University";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST