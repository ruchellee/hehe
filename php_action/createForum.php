<?php 	
//ALTER TABLE `forum` ADD `payment_place` INT NOT NULL AFTER `payment_status`;
//TER TABLE `forum` ADD `gstn` VARCHAR(255) NOT NULL AFTER `payment_place`;
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array(), 'forum_id' => '');
// print_r($valid);
if($_POST) {	

	$forumDate 						= date('Y-m-d', strtotime($_POST['forumDate']));	
  $clientName 					= $_POST['clientName'];
  $clientContact 				= $_POST['clientContact'];
  $subTotalValue 				= $_POST['subTotalValue'];
  $vatValue 						=	$_POST['vatValue'];
  $totalAmountValue     = $_POST['totalAmountValue'];
  $discount 						= $_POST['discount'];
  $grandTotalValue 			= $_POST['grandTotalValue'];
  $paid 								= $_POST['paid'];
  $dueValue 						= $_POST['dueValue'];
  $paymentType 					= $_POST['paymentType'];
  $paymentStatus 				= $_POST['paymentStatus'];
  $paymentPlace 				= $_POST['paymentPlace'];
  $gstn 				= $_POST['gstn'];
  $userid 				= $_SESSION['userId'];

				
	$sql = "INSERT INTO forum (forum_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_type, payment_status,payment_place, gstn,forum_status,user_id) VALUES ('$forumDate', '$clientName', '$clientContact', '$subTotalValue', '$vatValue', '$totalAmountValue', '$discount', '$grandTotalValue', '$paid', '$dueValue', $paymentType, $paymentStatus,$paymentPlace,$gstn, 1,$userid)";
	
	$forum_id;
	$forumStatus = false;
	if($connect->query($sql) === true) {
		$forum_id = $connect->insert_id;
		$valid['forum_id'] = $forum_id;	

		$forumStatus = true;
	}

		
	// echo $_POST['CourseName'];
	$forumItemStatus = false;

	for($x = 0; $x < count($_POST['CourseName']); $x++) {			
		$updateCourseQuantitySql = "SELECT Course.quantity FROM Course WHERE Course.Course_id = ".$_POST['CourseName'][$x]."";
		$updateCourseQuantityData = $connect->query($updateCourseQuantitySql);
		
		
		while ($updateCourseQuantityResult = $updateCourseQuantityData->fetch_row()) {
			$updateQuantity[$x] = $updateCourseQuantityResult[0] - $_POST['quantity'][$x];							
				// update Course table
				$updateCourseTable = "UPDATE Course SET quantity = '".$updateQuantity[$x]."' WHERE Course_id = ".$_POST['CourseName'][$x]."";
				$connect->query($updateCourseTable);

				// add into forum_item
				$forumItemSql = "INSERT INTO forum_item (forum_id, Course_id, quantity, rate, total, forum_item_status) 
				VALUES ('$forum_id', '".$_POST['CourseName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

				$connect->query($forumItemSql);		

				if($x == count($_POST['CourseName'])) {
					$forumItemStatus = true;
				}		
		} // while	
	} // /for quantity

	$valid['success'] = true;
	$valid['messages'] = "Successfully Added";		
	
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);