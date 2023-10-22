var manageUniversityTable;

$(document).ready(function () {
  // top bar active
  $("#navUniversity").addClass("active");

  // manage University table
  manageUniversityTable = $("#manageUniversityTable").DataTable({
    ajax: "php_action/fetchUniversity.php",
    forum: [],
  });

  // submit University form function
  $("#submitUniversityForm")
    .unbind("submit")
    .bind("submit", function () {
      // remove the error text
      $(".text-danger").remove();
      // remove the form error
      $(".form-group").removeClass("has-error").removeClass("has-success");

      var UniversityName = $("#UniversityName").val();
      var UniversityStatus = $("#UniversityStatus").val();

      if (UniversityName == "") {
        $("#UniversityName").after(
          '<p class="text-danger">University Name field is required</p>'
        );
        $("#UniversityName").closest(".form-group").addClass("has-error");
      } else {
        // remov error text field
        $("#UniversityName").find(".text-danger").remove();
        // success out for form
        $("#UniversityName").closest(".form-group").addClass("has-success");
      }

      if (UniversityStatus == "") {
        $("#UniversityStatus").after(
          '<p class="text-danger">University Name field is required</p>'
        );

        $("#UniversityStatus").closest(".form-group").addClass("has-error");
      } else {
        // remov error text field
        $("#UniversityStatus").find(".text-danger").remove();
        // success out for form
        $("#UniversityStatus").closest(".form-group").addClass("has-success");
      }

      if (UniversityName && UniversityStatus) {
        var form = $(this);
        // button loading
        $("#createUniversityBtn").button("loading");

        $.ajax({
          url: form.attr("action"),
          type: form.attr("method"),
          data: form.serialize(),
          dataType: "json",
          success: function (response) {
            // button loading
            $("#createUniversityBtn").button("reset");

            if (response.success == true) {
              // reload the manage member table
              manageUniversityTable.ajax.reload(null, false);

              // reset the form text
              $("#submitUniversityForm")[0].reset();
              // remove the error text
              $(".text-danger").remove();
              // remove the form error
              $(".form-group")
                .removeClass("has-error")
                .removeClass("has-success");

              $("#add-University-messages").html(
                '<div class="alert alert-success">' +
                  '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                  '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' +
                  response.messages +
                  "</div>"
              );

              $(".alert-success")
                .delay(500)
                .show(10, function () {
                  $(this)
                    .delay(3000)
                    .hide(10, function () {
                      $(this).remove();
                    });
                }); // /.alert
            } // if
          }, // /success
        }); // /ajax
      } // if

      return false;
    }); // /submit University form function
});

function editUniversitys(UniversityId = null) {
  if (UniversityId) {
    // remove hidden University id text
    $("#UniversityId").remove();

    // remove the error
    $(".text-danger").remove();
    // remove the form-error
    $(".form-group").removeClass("has-error").removeClass("has-success");

    // modal loading
    $(".modal-loading").removeClass("div-hide");
    // modal result
    $(".edit-University-result").addClass("div-hide");
    // modal footer
    $(".editUniversityFooter").addClass("div-hide");

    $.ajax({
      url: "php_action/fetchSelectedUniversity.php",
      type: "post",
      data: { UniversityId: UniversityId },
      dataType: "json",
      success: function (response) {
        // modal loading
        $(".modal-loading").addClass("div-hide");
        // modal result
        $(".edit-University-result").removeClass("div-hide");
        // modal footer
        $(".editUniversityFooter").removeClass("div-hide");

        // setting the University name value
        $("#editUniversityName").val(response.University_name);
        // setting the University status value
        $("#editUniversityStatus").val(response.University_active);
        // University id
        $(".editUniversityFooter").after(
          '<input type="hidden" name="UniversityId" id="UniversityId" value="' +
            response.University_id +
            '" />'
        );

        // update University form
        $("#editUniversityForm")
          .unbind("submit")
          .bind("submit", function () {
            // remove the error text
            $(".text-danger").remove();
            // remove the form error
            $(".form-group")
              .removeClass("has-error")
              .removeClass("has-success");

            var UniversityName = $("#editUniversityName").val();
            var UniversityStatus = $("#editUniversityStatus").val();

            if (UniversityName == "") {
              $("#editUniversityName").after(
                '<p class="text-danger">University Name field is required</p>'
              );
              $("#editUniversityName")
                .closest(".form-group")
                .addClass("has-error");
            } else {
              // remov error text field
              $("#editUniversityName").find(".text-danger").remove();
              // success out for form
              $("#editUniversityName")
                .closest(".form-group")
                .addClass("has-success");
            }

            if (UniversityStatus == "") {
              $("#editUniversityStatus").after(
                '<p class="text-danger">University Name field is required</p>'
              );

              $("#editUniversityStatus")
                .closest(".form-group")
                .addClass("has-error");
            } else {
              // remove error text field
              $("#editUniversityStatus").find(".text-danger").remove();
              // success out for form
              $("#editUniversityStatus")
                .closest(".form-group")
                .addClass("has-success");
            }

            if (UniversityName && UniversityStatus) {
              var form = $(this);

              // submit btn
              $("#editUniversityBtn").button("loading");

              $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: form.serialize(),
                dataType: "json",
                success: function (response) {
                  if (response.success == true) {
                    console.log(response);
                    // submit btn
                    $("#editUniversityBtn").button("reset");

                    // reload the manage member table
                    manageUniversityTable.ajax.reload(null, false);
                    // remove the error text
                    $(".text-danger").remove();
                    // remove the form error
                    $(".form-group")
                      .removeClass("has-error")
                      .removeClass("has-success");

                    $("#edit-University-messages").html(
                      '<div class="alert alert-success">' +
                        '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' +
                        response.messages +
                        "</div>"
                    );

                    $(".alert-success")
                      .delay(500)
                      .show(10, function () {
                        $(this)
                          .delay(3000)
                          .hide(10, function () {
                            $(this).remove();
                          });
                      }); // /.alert
                  } // /if
                }, // /success
              }); // /ajax
            } // /if

            return false;
          }); // /update University form
      }, // /success
    }); // ajax function
  } else {
    alert("error!! Refresh the page again");
  }
} // /edit university function

function removeUniversitys(UniversityId = null) {
  if (UniversityId) {
    $("#removeUniversityId").remove();
    $.ajax({
      url: "php_action/fetchSelectedUniversity.php",
      type: "post",
      data: { UniversityId: UniversityId },
      dataType: "json",
      success: function (response) {
        $(".removeUniversityFooter").after(
          '<input type="hidden" name="removeUniversityId" id="removeUniversityId" value="' +
            response.University_id +
            '" /> '
        );

        // click on remove button to remove the University
        $("#removeUniversityBtn")
          .unbind("click")
          .bind("click", function () {
            // button loading
            $("#removeUniversityBtn").button("loading");

            $.ajax({
              url: "php_action/removeUniversity.php",
              type: "post",
              data: { UniversityId: UniversityId },
              dataType: "json",
              success: function (response) {
                console.log(response);
                // button loading
                $("#removeUniversityBtn").button("reset");
                if (response.success == true) {
                  // hide the remove modal
                  $("#removeMemberModal").modal("hide");

                  // reload the University table
                  manageUniversityTable.ajax.reload(null, false);

                  $(".remove-messages").html(
                    '<div class="alert alert-success">' +
                      '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                      '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' +
                      response.messages +
                      "</div>"
                  );

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
                } // /else
              }, // /response messages
            }); // /ajax function to remove the University
          }); // /click on remove button to remove the University
      }, // /success
    }); // /ajax

    $(".removeUniversityFooter").after();
  } else {
    alert("error!! Refresh the page again");
  }
} // /remove university function
