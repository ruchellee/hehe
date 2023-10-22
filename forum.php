<?php 
require_once 'php_action/db_connect.php'; 
require_once 'includes/header.php'; 

if($_GET['o'] == 'add') { 
// add forum
	echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['o'] == 'manord') { 
	echo "<div class='div-request div-hide'>manord</div>";
} else if($_GET['o'] == 'editOrd') { 
	echo "<div class='div-request div-hide'>editOrd</div>";
} // /else manage forum


?>

<ol class="breadcrumb">
  <li><a href="dashboard.php">Home</a></li>
  <li>forum</li>
  <li class="active">
  	<?php if($_GET['o'] == 'add') { ?>
  		Add forum
		<?php } else if($_GET['o'] == 'manord') { ?>
			Manage forum
		<?php } // /else manage forum ?>
  </li>
</ol>


<h4>
	<i class='glyphicon glyphicon-circle-arrow-right'></i>
	<?php if($_GET['o'] == 'add') {
		echo "Add forum";
	} else if($_GET['o'] == 'manord') { 
		echo "Manage forum";
	} else if($_GET['o'] == 'editOrd') { 
		echo "Edit forum";
	}
	?>	
</h4>



<div class="panel panel-default">
	<div class="panel-heading">

		<?php if($_GET['o'] == 'add') { ?>
  		<i class="glyphicon glyphicon-plus-sign"></i>	Add forum
		<?php } else if($_GET['o'] == 'manord') { ?>
			<i class="glyphicon glyphicon-edit"></i> Manage forum
		<?php } else if($_GET['o'] == 'editOrd') { ?>
			<i class="glyphicon glyphicon-edit"></i> Edit forum
		<?php } ?>

	</div> <!--/panel-->	
	<div class="panel-body">
			
		<?php if($_GET['o'] == 'add') { 
			// add forum
			?>			

			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/createforum.php" id="createforumForm">

			  <div class="form-group">
			    <label for="forumDate" class="col-sm-2 control-label">forum Date</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="forumDate" name="forumDate" autocomplete="off" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">Client Name</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Client Name" autocomplete="off" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-2 control-label">Client Contact</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Contact Number" autocomplete="off" />
			    </div>
			  </div> <!--/form-group-->			  

			  <table class="table" id="CourseTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;">Course</th>
			  			<th style="width:20%;">Rate</th>
			  			<th style="width:10%;">Available Quantity</th>
			  			<th style="width:15%;">Quantity</th>			  			
			  			<th style="width:25%;">Total</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php
			  		$arrayNumber = 0;
			  		for($x = 1; $x < 2; $x++) { ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="CourseName[]" id="CourseName<?php echo $x; ?>" onchange="getCourseData(<?php echo $x; ?>)" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
			  							$CourseSql = "SELECT * FROM Course WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$CourseData = $connect->query($CourseSql);

			  							while($row = $CourseData->fetch_array()) {									 		
			  								echo "<option value='".$row['Course_id']."' id='changeCourse".$row['Course_id']."'>".$row['Course_name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />			  					
			  					<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" />			  					
			  				</td>
							<td style="padding-left:20px;">
			  					<div class="form-group">
									<p id="available_quantity<?php echo $x; ?>"></p>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeCourseRowBtn" type="button" id="removeCourseRowBtn" onclick="removeCourseRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
			  		} // /for
			  		?>
			  	</tbody>			  	
			  </table>

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
				    </div>
				  </div> <!--/form-group-->			  
				   <!--/form-group-->			  
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true"/>
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Discount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" />
				      <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="vat" class="col-sm-3 control-label gst">GST 18%</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vat" name="gstn" readonly="true" />
				      <input type="hidden" class="form-control" id="vatValue" name="vatValue" />
				    </div>
				  </div>	  		  
			  </div> <!--/col-md-6-->

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Paid Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Due Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" />
				    </div>
				  </div> <!--/form-group-->		
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentType" id="paymentType">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Cheque</option>
				      	<option value="2">Cash</option>
				      	<option value="3">Credit Card</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentStatus" id="paymentStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Full Payment</option>
				      	<option value="2">Advance Payment</option>
				      	<option value="3">No Payment</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Place</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentPlace" id="paymentPlace">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">In Gujarat</option>
				      	<option value="2">Out Of Gujarat</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
			  </div> <!--/col-md-6-->


			  <div class="form-group submitButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
			    <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>

			      <button type="submit" id="createforumBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>

			      <button type="reset" class="btn btn-default" onclick="resetforumForm()"><i class="glyphicon glyphicon-erase"></i> Reset</button>
			    </div>
			  </div>
			</form>
		<?php } else if($_GET['o'] == 'manord') { 
			// manage forum
			?>

			<div id="success-messages"></div>
			
			<table class="table" id="manageforumTable">
				<thead>
					<tr>
						<th>#</th>
						<th>forum Date</th>
						<th>Client Name</th>
						<th>Contact</th>
						<th>Total forum Item</th>
						<th>Payment Status</th>
						<th>Option</th>
					</tr>
				</thead>
			</table>

		<?php 
		// /else manage forum
		} else if($_GET['o'] == 'editOrd') {
			// get forum
			?>
			
			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/editforum.php" id="editforumForm">

  			<?php $forumId = $_GET['i'];

  			$sql = "SELECT forum.forum_id, forum.forum_date, forum.client_name, forum.client_contact, forum.sub_total, forum.vat, forum.total_amount, forum.discount, forum.grand_total, forum.paid, forum.due, forum.payment_type, forum.payment_status,forum.payment_place,forum.gstn FROM forum 	
					WHERE forum.forum_id = {$forumId}";

				$result = $connect->query($sql);
				$data = $result->fetch_row();
  			?>

			  <div class="form-group">
			    <label for="forumDate" class="col-sm-2 control-label">forum Date</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="forumDate" name="forumDate" autocomplete="off" value="<?php echo $data[1] ?>" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">Client Name</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Client Name" autocomplete="off" value="<?php echo $data[2] ?>" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-2 control-label">Client Contact</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Contact Number" autocomplete="off" value="<?php echo $data[3] ?>" />
			    </div>
			  </div> <!--/form-group-->			  

			  <table class="table" id="CourseTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;">Course</th>
			  			<th style="width:20%;">Rate</th>
			  			<th style="width:15%;">Available Quantity</th>			  			
			  			<th style="width:15%;">Quantity</th>			  			
			  			<th style="width:15%;">Total</th>			  			
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php

			  		$forumItemSql = "SELECT forum_item.forum_item_id, forum_item.forum_id, forum_item.Course_id, forum_item.quantity, forum_item.rate, forum_item.total FROM forum_item WHERE forum_item.forum_id = {$forumId}";
						$forumItemResult = $connect->query($forumItemSql);
						// $forumItemData = $forumItemResult->fetch_all();						
						
						// print_r($forumItemData);
			  		$arrayNumber = 0;
			  		// for($x = 1; $x <= count($forumItemData); $x++) {
			  		$x = 1;
			  		while($forumItemData = $forumItemResult->fetch_array()) { 
			  			// print_r($forumItemData); ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="CourseName[]" id="CourseName<?php echo $x; ?>" onchange="getCourseData(<?php echo $x; ?>)" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
			  							$CourseSql = "SELECT * FROM Course WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$CourseData = $connect->query($CourseSql);

			  							while($row = $CourseData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['Course_id'] == $forumItemData['Course_id']) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}

			  								echo "<option value='".$row['Course_id']."' id='changeCourse".$row['Course_id']."' ".$selected." >".$row['Course_name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $forumItemData['rate']; ?>" />			  					
			  					<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $forumItemData['rate']; ?>" />			  					
			  				</td>
							<td style="padding-left:20px;">
			  					<div class="form-group">
									<?php
			  							$CourseSql = "SELECT * FROM Course WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$CourseData = $connect->query($CourseSql);

			  							while($row = $CourseData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['Course_id'] == $forumItemData['Course_id']) { 
			  									echo "<p id='available_quantity".$row['Course_id']."'>".$row['quantity']."</p>";
											}
			  								 else {
			  									$selected = "";
			  								}

			  								//echo "<option value='".$row['Course_id']."' id='changeCourse".$row['Course_id']."' ".$selected." >".$row['Course_name']."</option>";
										 	} // /while 

			  						?>
									
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $forumItemData['quantity']; ?>" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $forumItemData['total']; ?>"/>			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $forumItemData['total']; ?>"/>			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeCourseRowBtn" type="button" id="removeCourseRowBtn" onclick="removeCourseRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
		  			$x++;
			  		} // /for
			  		?>
			  	</tbody>			  	
			  </table>

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Sub Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="<?php echo $data[4] ?>" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?php echo $data[4] ?>" />
				    </div>
				  </div> <!--/form-group-->			  
				  			  
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Total Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="<?php echo $data[6] ?>" />
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="<?php echo $data[6] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Discount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" value="<?php echo $data[7] ?>" />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="grandTotal" class="col-sm-3 control-label">Grand Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" value="<?php echo $data[8] ?>"  />
				      <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" value="<?php echo $data[8] ?>"  />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="vat" class="col-sm-3 control-label gst"><?php if($data[13] == 2) {echo "IGST 18%";} else echo "GST 18%"; ?></label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vat" name="vat" disabled="true" value="<?php echo $data[5] ?>"  />
				      <input type="hidden" class="form-control" id="vatValue" name="vatValue" value="<?php echo $data[5] ?>"  />
				    </div>
				  </div> 
				  <div class="form-group">
				    <label for="gstn" class="col-sm-3 control-label gst">G.S.T.IN</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="gstn" name="gstn" value="<?php echo $data[14] ?>"  />
				    </div>
				  </div><!--/form-group-->		  		  
			  </div> <!--/col-md-6-->

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Paid Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" value="<?php echo $data[9] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Due Amount</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" value="<?php echo $data[10] ?>"  />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" value="<?php echo $data[10] ?>"  />
				    </div>
				  </div> <!--/form-group-->		
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentType" id="paymentType" >
				      	<option value="">~~SELECT~~</option>
				      	<option value="1" <?php if($data[11] == 1) {
				      		echo "selected";
				      	} ?> >Cheque</option>
				      	<option value="2" <?php if($data[11] == 2) {
				      		echo "selected";
				      	} ?>  >Cash</option>
				      	<option value="3" <?php if($data[11] == 3) {
				      		echo "selected";
				      	} ?> >Credit Card</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentStatus" id="paymentStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1" <?php if($data[12] == 1) {
				      		echo "selected";
				      	} ?>  >Full Payment</option>
				      	<option value="2" <?php if($data[12] == 2) {
				      		echo "selected";
				      	} ?> >Advance Payment</option>
				      	<option value="3" <?php if($data[10] == 3) {
				      		echo "selected";
				      	} ?> >No Payment</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Payment Place</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentPlace" id="paymentPlace">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1" <?php if($data[13] == 1) {
				      		echo "selected";
				      	} ?>  >In Gujarat</option>
				      	<option value="2" <?php if($data[13] == 2) {
				      		echo "selected";
				      	} ?> >Out Gujarat</option>
				      </select>
				    </div>
				  </div>							  
			  </div> <!--/col-md-6-->


			  <div class="form-group editButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
			    <button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Add Row </button>

			    <input type="hidden" name="forumId" id="forumId" value="<?php echo $_GET['i']; ?>" />

			    <button type="submit" id="editforumBtn" data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
			      
			    </div>
			  </div>
			</form>

			<?php
		} // /get forum else  ?>


	</div> <!--/panel-->	
</div> <!--/panel-->	


<!-- edit forum -->
<div class="modal fade" tabindex="-1" role="dialog" id="paymentforumModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> Edit Payment</h4>
      </div>      

      <div class="modal-body form-horizontal" style="max-height:500px; overflow:auto;" >

      	<div class="paymentforumMessages"></div>

      	     				 				 
			  <div class="form-group">
			    <label for="due" class="col-sm-3 control-label">Due Amount</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="due" name="due" disabled="true" />					
			    </div>
			  </div> <!--/form-group-->		
			  <div class="form-group">
			    <label for="payAmount" class="col-sm-3 control-label">Pay Amount</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="payAmount" name="payAmount"/>					      
			    </div>
			  </div> <!--/form-group-->		
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentType" id="paymentType" >
			      	<option value="">~~SELECT~~</option>
			      	<option value="1">Cheque</option>
			      	<option value="2">Cash</option>
			      	<option value="3">Credit Card</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->							  
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentStatus" id="paymentStatus">
			      	<option value="">~~SELECT~~</option>
			      	<option value="1">Full Payment</option>
			      	<option value="2">Advance Payment</option>
			      	<option value="3">No Payment</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->							  				  
      	        
      </div> <!--/modal-body-->
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="updatePaymentforumBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>	
      </div>           
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /edit forum-->

<!-- remove forum -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeforumModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove forum</h4>
      </div>
      <div class="modal-body">

      	<div class="removeforumMessages"></div>

        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removeCourseFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeforumBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove forum-->


<script src="custom/js/forum.js"></script>

<?php require_once 'includes/footer.php'; ?>


	