<?php 

require_once 'core.php';

if($_POST) {

	$startDate = $_POST['startDate'];
	$date = DateTime::createFromFormat('m/d/Y',$startDate);
	$start_date = $date->format("Y-m-d");


	$endDate = $_POST['endDate'];
	$format = DateTime::createFromFormat('m/d/Y',$endDate);
	$end_date = $format->format("Y-m-d");

	$sql = "SELECT * FROM forum WHERE forum_date >= '$start_date' AND forum_date <= '$end_date' and forum_status = 1";
	$query = $connect->query($sql);

	$table = '<table bforum="1" cellspacing="0" cellpadding="0" style="width:100%;">
		<tr>
			<th>forum Date</th>
			<th>Client Name</th>
			<th>Contact</th>
			<th>Grand Total</th>
		</tr>
		<tr>';
		$totalAmount = 0;
		while ($result = $query->fetch_assoc()) {
			$table .= '<tr>
				<td><center>'.$result['forum_date'].'</center></td>
				<td><center>'.$result['client_name'].'</center></td>
				<td><center>'.$result['client_contact'].'</center></td>
				<td><center>'.$result['grand_total'].'</center></td>
			</tr>';	
			$totalAmount = $totalAmount + $result['grand_total'];
		}
		$table .= '
		</tr>
		<tr>
			<td colspan="3"><center>Total Amount</center></td>
			<td><center>'.$totalAmount.'</center></td>
		</tr>
	</table>
	';	

	echo $table;

}

?>