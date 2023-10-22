<?php 	

require_once 'core.php';

$CourseId = $_POST['CourseId'];

$sql = "SELECT Course_id, Course_name, Course_image, University_id, categories_id, quantity, rate, active, status FROM Course WHERE Course_id = $CourseId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);