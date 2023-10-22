var manageCourseTable;

$(document).ready(function () {
  // top nav bar
  $("#navCourse").addClass("active");
  // manage Course data table
  manageCourseTable = $("#manageCourseTable").DataTable({
    ajax: "php_action/fetchCourse.php",
    forum: [],
  });

  // add Course modal btn clicked
  $("#addCourseModalBtn")
    .unbind("click")
    .bind("click", function () {
      // // Course form reset
      $("#submitCourseForm")[0].reset();

      // remove text-error
      $(".text-danger").remove();
      // remove from-group error
      $(".form-group").removeClass("has-error").removeClass("has-success");

      $("#CourseImage").fileinput({
        overwriteInitial: true,
        maxFileSize: 2500,
        showClose: false,
        showCaption: false,
        browseLabel: "",
        removeLabel: "",
        browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: "Cancel or reset changes",
        elErrorContainer: "#kv-avatar-errors-1",
        msgErrorClass: "alert alert-block alert-danger",
        defaultPreviewContent:
          '<img src="assests/images/photo_default.png" alt="Profile Image" style="width:100%;">',
        layoutTemplates: { main2: "{preview} {remove} {browse}" },
        allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"],
      });

      // submit Course form
      $("#submitCourseForm")
        .unbind("submit")
        .bind("submit", function () {
          // form validation
          var CourseImage = $("#CourseImage").val();
          var CourseName = $("#CourseName").val();
          var quantity = $("#quantity").val();
          var rate = $("#rate").val();
          var UniversityName = $("#UniversityName").val();
          var categoryName = $("#categoryName").val();
          var CourseStatus = $("#CourseStatus").val();

          if (CourseImage == "") {
            $("#CourseImage")
              .closest(".center-block")
              .after(
                '<p class="text-danger">Course Image field is required</p>'
              );
            $("#CourseImage").closest(".form-group").addClass("has-error");
          } else {
            // remov error text field
            $("#CourseImage").find(".text-danger").remove();
            // success out for form
            $("#CourseImage").closest(".form-group").addClass("has-success");
          } // /else

          if (CourseName == "") {
            $("#CourseName").after(
              '<p class="text-danger">Course Name field is required</p>'
            );
            $("#CourseName").closest(".form-group").addClass("has-error");
          } else {
            // remov error text field
            $("#CourseName").find(".text-danger").remove();
            // success out for form
            $("#CourseName").closest(".form-group").addClass("has-success");
          } // /else

          if (quantity == "") {
            $("#quantity").after(
              '<p class="text-danger">Quantity field is required</p>'
            );
            $("#quantity").closest(".form-group").addClass("has-error");
          } else {
            // remov error text field
            $("#quantity").find(".text-danger").remove();
            // success out for form
            $("#quantity").closest(".form-group").addClass("has-success");
          } // /else

          if (rate == "") {
            $("#rate").after(
              '<p class="text-danger">Rate field is required</p>'
            );
            $("#rate").closest(".form-group").addClass("has-error");
          } else {
            // remov error text field
            $("#rate").find(".text-danger").remove();
            // success out for form
            $("#rate").closest(".form-group").addClass("has-success");
          } // /else

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
          } // /else

          if (categoryName == "") {
            $("#categoryName").after(
              '<p class="text-danger">Category Name field is required</p>'
            );
            $("#categoryName").closest(".form-group").addClass("has-error");
          } else {
            // remov error text field
            $("#categoryName").find(".text-danger").remove();
            // success out for form
            $("#categoryName").closest(".form-group").addClass("has-success");
          } // /else

          if (CourseStatus == "") {
            $("#CourseStatus").after(
              '<p class="text-danger">Course Status field is required</p>'
            );
            $("#CourseStatus").closest(".form-group").addClass("has-error");
          } else {
            // remov error text field
            $("#CourseStatus").find(".text-danger").remove();
            // success out for form
            $("#CourseStatus").closest(".form-group").addClass("has-success");
          } // /else

          if (
            CourseImage &&
            CourseName &&
            quantity &&
            rate &&
            UniversityName &&
            categoryName &&
            CourseStatus
          ) {
            // submit loading button
            $("#createCourseBtn").button("loading");

            var form = $(this);
            var formData = new FormData(this);

            $.ajax({
              url: form.attr("action"),
              type: form.attr("method"),
              data: formData,
              dataType: "json",
              cache: false,
              contentType: false,
              processData: false,
              success: function (response) {
                if (response.success == true) {
                  // submit loading button
                  $("#createCourseBtn").button("reset");

                  $("#submitCourseForm")[0].reset();

                  $(
                    "html, body, div.modal, div.modal-content, div.modal-body"
                  ).animate({ scrollTop: "0" }, 100);

                  // shows a successful message after operation
                  $("#add-Course-messages").html(
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

                  // reload the manage student table
                  manageCourseTable.ajax.reload(null, true);

                  // remove text-error
                  $(".text-danger").remove();
                  // remove from-group error
                  $(".form-group")
                    .removeClass("has-error")
                    .removeClass("has-success");
                } // /if response.success
              }, // /success function
            }); // /ajax function
          } // /if validation is ok

          return false;
        }); // /submit Course form
    }); // /add Course modal btn clicked

  // remove Course
}); // document.ready fucntion

function editCourse(CourseId = null) {
  if (CourseId) {
    $("#CourseId").remove();
    // remove text-error
    $(".text-danger").remove();
    // remove from-group error
    $(".form-group").removeClass("has-error").removeClass("has-success");
    // modal spinner
    $(".div-loading").removeClass("div-hide");
    // modal div
    $(".div-result").addClass("div-hide");

    $.ajax({
      url: "php_action/fetchSelectedCourse.php",
      type: "post",
      data: { CourseId: CourseId },
      dataType: "json",
      success: function (response) {
        // alert(response.Course_image);
        // modal spinner
        $(".div-loading").addClass("div-hide");
        // modal div
        $(".div-result").removeClass("div-hide");

        $("#getCourseImage").attr("src", "stock/" + response.Course_image);

        $("#editCourseImage").fileinput({});

        // $("#editCourseImage").fileinput({
        //     overwriteInitial: true,
        //    maxFileSize: 2500,
        //    showClose: false,
        //    showCaption: false,
        //    browseLabel: '',
        //    removeLabel: '',
        //    browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
        //    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        //    removeTitle: 'Cancel or reset changes',
        //    elErrorContainer: '#kv-avatar-errors-1',
        //    msgErrorClass: 'alert alert-block alert-danger',
        //    defaultPreviewContent: '<img src="stock/'+response.Course_image+'" alt="Profile Image" style="width:100%;">',
        //    layoutTemplates: {main2: '{preview} {remove} {browse}'},
        // 		allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
        // });

        // Course id
        $(".editCourseFooter").append(
          '<input type="hidden" name="CourseId" id="CourseId" value="' +
            response.Course_id +
            '" />'
        );
        $(".editCoursePhotoFooter").append(
          '<input type="hidden" name="CourseId" id="CourseId" value="' +
            response.Course_id +
            '" />'
        );

        // Course name
        $("#editCourseName").val(response.Course_name);
        // quantity
        $("#editQuantity").val(response.quantity);
        // rate
        $("#editRate").val(response.rate);
        // University name
        $("#editUniversityName").val(response.University_id);
        // category name
        $("#editCategoryName").val(response.categories_id);
        // status
        $("#editCourseStatus").val(response.active);

        // update the Course data function
        $("#editCourseForm")
          .unbind("submit")
          .bind("submit", function () {
            // form validation
            var CourseImage = $("#editCourseImage").val();
            var CourseName = $("#editCourseName").val();
            var quantity = $("#editQuantity").val();
            var rate = $("#editRate").val();
            var UniversityName = $("#editUniversityName").val();
            var categoryName = $("#editCategoryName").val();
            var CourseStatus = $("#editCourseStatus").val();

            if (CourseName == "") {
              $("#editCourseName").after(
                '<p class="text-danger">Course Name field is required</p>'
              );
              $("#editCourseName").closest(".form-group").addClass("has-error");
            } else {
              // remov error text field
              $("#editCourseName").find(".text-danger").remove();
              // success out for form
              $("#editCourseName")
                .closest(".form-group")
                .addClass("has-success");
            } // /else

            if (quantity == "") {
              $("#editQuantity").after(
                '<p class="text-danger">Quantity field is required</p>'
              );
              $("#editQuantity").closest(".form-group").addClass("has-error");
            } else {
              // remov error text field
              $("#editQuantity").find(".text-danger").remove();
              // success out for form
              $("#editQuantity").closest(".form-group").addClass("has-success");
            } // /else

            if (rate == "") {
              $("#editRate").after(
                '<p class="text-danger">Rate field is required</p>'
              );
              $("#editRate").closest(".form-group").addClass("has-error");
            } else {
              // remov error text field
              $("#editRate").find(".text-danger").remove();
              // success out for form
              $("#editRate").closest(".form-group").addClass("has-success");
            } // /else

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
            } // /else

            if (categoryName == "") {
              $("#editCategoryName").after(
                '<p class="text-danger">Category Name field is required</p>'
              );
              $("#editCategoryName")
                .closest(".form-group")
                .addClass("has-error");
            } else {
              // remov error text field
              $("#editCategoryName").find(".text-danger").remove();
              // success out for form
              $("#editCategoryName")
                .closest(".form-group")
                .addClass("has-success");
            } // /else

            if (CourseStatus == "") {
              $("#editCourseStatus").after(
                '<p class="text-danger">Course Status field is required</p>'
              );
              $("#editCourseStatus")
                .closest(".form-group")
                .addClass("has-error");
            } else {
              // remov error text field
              $("#editCourseStatus").find(".text-danger").remove();
              // success out for form
              $("#editCourseStatus")
                .closest(".form-group")
                .addClass("has-success");
            } // /else

            if (
              CourseName &&
              quantity &&
              rate &&
              UniversityName &&
              categoryName &&
              CourseStatus
            ) {
              // submit loading button
              $("#editCourseBtn").button("loading");

              var form = $(this);
              var formData = new FormData(this);

              $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                  console.log(response);
                  if (response.success == true) {
                    // submit loading button
                    $("#editCourseBtn").button("reset");

                    $(
                      "html, body, div.modal, div.modal-content, div.modal-body"
                    ).animate({ scrollTop: "0" }, 100);

                    // shows a successful message after operation
                    $("#edit-Course-messages").html(
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

                    // reload the manage student table
                    manageCourseTable.ajax.reload(null, true);

                    // remove text-error
                    $(".text-danger").remove();
                    // remove from-group error
                    $(".form-group")
                      .removeClass("has-error")
                      .removeClass("has-success");
                  } // /if response.success
                }, // /success function
              }); // /ajax function
            } // /if validation is ok

            return false;
          }); // update the Course data function

        // update the Course image
        $("#updateCourseImageForm")
          .unbind("submit")
          .bind("submit", function () {
            // form validation
            var CourseImage = $("#editCourseImage").val();

            if (CourseImage == "") {
              $("#editCourseImage")
                .closest(".center-block")
                .after(
                  '<p class="text-danger">Course Image field is required</p>'
                );
              $("#editCourseImage")
                .closest(".form-group")
                .addClass("has-error");
            } else {
              // remov error text field
              $("#editCourseImage").find(".text-danger").remove();
              // success out for form
              $("#editCourseImage")
                .closest(".form-group")
                .addClass("has-success");
            } // /else

            if (CourseImage) {
              // submit loading button
              $("#editCourseImageBtn").button("loading");

              var form = $(this);
              var formData = new FormData(this);

              $.ajax({
                url: form.attr("action"),
                type: form.attr("method"),
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                  if (response.success == true) {
                    // submit loading button
                    $("#editCourseImageBtn").button("reset");

                    $(
                      "html, body, div.modal, div.modal-content, div.modal-body"
                    ).animate({ scrollTop: "0" }, 100);

                    // shows a successful message after operation
                    $("#edit-CoursePhoto-messages").html(
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

                    // reload the manage student table
                    manageCourseTable.ajax.reload(null, true);

                    $(".fileinput-remove-button").click();

                    $.ajax({
                      url: "php_action/fetchCourseImageUrl.php?i=" + CourseId,
                      type: "post",
                      success: function (response) {
                        $("#getCourseImage").attr("src", response);
                      },
                    });

                    // remove text-error
                    $(".text-danger").remove();
                    // remove from-group error
                    $(".form-group")
                      .removeClass("has-error")
                      .removeClass("has-success");
                  } // /if response.success
                }, // /success function
              }); // /ajax function
            } // /if validation is ok

            return false;
          }); // /update the Course image
      }, // /success function
    }); // /ajax to fetch Course image
  } else {
    alert("error please refresh the page");
  }
} // /edit Course function

// remove Course
function removeCourse(CourseId = null) {
  if (CourseId) {
    // remove Course button clicked
    $("#removeCourseBtn")
      .unbind("click")
      .bind("click", function () {
        // loading remove button
        $("#removeCourseBtn").button("loading");
        $.ajax({
          url: "php_action/removeCourse.php",
          type: "post",
          data: { CourseId: CourseId },
          dataType: "json",
          success: function (response) {
            // loading remove button
            $("#removeCourseBtn").button("reset");
            if (response.success == true) {
              // remove Course modal
              $("#removeCourseModal").modal("hide");

              // update the Course table
              manageCourseTable.ajax.reload(null, false);

              // remove success messages
              $(".remove-messages").html(
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
              // remove success messages
              $(".removeCourseMessages").html(
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
            } // /error
          }, // /success function
        }); // /ajax fucntion to remove the Course
        return false;
      }); // /remove Course btn clicked
  } // /if Courseid
} // /remove Course function

function clearForm(oForm) {
  // var frm_elements = oForm.elements;
  // console.log(frm_elements);
  // 	for(i=0;i<frm_elements.length;i++) {
  // 		field_type = frm_elements[i].type.toLowerCase();
  // 		switch (field_type) {
  // 	    case "text":
  // 	    case "password":
  // 	    case "textarea":
  // 	    case "hidden":
  // 	    case "select-one":
  // 	      frm_elements[i].value = "";
  // 	      break;
  // 	    case "radio":
  // 	    case "checkbox":
  // 	      if (frm_elements[i].checked)
  // 	      {
  // 	          frm_elements[i].checked = false;
  // 	      }
  // 	      break;
  // 	    case "file":
  // 	    	if(frm_elements[i].options) {
  // 	    		frm_elements[i].options= false;
  // 	    	}
  // 	    default:
  // 	        break;
  //     } // /switch
  // 	} // for
}
