<?php 	

require_once 'core.php';

$sql = "SELECT Course_id, Course_name FROM Course WHERE status = 1 AND active = 1";
$result = $connect->query($sql);

$data = $result->fetch_all();

$connect->close();

echo json_encode($data);