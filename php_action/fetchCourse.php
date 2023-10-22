<?php 	



require_once 'core.php';

$sql = "SELECT Course.Course_id, Course.Course_name, Course.Course_image, Course.University_id,
 		Course.categories_id, Course.quantity, Course.rate, Course.active, Course.status, 
 		university.University_name, categories.categories_name FROM Course 
		INNER JOIN university ON Course.University_id = university.University_id 
		INNER JOIN categories ON Course.categories_id = categories.categories_id  
		WHERE Course.status = 1 AND Course.quantity>0";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$CourseId = $row[0];
 	// active 
 	if($row[7] == 1) {
 		// activate member
 		$active = "<label class='label label-success'>Available</label>";
 	} else {
 		// deactivate member
 		$active = "<label class='label label-danger'>Not Available</label>";
 	} // /else

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" id="editCourseModalBtn" data-target="#editCourseModal" onclick="editCourse('.$CourseId.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeCourseModal" id="removeCourseModalBtn" onclick="removeCourse('.$CourseId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';

	// $UniversityId = $row[3];
	// $UniversitySql = "SELECT * FROM university WHERE University_id = $UniversityId";
	// $UniversityData = $connect->query($sql);
	// $University = "";
	// while($row = $UniversityData->fetch_assoc()) {
	// 	$University = $row['University_name'];
	// }

	$University = $row[9];
	$category = $row[10];

	$imageUrl = substr($row[2], 3);
	$CourseImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

 	$output['data'][] = array( 		
 		// image
 		$CourseImage,
 		// Course name
 		$row[1], 
 		// rate
 		$row[6],
 		// quantity 
 		$row[5], 		 	
 		// University
 		$University,
 		// category 		
 		$category,
 		// active
 		$active,
 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);