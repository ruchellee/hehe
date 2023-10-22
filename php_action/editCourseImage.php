<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {		

$CourseId = $_POST['CourseId'];
 
$type = explode('.', $_FILES['editCourseImage']['name']);
	$type = $type[count($type)-1];		
	$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if(is_uploaded_file($_FILES['editCourseImage']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['editCourseImage']['tmp_name'], $url)) {

				$sql = "UPDATE Course SET Course_image = '$url' WHERE Course_id = $CourseId";				

				if($connect->query($sql) === TRUE) {									
					$valid['success'] = true;
					$valid['messages'] = "Successfully Updated";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while updating Course image";
				}
			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 		
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST