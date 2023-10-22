<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	
	$forumId = $_POST['forumId'];

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
				
	$sql = "UPDATE forum SET forum_date = '$forumDate', client_name = '$clientName', client_contact = '$clientContact', sub_total = '$subTotalValue', vat = '$vatValue', total_amount = '$totalAmountValue', discount = '$discount', grand_total = '$grandTotalValue', paid = '$paid', due = '$dueValue', payment_type = '$paymentType', payment_status = '$paymentStatus', forum_status = 1 ,user_id = '$userid',payment_place = '$paymentPlace' , gstn = '$gstn' WHERE forum_id = {$forumId}";	
	$connect->query($sql);
	
	$readyToUpdateforumItem = false;
	// add the quantity from the forum item to Course table
	for($x = 0; $x < count($_POST['CourseName']); $x++) {		
		//  Course table
		$updateCourseQuantitySql = "SELECT Course.quantity FROM Course WHERE Course.Course_id = ".$_POST['CourseName'][$x]."";
		$updateCourseQuantityData = $connect->query($updateCourseQuantitySql);			
			
		while ($updateCourseQuantityResult = $updateCourseQuantityData->fetch_row()) {
			// forum item table add Course quantity
			$forumItemTableSql = "SELECT forum_item.quantity FROM forum_item WHERE forum_item.forum_id = {$forumId}";
			$forumItemResult = $connect->query($forumItemTableSql);
			$forumItemData = $forumItemResult->fetch_row();

			$editQuantity = $updateCourseQuantityResult[0] + $forumItemData[0];							

			$updateQuantitySql = "UPDATE Course SET quantity = $editQuantity WHERE Course_id = ".$_POST['CourseName'][$x]."";
			$connect->query($updateQuantitySql);		
		} // while	
		
		if(count($_POST['CourseName']) == count($_POST['CourseName'])) {
			$readyToUpdateforumItem = true;			
		}
	} // /for quantity

	// remove the forum item data from forum item table
	for($x = 0; $x < count($_POST['CourseName']); $x++) {			
		$removeforumSql = "DELETE FROM forum_item WHERE forum_id = {$forumId}";
		$connect->query($removeforumSql);	
	} // /for quantity

	if($readyToUpdateforumItem) {
			// insert the forum item data 
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
				VALUES ({$forumId}, '".$_POST['CourseName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

				$connect->query($forumItemSql);		
			} // while	
		} // /for quantity
	}

	

	$valid['success'] = true;
	$valid['messages'] = "Successfully Updated";		
	
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);