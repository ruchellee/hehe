<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {
	$CourseId = $_POST['CourseId'];
	$CourseName 		= $_POST['editCourseName']; 
  $quantity 			= $_POST['editQuantity'];
  $rate 					= $_POST['editRate'];
  $UniversityName 			= $_POST['editUniversityName'];
  $categoryName 	= $_POST['editCategoryName'];
  $CourseStatus 	= $_POST['editCourseStatus'];

				
	$sql = "UPDATE Course SET Course_name = '$CourseName', University_id = '$UniversityName', categories_id = '$categoryName', quantity = '$quantity', rate = '$rate', active = '$CourseStatus', status = 1 WHERE Course_id = $CourseId ";

	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Update";	
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating Course info";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);
 
