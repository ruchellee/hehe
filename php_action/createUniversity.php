<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$UniversityName = $_POST['UniversityName'];
  $UniversityStatus = $_POST['UniversityStatus']; 

	$sql = "INSERT INTO university (University_name, University_active, University_status) VALUES ('$UniversityName', '$UniversityStatus', 1)";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	 

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST