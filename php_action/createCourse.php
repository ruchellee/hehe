<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$CourseName 		= $_POST['CourseName'];
  // $CourseImage 	= $_POST['CourseImage'];
  $quantity 			= $_POST['quantity'];
  $rate 					= $_POST['rate'];
  $UniversityName 			= $_POST['UniversityName'];
  $categoryName 	= $_POST['categoryName'];
  $CourseStatus 	= $_POST['CourseStatus'];

	$type = explode('.', $_FILES['CourseImage']['name']);
	$type = $type[count($type)-1];		
	$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if(is_uploaded_file($_FILES['CourseImage']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['CourseImage']['tmp_name'], $url)) {
				
				$sql = "INSERT INTO Course (Course_name, Course_image, University_id, categories_id, quantity, rate, active, status) 
				VALUES ('$CourseName', '$url', '$UniversityName', '$categoryName', '$quantity', '$rate', '$CourseStatus', 1)";

				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members";
				}

			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST