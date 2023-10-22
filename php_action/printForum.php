<?php    

require_once 'core.php';

$forumId = $_POST['forumId'];

$sql = "SELECT forum_date, client_name, client_contact, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_place,gstn FROM forum WHERE forum_id = $forumId";

$forumResult = $connect->query($sql);
$forumData = $forumResult->fetch_array();

$forumDate = $forumData[0];
$clientName = $forumData[1];
$clientContact = $forumData[2]; 
$subTotal = $forumData[3];
$vat = $forumData[4];
$totalAmount = $forumData[5]; 
$discount = $forumData[6];
$grandTotal = $forumData[7];
$paid = $forumData[8];
$due = $forumData[9];
$payment_place = $forumData[10];
$gstn = $forumData[11];


$forumItemSql = "SELECT forum_item.Course_id, forum_item.rate, forum_item.quantity, forum_item.total,
Course.Course_name FROM forum_item
   INNER JOIN Course ON forum_item.Course_id = Course.Course_id 
 WHERE forum_item.forum_id = $forumId";
$forumItemResult = $connect->query($forumItemSql);

 $table = '<style>
.star img {
    visibility: visible;
}</style>
<table align="center" cellpadding="0" cellspacing="0" style="width: 100%;bforum:1px solid black;margin-bottom: 10px;">
               <tbody>
                  <tr>
                     <td colspan="5" style="text-align:center;color: red;text-decoration: underline;    font-size: 25px;">TAX INVOICE</td>
                  </tr>
                  <tr>
                     <td rowspan="8" colspan="2" style="bforum-left:1px solid black;" background-image="logo.jpg"><img src="/logo.jpg" alt="logo" width="250px;"></td>
                     <td colspan="3" style=" text-align: right;">ORIGINAL</td>
                  </tr>
                  <tr>
                     <td colspan="3" style=" text-align: right;">DUPLICATE</td>
                  </tr>
                  <tr>
                     <td colspan="3" style=" text-align: right;color: red;font-style: italic;font-weight: 600;text-decoration: underline;font-size: 25px;">IMS</td>
                  </tr>
                  <tr>
                     <td colspan="3" style=" text-align: right;">Nr. Your First Address,</td>
                  </tr>
                  <tr>
                     <td colspan="3" style=" text-align: right;">Cityname,Pincode</td>
                  </tr>
                  <tr>
                     <td colspan="3" style=" text-align: right;">Tele: 1234567890,1478523690.</td>
                  </tr>
                  <tr>
                     <td colspan="3" style=" text-align: right;">Email: email0@email.co.in</td>
                  </tr>
                  <tr>
                     <td colspan="3" style=" text-align: right;color: blue;text-decoration: underline;">email0@email.co.in</td>
                  </tr>
                  <tr>
                     <td colspan="2" style="padding: 0px;vertical-align: top;bforum-right:1px solid black;">
                        <table align="left" cellpadding="0" cellspacing="0" style="bforum: thin solid black; width: 100%">
                           <tbody>
                              <tr>
                                 <td style="width: 74px;vertical-align: top;color: red;" rowspan="3">TO, </td>
                                 <td style="bforum-bottom-style: solid; bforum-bottom-width: thin; bforum-bottom-color: red">&nbsp;'.$clientName.'</td>
                              </tr>
                              <tr>
                                 <td style="bforum-bottom-style: solid; bforum-bottom-width: thin; bforum-bottom-color: black">&nbsp;</td>
                              </tr>
                              <tr>
                                 <td style="bforum-bottom-style: solid; bforum-bottom-width: thin; bforum-bottom-color: black">&nbsp;</td>
                              </tr>
                           </tbody>
                        </table>
                        <table align="left" cellspacing="0" style="width: 100%; bforum-right-style: solid; bforum-bottom-style: solid; bforum-left-style: solid; bforum-right-width: thin; bforum-bottom-width: thin; bforum-left-width: thin; bforum-right-color: black; bforum-bottom-color: black; bforum-left-color: black;">
                           <tbody>
                              <tr>
                                 <td style=" bforum-bottom-style: solid; bforum-bottom-width: thin; bforum-bottom-color: red;color: red;">G.S.T.IN :'.$gstn.'</td>
                                 <td style="bforum-left-style: solid; bforum-left-width: thin; bforum-left-color: black; bforum-bottom-style: solid; bforum-bottom-width: thin; bforum-bottom-color: red;color: red;">Mobile No: '.$clientContact.'</td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                     <td style="padding: 0px;vertical-align: top;" colspan="3">
                        <table align="left" cellpadding="0" cellspacing="0" style="width: 100%">
                           <tbody>
                              <tr>
                                 <td style="bforum-bottom-style: solid;bforum-bottom-width: thin;bforum-bottom-color: black;bforum-top: 1px solid black;bforum-right: 1px solid black;color: red;">Bill No : .</td>
                              </tr>
                              <tr>
                                 <td style="bforum-bottom-style: solid;bforum-bottom-width: thin;bforum-bottom-color: black;bforum-right: 1px solid black;    color: red;">Date: '.$forumDate.'</td>
                              </tr>
                              <tr>
                                 <td style="bforum-bottom-style: solid;bforum-bottom-width: thin;bforum-bottom-color: black;height: 52px;bforum-right: 1px solid black;    color: red;">G.S.T.IN: lorem ipsum</td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                  </tr>
                  <tr>
                     <td style="width: 123px;text-align: center;background-color: black;color: white;bforum-right: 1px solid white;bforum-left: 1px solid black;bforum-bottom: 1px solid black;-webkit-print-color-adjust: exact;">D.C.NO<br>
                        &amp;DATE
                     </td>
                     <td style="width: 50%;text-align: center;bforum-top-style: solid;bforum-right-style: solid;bforum-bottom-style: solid;bforum-top-width: thin;bforum-right-width: thin;bforum-bottom-width: thin;bforum-top-color: black;bforum-right-color: white;bforum-bottom-color: black;color: white;background-color: black;-webkit-print-color-adjust: exact;">Description Of Goods</td>
                     <td style="width: 150px;text-align: center;bforum-top-style: solid;bforum-right-style: solid;bforum-bottom-style: solid;bforum-top-width: thin;bforum-right-width: thin;bforum-bottom-width: thin;bforum-top-color: black;bforum-right-color: #fff;bforum-bottom-color: black;background-color: black;color: white;-webkit-print-color-adjust: exact;">Qty.</td>
                     <td style="width: 150px;text-align: center;bforum-top-style: solid;bforum-right-style: solid;bforum-bottom-style: solid;bforum-top-width: thin;bforum-right-width: thin;bforum-bottom-width: thin;bforum-top-color: black;bforum-right-color: #fff;bforum-bottom-color: black;background-color: black;color: white;-webkit-print-color-adjust: exact;">Rate&nbsp; Rs.<br>
                        Ps
                     </td>
                     <td style="width: 150px;text-align: center;bforum-top-style: solid;bforum-right-style: solid;bforum-bottom-style: solid;bforum-top-width: thin;bforum-right-width: thin;bforum-bottom-width: thin;bforum-top-color: black;bforum-right-color: black;bforum-bottom-color: black;color: white;background-color: black;-webkit-print-color-adjust: exact;">Amount&nbsp; Rs.<br>
                        &nbsp;Ps
                     </td>
                  </tr>';
                  $x = 1;
                  $cgst = 0;
                  $igst = 0;
                  if($payment_place == 2)
                  {
                     $igst = $subTotal*18/100;
                  }
                  else
                  {
                     $cgst = $subTotal*9/100;
                  }
                  $total = $subTotal+2*$cgst+$igst;
            while($row = $forumItemResult->fetch_array()) {       
                        
               $table .= '<tr>
                     <td style="bforum-left: 1px solid black;bforum-right: 1px solid black;height: 27px;">'.$x.'</td>
                     <td style="bforum-left: 1px solid black;height: 27px;">'.$row[4].'</td>
                     <td style="bforum-left: 1px solid black;height: 27px;">'.$row[2].'</td>
                     <td style="bforum-left: 1px solid black;height: 27px;">'.$row[1].'</td>
                     <td style="bforum-left: 1px solid black;bforum-right: 1px solid black;height: 27px;">'.$row[3].'</td>
                  </tr>
               ';
            $x++;
            } // /while
                $table.= '
                  <tr style="bforum-bottom: 1px solid black;">
                     <td style="bforum-left: 1px solid black;bforum-right: 1px solid black;height: 27px;"></td>
                     <td style="bforum-left: 1px solid black;height: 27px;"></td>
                     <td style="bforum-left: 1px solid black;height: 27px;"></td>
                     <td style="width: 149px;bforum-right-style: solid;bforum-bottom-style: solid;bforum-right-width: thin;bforum-bottom-width: thin;bforum-right-color: black;bforum-bottom-color: #000;background-color: black;color: white;padding-left: 5px;-webkit-print-color-adjust: exact;">Total</td>
                     <td style="width: 218px; bforum-top-style: solid; bforum-right-style: solid; bforum-bottom-style: solid; bforum-top-width: thin; bforum-right-width: thin; bforum-bottom-width: thin; bforum-top-color: black; bforum-right-color: black; bforum-bottom-color: black;">'.$subTotal.'</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="bforum-top: 1px solid black;bforum-bottom: 1px solid black;bforum-left: 1px solid black;padding: 5px;">Neft For:- Bank Name</td>
                     <td rowspan="2" style="bforum-bottom: 1px solid black;width: 199px;color: white;background-color: black;padding-left: 5px;-webkit-print-color-adjust: exact;">S.G.S.T. 9%</td>
                     <td rowspan="2" style="bforum-bottom: 1px solid black;width: 288px;bforum-right: 1px solid black;">'.$cgst.'</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="bforum-bottom: 1px solid black;width: 859px;bforum-left: 1px solid black;padding: 5px;">Branch:- branch Address</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="bforum-bottom: 1px solid black;bforum-left: 1px solid black;padding: 5px;">Bank IFSC CODE:- 78945612301</td>
                     <td rowspan="2" style="bforum-bottom: 1px solid black;width: 149px;background-color: black;color: white;padding-left: 5px;-webkit-print-color-adjust: exact;">C.G.S.T. 9%</td>
                     <td rowspan="2" style="width:218px;bforum-bottom: 1px solid black;bforum-right: 1px solid black;">'.$cgst.'
                     </td>
                  </tr>
                  <tr>
                     <td colspan="3" style="bforum-bottom: 1px solid black;bforum-left: 1px solid black;padding: 5px;">AC. HO. Name:- Comapany Name</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="bforum-bottom: 1px solid black;bforum-left: 1px solid black;padding: 5px;">AC.NO. :- lorem ipsum</td>
                     <td style="bforum-bottom: 1px solid black;background-color: black;color: white;padding: 5px;-webkit-print-color-adjust: exact;">I.G.S.T. 18%</td>
                     <td style="bforum-bottom: 1px solid black;bforum-right: 1px solid black;">'.$igst.'</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="bforum-left: 1px solid black;bforum-bottom: 1px solid black;color: red;padding: 5px;">Amount in words</td>
                     <td style="bforum-bottom: 1px solid #fff;background-color: black;color: white;padding: 5px;-webkit-print-color-adjust: exact;">G. Total</td>
                     <td style="bforum-bottom: 1px solid black;bforum-right: 1px solid;">'.$total.'</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="bforum-left: 1px solid black;bforum-bottom: 1px solid black;padding: 5px;bforum-right: 1px solid black;">* Subject to lorem ipsum             <span style="float: right;"> E.&amp;.O.E.</span></td>
                     <td rowspan="2" colspan="2" style="vertical-align: bottom;padding: 5px;color: red;bforum-right: 1px solid black;text-align: center;">for, Company Name</td>
                  </tr>
                  <tr>
                     <td colspan="3" style="bforum-left: 1px solid black;padding-left: 5px;bforum-right: 1px solid black;">
                        * Intrest will be charged upon all acounts 
                        <p style="margin: 0px;">remaning unpaid after due date</p>
                     </td>
                  </tr>
               </tbody>
            </table>';
$connect->close();

echo $table;