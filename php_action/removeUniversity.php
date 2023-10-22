<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$UniversityId = $_POST['UniversityId'];

if($UniversityId) { 

 $sql = "UPDATE university SET University_status = 2 WHERE University_id = {$UniversityId}";

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