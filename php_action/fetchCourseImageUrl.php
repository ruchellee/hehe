<?php 	

require_once 'core.php';

$CourseId = $_GET['i'];

$sql = "SELECT Course_image FROM Course WHERE Course_id = {$CourseId}";
$data = $connect->query($sql);
$result = $data->fetch_row();

$connect->close();

echo "stock/" . $result[0];
