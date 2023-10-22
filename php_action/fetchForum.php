<?php 	

require_once 'core.php';

$sql = "SELECT forum_id, forum_date, client_name, client_contact, payment_status FROM forum WHERE forum_status = 1";
$result = $connect->query($sql);



$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $paymentStatus = ""; 
 $x = 1;

 while($row = $result->fetch_array()) {
 	$forumId = $row[0];

 	$countforumItemSql = "SELECT count(*) FROM forum_item WHERE forum_id = $forumId";
 	$itemCountResult = $connect->query($countforumItemSql);
 	$itemCountRow = $itemCountResult->fetch_row();


 	// active 
 	if($row[4] == 1) { 		
 		$paymentStatus = "<label class='label label-success'>Full Payment</label>";
 	} else if($row[4] == 2) { 		
 		$paymentStatus = "<label class='label label-info'>Advance Payment</label>";
 	} else { 		
 		$paymentStatus = "<label class='label label-warning'>No Payment</label>";
 	} // /else

 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a href="forum.php?o=editOrd&i='.$forumId.'" id="editforumModalBtn"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    
	    <li><a type="button" data-toggle="modal" id="paymentforumModalBtn" data-target="#paymentforumModal" onclick="paymentforum('.$forumId.')"> <i class="glyphicon glyphicon-save"></i> Payment</a></li>

	    <li><a type="button" onclick="printforum('.$forumId.')"> <i class="glyphicon glyphicon-print"></i> Print </a></li>
	    
	    <li><a type="button" data-toggle="modal" data-target="#removeforumModal" id="removeforumModalBtn" onclick="removeforum('.$forumId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';		

 	$output['data'][] = array( 		
 		// image
 		$x,
 		// forum date
 		$row[1],
 		// client name
 		$row[2], 
 		// client contact
 		$row[3], 		 	
 		$itemCountRow, 		 	
 		$paymentStatus,
 		// button
 		$button 		
 		); 	
 	$x++;
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);