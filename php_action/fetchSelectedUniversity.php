<?php 	

require_once 'core.php';

$UniversityId = $_POST['UniversityId'];

$sql = "SELECT University_id, University_name, University_active, University_status FROM university WHERE University_id = $UniversityId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);