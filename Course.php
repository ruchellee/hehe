<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; ?>

<div class="row">
    <div class="col-md-12">

        <ol class="breadcrumb">
            <li><a href="dashboard.php">Home</a></li>
            <li class="active">Courses</li>
        </ol>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Manage Course</div>
            </div> <!-- /panel-heading -->
            <div class="panel-body">

                <div class="remove-messages"></div>

                <div class="div-action pull pull-right" style="padding-bottom:20px;">
                    <button class="btn btn-default button1" data-toggle="modal" id="addCourseModalBtn"
                        data-target="#addCourseModal"> <i class="glyphicon glyphicon-plus-sign"></i> Add Course
                    </button>
                </div> <!-- /div-action -->

                <table class="table" id="manageCourseTable">
                    <thead>
                        <tr>
                            <th style="width:10%;">Photo</th>
                            <th>Course Name</th>
                            <th>Rate</th>
                            <th>Quantity</th>
                            <th>University</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th style="width:15%;">Options</th>
                        </tr>
                    </thead>
                </table>
                <!-- /table -->

            </div> <!-- /panel-body -->
        </div> <!-- /panel -->
    </div> <!-- /col-md-12 -->
</div> <!-- /row -->


<!-- add Course -->
<div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form class="form-horizontal" id="submitCourseForm" action="php_action/createCourse.php" method="POST"
                enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Course</h4>
                </div>

                <div class="modal-body" style="max-height:450px; overflow:auto;">

                    <div id="add-Course-messages"></div>

                    <div class="form-group">
                        <label for="CourseImage" class="col-sm-3 control-label">Course Image: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <!-- the avatar markup -->
                            <div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>
                            <div class="kv-avatar center-block">
                                <input type="file" class="form-control" id="CourseImage" placeholder="Course Name"
                                    name="CourseImage" class="file-loading" style="width:auto;" />
                            </div>

                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="CourseName" class="col-sm-3 control-label">Course Name: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="CourseName" placeholder="Course Name"
                                name="CourseName" autocomplete="off">
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">Quantity: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="quantity" placeholder="Quantity" name="quantity"
                                autocomplete="off">
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="rate" class="col-sm-3 control-label">Rate: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="rate" placeholder="Rate" name="rate"
                                autocomplete="off">
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="UniversityName" class="col-sm-3 control-label">University Name: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <select class="form-control" id="UniversityName" name="UniversityName">
                                <option value="">~~SELECT~~</option>
                                <?php 
				      	$sql = "SELECT University_id, University_name, University_active, University_status FROM University WHERE University_status = 1 AND University_active = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
                            </select>
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="categoryName" class="col-sm-3 control-label">Category Name: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <select type="text" class="form-control" id="categoryName" placeholder="Course Name"
                                name="categoryName">
                                <option value="">~~SELECT~~</option>
                                <?php 
				      	$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
                            </select>
                        </div>
                    </div> <!-- /form-group-->

                    <div class="form-group">
                        <label for="CourseStatus" class="col-sm-3 control-label">Status: </label>
                        <label class="col-sm-1 control-label">: </label>
                        <div class="col-sm-8">
                            <select class="form-control" id="CourseStatus" name="CourseStatus">
                                <option value="">~~SELECT~~</option>
                                <option value="1">Available</option>
                                <option value="2">Not Available</option>
                            </select>
                        </div>
                    </div> <!-- /form-group-->
                </div> <!-- /modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                            class="glyphicon glyphicon-remove-sign"></i> Close</button>

                    <button type="submit" class="btn btn-primary" id="createCourseBtn" data-loading-text="Loading..."
                        autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button>
                </div> <!-- /modal-footer -->
            </form> <!-- /.form -->
        </div> <!-- /modal-content -->
    </div> <!-- /modal-dailog -->
</div>
<!-- /add categories -->


<!-- edit categories University -->
<div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Course</h4>
            </div>
            <div class="modal-body" style="max-height:450px; overflow:auto;">

                <div class="div-loading">
                    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>

                <div class="div-result">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#photo" aria-controls="home" role="tab"
                                data-toggle="tab">Photo</a></li>
                        <li role="presentation"><a href="#CourseInfo" aria-controls="profile" role="tab"
                                data-toggle="tab">Course Info</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">


                        <div role="tabpanel" class="tab-pane active" id="photo">
                            <form action="php_action/editCourseImage.php" method="POST" id="updateCourseImageForm"
                                class="form-horizontal" enctype="multipart/form-data">

                                <br />
                                <div id="edit-CoursePhoto-messages"></div>

                                <div class="form-group">
                                    <label for="editCourseImage" class="col-sm-3 control-label">Course Image: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <img src="" id="getCourseImage" class="thumbnail"
                                            style="width:250px; height:250px;" />
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editCourseImage" class="col-sm-3 control-label">Select Photo: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <!-- the avatar markup -->
                                        <div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>
                                        <div class="kv-avatar center-block">
                                            <input type="file" class="form-control" id="editCourseImage"
                                                placeholder="Course Name" name="editCourseImage" class="file-loading"
                                                style="width:auto;" />
                                        </div>

                                    </div>
                                </div> <!-- /form-group-->

                                <div class="modal-footer editCoursePhotoFooter">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                                            class="glyphicon glyphicon-remove-sign"></i> Close</button>

                                    <!-- <button type="submit" class="btn btn-success" id="editCourseImageBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button> -->
                                </div>
                                <!-- /modal-footer -->
                            </form>
                            <!-- /form -->
                        </div>
                        <!-- Course image -->
                        <div role="tabpanel" class="tab-pane" id="CourseInfo">
                            <form class="form-horizontal" id="editCourseForm" action="php_action/editCourse.php"
                                method="POST">
                                <br />

                                <div id="edit-Course-messages"></div>

                                <div class="form-group">
                                    <label for="editCourseName" class="col-sm-3 control-label">Course Name: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="editCourseName"
                                            placeholder="Course Name" name="editCourseName" autocomplete="off">
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editQuantity" class="col-sm-3 control-label">Quantity: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="editQuantity" placeholder="Quantity"
                                            name="editQuantity" autocomplete="off">
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editRate" class="col-sm-3 control-label">Rate: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="editRate" placeholder="Rate"
                                            name="editRate" autocomplete="off">
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editUniversityName" class="col-sm-3 control-label">University Name: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="editUniversityName" name="editUniversityName">
                                            <option value="">~~SELECT~~</option>
                                            <?php 
						      	$sql = "SELECT University_id, University_name, University_active, University_status FROM University WHERE University_status = 1 AND University_active = 1";
										$result = $connect->query($sql);

										while($row = $result->fetch_array()) {
											echo "<option value='".$row[0]."'>".$row[1]."</option>";
										} // while
										
						      	?>
                                        </select>
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editCategoryName" class="col-sm-3 control-label">Category Name: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <select type="text" class="form-control" id="editCategoryName"
                                            name="editCategoryName">
                                            <option value="">~~SELECT~~</option>
                                            <?php 
						      	$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
										$result = $connect->query($sql);

										while($row = $result->fetch_array()) {
											echo "<option value='".$row[0]."'>".$row[1]."</option>";
										} // while
										
						      	?>
                                        </select>
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="form-group">
                                    <label for="editCourseStatus" class="col-sm-3 control-label">Status: </label>
                                    <label class="col-sm-1 control-label">: </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="editCourseStatus" name="editCourseStatus">
                                            <option value="">~~SELECT~~</option>
                                            <option value="1">Available</option>
                                            <option value="2">Not Available</option>
                                        </select>
                                    </div>
                                </div> <!-- /form-group-->

                                <div class="modal-footer editCourseFooter">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                                            class="glyphicon glyphicon-remove-sign"></i> Close</button>

                                    <button type="submit" class="btn btn-success" id="editCourseBtn"
                                        data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save
                                        Changes</button>
                                </div> <!-- /modal-footer -->
                            </form> <!-- /.form -->
                        </div>
                        <!-- /Course info -->
                    </div>

                </div>

            </div> <!-- /modal-body -->


        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dailog -->
</div>
<!-- /categories University -->

<!-- categories University -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeCourseModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Remove Course</h4>
            </div>
            <div class="modal-body">

                <div class="removeCourseMessages"></div>

                <p>Do you really want to remove ?</p>
            </div>
            <div class="modal-footer removeCourseFooter">
                <button type="button" class="btn btn-default" data-dismiss="modal"> <i
                        class="glyphicon glyphicon-remove-sign"></i> Close</button>
                <button type="button" class="btn btn-primary" id="removeCourseBtn" data-loading-text="Loading..."> <i
                        class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories University -->


<script src="custom/js/Course.js"></script>

<?php require_once 'includes/footer.php'; ?>