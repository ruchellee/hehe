<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$UniversityName = $_POST['editUniversityName'];
  $UniversityStatus = $_POST['editUniversityStatus']; 
  $UniversityId = $_POST['UniversityId'];

	$sql = "UPDATE university SET University_name = '$UniversityName', University_active = '$UniversityStatus' WHERE University_id = '$UniversityId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST