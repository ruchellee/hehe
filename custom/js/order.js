var manageforumTable;

$(document).ready(function () {
  $("#paymentPlace").change(function () {
    if ($("#paymentPlace").val() == 2) {
      $(".gst").text("IGST 18%");
    } else {
      $(".gst").text("GST 18%");
    }
  });

  var divRequest = $(".div-request").text();

  // top nav bar
  $("#navforum").addClass("active");

  if (divRequest == "add") {
    // add forum
    // top nav child bar
    $("#topNavAddforum").addClass("active");

    // forum date picker
    $("#forumDate").datepicker();

    // create forum form function
    $("#createforumForm")
      .unbind("submit")
      .bind("submit", function () {
        var form = $(this);

        $(".form-group").removeClass("has-error").removeClass("has-success");
        $(".text-danger").remove();

        var forumDate = $("#forumDate").val();
        var clientName = $("#clientName").val();
        var clientContact = $("#clientContact").val();
        var paid = $("#paid").val();
        var discount = $("#discount").val();
        var paymentType = $("#paymentType").val();
        var paymentStatus = $("#paymentStatus").val();

        // form validation
        if (forumDate == "") {
          $("#forumDate").after(
            '<p class="text-danger"> The forum Date field is required </p>'
          );
          $("#forumDate").closest(".form-group").addClass("has-error");
        } else {
          $("#forumDate").closest(".form-group").addClass("has-success");
        } // /else

        if (clientName == "") {
          $("#clientName").after(
            '<p class="text-danger"> The Client Name field is required </p>'
          );
          $("#clientName").closest(".form-group").addClass("has-error");
        } else {
          $("#clientName").closest(".form-group").addClass("has-success");
        } // /else

        if (clientContact == "") {
          $("#clientContact").after(
            '<p class="text-danger"> The Contact field is required </p>'
          );
          $("#clientContact").closest(".form-group").addClass("has-error");
        } else {
          $("#clientContact").closest(".form-group").addClass("has-success");
        } // /else

        if (paid == "") {
          $("#paid").after(
            '<p class="text-danger"> The Paid field is required </p>'
          );
          $("#paid").closest(".form-group").addClass("has-error");
        } else {
          $("#paid").closest(".form-group").addClass("has-success");
        } // /else

        if (discount == "") {
          $("#discount").after(
            '<p class="text-danger"> The Discount field is required </p>'
          );
          $("#discount").closest(".form-group").addClass("has-error");
        } else {
          $("#discount").closest(".form-group").addClass("has-success");
        } // /else

        if (paymentType == "") {
          $("#paymentType").after(
            '<p class="text-danger"> The Payment Type field is required </p>'
          );
          $("#paymentType").closest(".form-group").addClass("has-error");
        } else {
          $("#paymentType").closest(".form-group").addClass("has-success");
        } // /else

        if (paymentStatus == "") {
          $("#paymentStatus").after(
            '<p class="text-danger"> The Payment Status field is required </p>'
          );
          $("#paymentStatus").closest(".form-group").addClass("has-error");
        } else {
          $("#paymentStatus").closest(".form-group").addClass("has-success");
        } // /else

        // array validation
        var CourseName = document.getElementsByName("CourseName[]");
        var validateCourse;
        for (var x = 0; x < CourseName.length; x++) {
          var CourseNameId = CourseName[x].id;
          if (CourseName[x].value == "") {
            $("#" + CourseNameId + "").after(
              '<p class="text-danger"> Course Name Field is required!! </p>'
            );
            $("#" + CourseNameId + "")
              .closest(".form-group")
              .addClass("has-error");
          } else {
            $("#" + CourseNameId + "")
              .closest(".form-group")
              .addClass("has-success");
          }
        } // for

        for (var x = 0; x < CourseName.length; x++) {
          if (CourseName[x].value) {
            validateCourse = true;
          } else {
            validateCourse = false;
          }
        } // for

        var quantity = document.getElementsByName("quantity[]");
        var validateQuantity;
        for (var x = 0; x < quantity.length; x++) {
          var quantityId = quantity[x].id;
          if (quantity[x].value == "") {
            $("#" + quantityId + "").after(
              '<p class="text-danger"> Course Name Field is required!! </p>'
            );
            $("#" + quantityId + "")
              .closest(".form-group")
              .addClass("has-error");
          } else {
            $("#" + quantityId + "")
              .closest(".form-group")
              .addClass("has-success");
          }
        } // for

        for (var x = 0; x < quantity.length; x++) {
          if (quantity[x].value) {
            validateQuantity = true;
          } else {
            validateQuantity = false;
          }
        } // for

        if (
          forumDate &&
          clientName &&
          clientContact &&
          paid &&
          discount &&
          paymentType &&
          paymentStatus
        ) {
          if (validateCourse == true && validateQuantity == true) {
            // create forum button
            // $("#createforumBtn").button('loading');

            $.ajax({
              url: form.attr("action"),
              type: form.attr("method"),
              data: form.serialize(),
              dataType: "json",
              success: function (response) {
                console.log(response);
                // reset button
                $("#createforumBtn").button("reset");

                $(".text-danger").remove();
                $(".form-group")
                  .removeClass("has-error")
                  .removeClass("has-success");

                if (response.success == true) {
                  // create forum button
                  $(".success-messages").html(
                    '<div class="alert alert-success">' +
                      '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                      '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' +
                      response.messages +
                      ' <br /> <br /> <a type="button" onclick="printforum(' +
                      response.forum_id +
                      ')" class="btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Print </a>' +
                      '<a href="forum.php?o=add" class="btn btn-default" style="margin-left:10px;"> <i class="glyphicon glyphicon-plus-sign"></i> Add New forum </a>' +
                      "</div>"
                  );

                  $("html, body, div.panel, div.pane-body").animate(
                    { scrollTop: "0px" },
                    100
                  );

                  // disabled te modal footer button
                  $(".submitButtonFooter").addClass("div-hide");
                  // remove the Course row
                  $(".removeCourseRowBtn").addClass("div-hide");
                } else {
                  alert(response.messages);
                }
              }, // /response
            }); // /ajax
          } // if array validate is true
        } // /if field validate is true

        return false;
      }); // /create forum form function
  } else if (divRequest == "manord") {
    // top nav child bar
    $("#topNavManageforum").addClass("active");

    manageforumTable = $("#manageforumTable").DataTable({
      ajax: "php_action/fetchforum.php",
      forum: [],
    });
  } else if (divRequest == "editOrd") {
    $("#forumDate").datepicker();

    // edit forum form function
    $("#editforumForm")
      .unbind("submit")
      .bind("submit", function () {
        // alert('ok');
        var form = $(this);

        $(".form-group").removeClass("has-error").removeClass("has-success");
        $(".text-danger").remove();

        var forumDate = $("#forumDate").val();
        var clientName = $("#clientName").val();
        var clientContact = $("#clientContact").val();
        var paid = $("#paid").val();
        var discount = $("#discount").val();
        var paymentType = $("#paymentType").val();
        var paymentStatus = $("#paymentStatus").val();

        // form validation
        if (forumDate == "") {
          $("#forumDate").after(
            '<p class="text-danger"> The forum Date field is required </p>'
          );
          $("#forumDate").closest(".form-group").addClass("has-error");
        } else {
          $("#forumDate").closest(".form-group").addClass("has-success");
        } // /else

        if (clientName == "") {
          $("#clientName").after(
            '<p class="text-danger"> The Client Name field is required </p>'
          );
          $("#clientName").closest(".form-group").addClass("has-error");
        } else {
          $("#clientName").closest(".form-group").addClass("has-success");
        } // /else

        if (clientContact == "") {
          $("#clientContact").after(
            '<p class="text-danger"> The Contact field is required </p>'
          );
          $("#clientContact").closest(".form-group").addClass("has-error");
        } else {
          $("#clientContact").closest(".form-group").addClass("has-success");
        } // /else

        if (paid == "") {
          $("#paid").after(
            '<p class="text-danger"> The Paid field is required </p>'
          );
          $("#paid").closest(".form-group").addClass("has-error");
        } else {
          $("#paid").closest(".form-group").addClass("has-success");
        } // /else

        if (discount == "") {
          $("#discount").after(
            '<p class="text-danger"> The Discount field is required </p>'
          );
          $("#discount").closest(".form-group").addClass("has-error");
        } else {
          $("#discount").closest(".form-group").addClass("has-success");
        } // /else

        if (paymentType == "") {
          $("#paymentType").after(
            '<p class="text-danger"> The Payment Type field is required </p>'
          );
          $("#paymentType").closest(".form-group").addClass("has-error");
        } else {
          $("#paymentType").closest(".form-group").addClass("has-success");
        } // /else

        if (paymentStatus == "") {
          $("#paymentStatus").after(
            '<p class="text-danger"> The Payment Status field is required </p>'
          );
          $("#paymentStatus").closest(".form-group").addClass("has-error");
        } else {
          $("#paymentStatus").closest(".form-group").addClass("has-success");
        } // /else

        // array validation
        var CourseName = document.getElementsByName("CourseName[]");
        var validateCourse;
        for (var x = 0; x < CourseName.length; x++) {
          var CourseNameId = CourseName[x].id;
          if (CourseName[x].value == "") {
            $("#" + CourseNameId + "").after(
              '<p class="text-danger"> Course Name Field is required!! </p>'
            );
            $("#" + CourseNameId + "")
              .closest(".form-group")
              .addClass("has-error");
          } else {
            $("#" + CourseNameId + "")
              .closest(".form-group")
              .addClass("has-success");
          }
        } // for

        for (var x = 0; x < CourseName.length; x++) {
          if (CourseName[x].value) {
            validateCourse = true;
          } else {
            validateCourse = false;
          }
        } // for

        var quantity = document.getElementsByName("quantity[]");
        var validateQuantity;
        for (var x = 0; x < quantity.length; x++) {
          var quantityId = quantity[x].id;
          if (quantity[x].value == "") {
            $("#" + quantityId + "").after(
              '<p class="text-danger"> Course Name Field is required!! </p>'
            );
            $("#" + quantityId + "")
              .closest(".form-group")
              .addClass("has-error");
          } else {
            $("#" + quantityId + "")
              .closest(".form-group")
              .addClass("has-success");
          }
        } // for

        for (var x = 0; x < quantity.length; x++) {
          if (quantity[x].value) {
            validateQuantity = true;
          } else {
            validateQuantity = false;
          }
        } // for

        if (
          forumDate &&
          clientName &&
          clientContact &&
          paid &&
          discount &&
          paymentType &&
          paymentStatus
        ) {
          if (validateCourse == true && validateQuantity == true) {
            // create forum button
            // $("#createforumBtn").button('loading');

            $.ajax({
              url: form.attr("action"),
              type: form.attr("method"),
              data: form.serialize(),
              dataType: "json",
              success: function (response) {
                console.log(response);
                // reset button
                $("#editforumBtn").button("reset");

                $(".text-danger").remove();
                $(".form-group")
                  .removeClass("has-error")
                  .removeClass("has-success");

                if (response.success == true) {
                  // create forum button
                  $(".success-messages").html(
                    '<div class="alert alert-success">' +
                      '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                      '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' +
                      response.messages +
                      "</div>"
                  );

                  $("html, body, div.panel, div.pane-body").animate(
                    { scrollTop: "0px" },
                    100
                  );

                  // disabled te modal footer button
                  $(".editButtonFooter").addClass("div-hide");
                  // remove the Course row
                  $(".removeCourseRowBtn").addClass("div-hide");
                } else {
                  alert(response.messages);
                }
              }, // /response
            }); // /ajax
          } // if array validate is true
        } // /if field validate is true

        return false;
      }); // /edit forum form function
  }
}); // /documernt

// print forum function
function printforum(forumId = null) {
  if (forumId) {
    $.ajax({
      url: "php_action/printforum.php",
      type: "post",
      data: { forumId: forumId },
      dataType: "text",
      success: function (response) {
        var mywindow = window.open(
          "",
          "Stock Management System",
          "height=400,width=600"
        );
        mywindow.document.write("<html><head><title>forum Invoice</title>");
        mywindow.document.write("</head><body>");
        mywindow.document.write(response);
        mywindow.document.write("</body></html>");

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.resizeTo(screen.width, screen.height);
        setTimeout(function () {
          mywindow.print();
          mywindow.close();
        }, 1250);

        //mywindow.print();
        //mywindow.close();
      }, // /success function
    }); // /ajax function to fetch the printable forum
  } // /if forumId
} // /print forum function

function addRow() {
  $("#addRowBtn").button("loading");

  var tableLength = $("#CourseTable tbody tr").length;

  var tableRow;
  var arrayNumber;
  var count;

  if (tableLength > 0) {
    tableRow = $("#CourseTable tbody tr:last").attr("id");
    arrayNumber = $("#CourseTable tbody tr:last").attr("class");
    count = tableRow.substring(3);
    count = Number(count) + 1;
    arrayNumber = Number(arrayNumber) + 1;
  } else {
    // no table row
    count = 1;
    arrayNumber = 0;
  }

  $.ajax({
    url: "php_action/fetchCourseData.php",
    type: "post",
    dataType: "json",
    success: function (response) {
      $("#addRowBtn").button("reset");

      var tr =
        '<tr id="row' +
        count +
        '" class="' +
        arrayNumber +
        '">' +
        "<td>" +
        '<div class="form-group">' +
        '<select class="form-control" name="CourseName[]" id="CourseName' +
        count +
        '" onchange="getCourseData(' +
        count +
        ')" >' +
        '<option value="">~~SELECT~~</option>';
      // console.log(response);
      $.each(response, function (index, value) {
        tr += '<option value="' + value[0] + '">' + value[1] + "</option>";
      });

      tr +=
        "</select>" +
        "</div>" +
        "</td>" +
        '<td style="padding-left:20px;"">' +
        '<input type="text" name="rate[]" id="rate' +
        count +
        '" autocomplete="off" disabled="true" class="form-control" />' +
        '<input type="hidden" name="rateValue[]" id="rateValue' +
        count +
        '" autocomplete="off" class="form-control" />' +
        '</td style="padding-left:20px;">' +
        '<td style="padding-left:20px;">' +
        '<div class="form-group">' +
        '<p id="available_quantity' +
        count +
        '"></p>' +
        "</div>" +
        "</td>" +
        '<td style="padding-left:20px;">' +
        '<div class="form-group">' +
        '<input type="number" name="quantity[]" id="quantity' +
        count +
        '" onkeyup="getTotal(' +
        count +
        ')" autocomplete="off" class="form-control" min="1" />' +
        "</div>" +
        "</td>" +
        '<td style="padding-left:20px;">' +
        '<input type="text" name="total[]" id="total' +
        count +
        '" autocomplete="off" class="form-control" disabled="true" />' +
        '<input type="hidden" name="totalValue[]" id="totalValue' +
        count +
        '" autocomplete="off" class="form-control" />' +
        "</td>" +
        "<td>" +
        '<button class="btn btn-default removeCourseRowBtn" type="button" onclick="removeCourseRow(' +
        count +
        ')"><i class="glyphicon glyphicon-trash"></i></button>' +
        "</td>" +
        "</tr>";
      if (tableLength > 0) {
        $("#CourseTable tbody tr:last").after(tr);
      } else {
        $("#CourseTable tbody").append(tr);
      }
    }, // /success
  }); // get the Course data
} // /add row

function removeCourseRow(row = null) {
  if (row) {
    $("#row" + row).remove();

    subAmount();
  } else {
    alert("error! Refresh the page again");
  }
}

// select on Course data
function getCourseData(row = null) {
  if (row) {
    var CourseId = $("#CourseName" + row).val();

    if (CourseId == "") {
      $("#rate" + row).val("");

      $("#quantity" + row).val("");
      $("#total" + row).val("");

      // remove check if Course name is selected
      // var tableCourseLength = $("#CourseTable tbody tr").length;
      // for(x = 0; x < tableCourseLength; x++) {
      // 	var tr = $("#CourseTable tbody tr")[x];
      // 	var count = $(tr).attr('id');
      // 	count = count.substring(3);

      // 	var CourseValue = $("#CourseName"+row).val()

      // 	if($("#CourseName"+count).val() == "") {
      // 		$("#CourseName"+count).find("#changeCourse"+CourseId).removeClass('div-hide');
      // 		console.log("#changeCourse"+count);
      // 	}
      // } // /for
    } else {
      $.ajax({
        url: "php_action/fetchSelectedCourse.php",
        type: "post",
        data: { CourseId: CourseId },
        dataType: "json",
        success: function (response) {
          // setting the rate value into the rate input field

          $("#rate" + row).val(response.rate);
          $("#rateValue" + row).val(response.rate);

          $("#quantity" + row).val(1);
          $("#available_quantity" + row).text(response.quantity);

          var total = Number(response.rate) * 1;
          total = total.toFixed(2);
          $("#total" + row).val(total);
          $("#totalValue" + row).val(total);

          // check if Course name is selected
          // var tableCourseLength = $("#CourseTable tbody tr").length;
          // for(x = 0; x < tableCourseLength; x++) {
          // 	var tr = $("#CourseTable tbody tr")[x];
          // 	var count = $(tr).attr('id');
          // 	count = count.substring(3);

          // 	var CourseValue = $("#CourseName"+row).val()

          // 	if($("#CourseName"+count).val() != CourseValue) {
          // 		// $("#CourseName"+count+" #changeCourse"+count).addClass('div-hide');
          // 		$("#CourseName"+count).find("#changeCourse"+CourseId).addClass('div-hide');
          // 		console.log("#changeCourse"+count);
          // 	}
          // } // /for

          subAmount();
        }, // /success
      }); // /ajax function to fetch the Course data
    }
  } else {
    alert("no row! please refresh the page");
  }
} // /select on Course data

// table total
function getTotal(row = null) {
  if (row) {
    var total =
      Number($("#rate" + row).val()) * Number($("#quantity" + row).val());
    total = total.toFixed(2);
    $("#total" + row).val(total);
    $("#totalValue" + row).val(total);

    subAmount();
  } else {
    alert("no row !! please refresh the page");
  }
}

function subAmount() {
  var tableCourseLength = $("#CourseTable tbody tr").length;
  var totalSubAmount = 0;
  for (x = 0; x < tableCourseLength; x++) {
    var tr = $("#CourseTable tbody tr")[x];
    var count = $(tr).attr("id");
    count = count.substring(3);

    totalSubAmount = Number(totalSubAmount) + Number($("#total" + count).val());
  } // /for

  totalSubAmount = totalSubAmount.toFixed(2);

  // sub total
  $("#subTotal").val(totalSubAmount);
  $("#subTotalValue").val(totalSubAmount);

  // vat
  var vat = (Number($("#subTotal").val()) / 100) * 18;
  vat = vat.toFixed(2);
  $("#vat").val(vat);
  $("#vatValue").val(vat);

  // total amount
  var totalAmount = Number($("#subTotal").val()) + Number($("#vat").val());
  totalAmount = totalAmount.toFixed(2);
  $("#totalAmount").val(totalAmount);
  $("#totalAmountValue").val(totalAmount);

  var discount = $("#discount").val();
  if (discount) {
    var grandTotal = Number($("#totalAmount").val()) - Number(discount);
    grandTotal = grandTotal.toFixed(2);
    $("#grandTotal").val(grandTotal);
    $("#grandTotalValue").val(grandTotal);
  } else {
    $("#grandTotal").val(totalAmount);
    $("#grandTotalValue").val(totalAmount);
  } // /else discount

  var paidAmount = $("#paid").val();
  if (paidAmount) {
    paidAmount = Number($("#grandTotal").val()) - Number(paidAmount);
    paidAmount = paidAmount.toFixed(2);
    $("#due").val(paidAmount);
    $("#dueValue").val(paidAmount);
  } else {
    $("#due").val($("#grandTotal").val());
    $("#dueValue").val($("#grandTotal").val());
  } // else
} // /sub total amount

function discountFunc() {
  var discount = $("#discount").val();
  var totalAmount = Number($("#totalAmount").val());
  totalAmount = totalAmount.toFixed(2);

  var grandTotal;
  if (totalAmount) {
    grandTotal = Number($("#totalAmount").val()) - Number($("#discount").val());
    grandTotal = grandTotal.toFixed(2);

    $("#grandTotal").val(grandTotal);
    $("#grandTotalValue").val(grandTotal);
  } else {
  }

  var paid = $("#paid").val();

  var dueAmount;
  if (paid) {
    dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
    dueAmount = dueAmount.toFixed(2);

    $("#due").val(dueAmount);
    $("#dueValue").val(dueAmount);
  } else {
    $("#due").val($("#grandTotal").val());
    $("#dueValue").val($("#grandTotal").val());
  }
} // /discount function

function paidAmount() {
  var grandTotal = $("#grandTotal").val();

  if (grandTotal) {
    var dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
    dueAmount = dueAmount.toFixed(2);
    $("#due").val(dueAmount);
    $("#dueValue").val(dueAmount);
  } // /if
} // /paid amoutn function

function resetforumForm() {
  // reset the input field
  $("#createforumForm")[0].reset();
  // remove remove text danger
  $(".text-danger").remove();
  // remove form group error
  $(".form-group").removeClass("has-success").removeClass("has-error");
} // /reset forum form

// remove forum from server
function removeforum(forumId = null) {
  if (forumId) {
    $("#removeforumBtn")
      .unbind("click")
      .bind("click", function () {
        $("#removeforumBtn").button("loading");

        $.ajax({
          url: "php_action/removeforum.php",
          type: "post",
          data: { forumId: forumId },
          dataType: "json",
          success: function (response) {
            $("#removeforumBtn").button("reset");

            if (response.success == true) {
              manageforumTable.ajax.reload(null, false);
              // hide modal
              $("#removeforumModal").modal("hide");
              // success messages
              $("#success-messages").html(
                '<div class="alert alert-success">' +
                  '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' +
                  response.messages +
                  "</div>"
              );

              // remove the mesages
              $(".alert-success")
                .delay(500)
                .show(10, function () {
                  $(this)
                    .delay(3000)
                    .hide(10, function () {
                      $(this).remove();
                    });
                }); // /.alert
            } else {
              // error messages
              $(".removeforumMessages").html(
                '<div class="alert alert-warning">' +
                  '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' +
                  response.messages +
                  "</div>"
              );

              // remove the mesages
              $(".alert-success")
                .delay(500)
                .show(10, function () {
                  $(this)
                    .delay(3000)
                    .hide(10, function () {
                      $(this).remove();
                    });
                }); // /.alert
            } // /else
          }, // /success
        }); // /ajax function to remove the forum
      }); // /remove forum button clicked
  } else {
    alert("error! refresh the page again");
  }
}
// /remove forum from server

// Payment forum
function paymentforum(forumId = null) {
  if (forumId) {
    $("#forumDate").datepicker();

    $.ajax({
      url: "php_action/fetchforumData.php",
      type: "post",
      data: { forumId: forumId },
      dataType: "json",
      success: function (response) {
        // due
        $("#due").val(response.forum[10]);

        // pay amount
        $("#payAmount").val(response.forum[10]);

        var paidAmount = response.forum[9];
        var dueAmount = response.forum[10];
        var grandTotal = response.forum[8];

        // update payment
        $("#updatePaymentforumBtn")
          .unbind("click")
          .bind("click", function () {
            var payAmount = $("#payAmount").val();
            var paymentType = $("#paymentType").val();
            var paymentStatus = $("#paymentStatus").val();

            if (payAmount == "") {
              $("#payAmount").after(
                '<p class="text-danger">The Pay Amount field is required</p>'
              );
              $("#payAmount").closest(".form-group").addClass("has-error");
            } else {
              $("#payAmount").closest(".form-group").addClass("has-success");
            }

            if (paymentType == "") {
              $("#paymentType").after(
                '<p class="text-danger">The Pay Amount field is required</p>'
              );
              $("#paymentType").closest(".form-group").addClass("has-error");
            } else {
              $("#paymentType").closest(".form-group").addClass("has-success");
            }

            if (paymentStatus == "") {
              $("#paymentStatus").after(
                '<p class="text-danger">The Pay Amount field is required</p>'
              );
              $("#paymentStatus").closest(".form-group").addClass("has-error");
            } else {
              $("#paymentStatus")
                .closest(".form-group")
                .addClass("has-success");
            }

            if (payAmount && paymentType && paymentStatus) {
              $("#updatePaymentforumBtn").button("loading");
              $.ajax({
                url: "php_action/editPayment.php",
                type: "post",
                data: {
                  forumId: forumId,
                  payAmount: payAmount,
                  paymentType: paymentType,
                  paymentStatus: paymentStatus,
                  paidAmount: paidAmount,
                  grandTotal: grandTotal,
                },
                dataType: "json",
                success: function (response) {
                  $("#updatePaymentforumBtn").button("loading");

                  // remove error
                  $(".text-danger").remove();
                  $(".form-group")
                    .removeClass("has-error")
                    .removeClass("has-success");

                  $("#paymentforumModal").modal("hide");

                  $("#success-messages").html(
                    '<div class="alert alert-success">' +
                      '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                      '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' +
                      response.messages +
                      "</div>"
                  );

                  // remove the mesages
                  $(".alert-success")
                    .delay(500)
                    .show(10, function () {
                      $(this)
                        .delay(3000)
                        .hide(10, function () {
                          $(this).remove();
                        });
                    }); // /.alert

                  // refresh the manage forum table
                  manageforumTable.ajax.reload(null, false);
                }, //
              });
            } // /if

            return false;
          }); // /update payment
      }, // /success
    }); // fetch forum data
  } else {
    alert("Error ! Refresh the page again");
  }
}
