<?php require_once 'includes/header.php'; ?>

<?php 

$sql = "SELECT * FROM Course WHERE status = 1";
$query = $connect->query($sql);
$countCourse = $query->num_rows;

$forumSql = "SELECT * FROM forum WHERE forum_status = 1";
$forumQuery = $connect->query($forumSql);
$countforum = $forumQuery->num_rows;

$totalRevenue = "";
while ($forumResult = $forumQuery->fetch_assoc()) {
	$totalRevenue += $forumResult['paid'];
}

$lowStockSql = "SELECT * FROM Course WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$userwisesql = "SELECT users.username , SUM(forum.grand_total) as totalforum FROM forum INNER JOIN users ON forum.user_id = users.user_id WHERE forum.forum_status = 1 GROUP BY forum.user_id";
$userwiseQuery = $connect->query($userwisesql);
$userwieseforum = $userwiseQuery->num_rows;

$connect->close();

?>


<style type="text/css">
.ui-datepicker-calendar {
    display: none;
}
</style>

<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">


<div class="row">
    <?php  if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading">

                <a href="Course.php" style="text-decoration:none;color:black;">
                    Total Course
                    <span class="badge pull pull-right"><?php echo $countCourse; ?></span>
                </a>

            </div>
            <!--/panel-hdeaing-->
        </div>
        <!--/panel-->
    </div>
    <!--/col-md-4-->

    <div class="col-md-4">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <a href="Course.php" style="text-decoration:none;color:black;">
                    Low Stock
                    <span class="badge pull pull-right"><?php echo $countLowStock; ?></span>
                </a>

            </div>
            <!--/panel-hdeaing-->
        </div>
        <!--/panel-->
    </div>
    <!--/col-md-4-->


    <?php } ?>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                <a href="forum.php?o=manord" style="text-decoration:none;color:black;">
                    Total forum
                    <span class="badge pull pull-right"><?php echo $countforum; ?></span>
                </a>

            </div>
            <!--/panel-hdeaing-->
        </div>
        <!--/panel-->
    </div>
    <!--/col-md-4-->



    <div class="col-md-4">
        <div class="card">
            <div class="cardHeader">
                <h1><?php echo date('d'); ?></h1>
            </div>

            <div class="cardContainer">
                <p><?php echo date('l') .' '.date('d').', '.date('Y'); ?></p>
            </div>
        </div>
        <br />

        <div class="card">
            <div class="cardHeader" style="background-color:#245580;">
                <h1><?php if($totalRevenue) {
		    	echo $totalRevenue;
		    	} else {
		    		echo '0';
		    		} ?></h1>
            </div>

            <div class="cardContainer">
                <p> INR Total Revenue</p>
            </div>
        </div>

    </div>

    <?php  if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> Forum</div>
            <div class="panel-body">
                <table class="table" id="CourseTable">
                    <thead>
                        <tr>
                            <th style="width:40%;">Name</th>
                            <th style="width:20%;">Post</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($forumResult = $userwiseQuery->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $forumResult['username']?></td>
                            <td><?php echo $forumResult['totalforum']?></td>

                        </tr>

                        <?php } ?>
                    </tbody>
                </table>
                <!--<div id="calendar"></div>-->
            </div>
        </div>

    </div>
    <?php  } ?>

</div>
<!--/row-->

<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
$(function() {
    // top bar active
    $('#navDashboard').addClass('active');

    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: '',
            center: 'title'
        },
        buttonText: {
            today: 'today',
            month: 'month'
        }
    });


});
</script>

<?php require_once 'includes/footer.php'; ?>