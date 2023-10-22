<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$UniversityName = $_POST['editCategoriesName'];
  $UniversityStatus = $_POST['editCategoriesStatus']; 
  $categoriesId = $_POST['editCategoriesId'];

	$sql = "UPDATE categories SET categories_name = '$UniversityName', categories_active = '$UniversityStatus' WHERE categories_id = '$categoriesId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Updated";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while updating the categories";
	}
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST