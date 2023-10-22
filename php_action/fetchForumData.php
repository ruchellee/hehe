<?php 	

require_once 'core.php';

$forumId = $_POST['forumId'];

$valid = array('forum' => array(), 'forum_item' => array());

$sql = "SELECT forum.forum_id, forum.forum_date, forum.client_name, forum.client_contact, forum.sub_total, forum.vat, forum.total_amount, forum.discount, forum.grand_total, forum.paid, forum.due, forum.payment_type, forum.payment_status FROM forum 	
	WHERE forum.forum_id = {$forumId}";

$result = $connect->query($sql);
$data = $result->fetch_row();
$valid['forum'] = $data;


$connect->close();

echo json_encode($valid);