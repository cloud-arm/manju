<!DOCTYPE html>

<html>

<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'management';
$_SESSION['SESS_FORM'] = 'index';
$user_level = $_SESSION['USER_LEWAL'];
?>

<body class="hold-transition skin-yellow skin-orange sidebar-mini">

    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                Home
                <small>Preview</small>
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <?php

            include('connect.php');
            date_default_timezone_set("Asia/Colombo");
            $cash = $_SESSION['SESS_FIRST_NAME'];
            $date =  date("Y-m-d");
            ?>

            <?php 
                $user_id = $_SESSION['USER_EMPLOYEE_ID'];
                $result = query("SELECT branch_id FROM employee WHERE id = '$user_id'");
                for ($i = 0; $row = $result->fetch(); $i++) {
                    $branch_id = $row["branch_id"];
                }

                if($branch_id > 0){
                    $result1 = query("SELECT COUNT(*) AS total_visit FROM visit WHERE branch_id = '$branch_id'");
                    for ($i = 0; $row = $result1->fetch(); $i++) {
                        $visit_count = $row["total_visit"];
                    }
                }elseif($branch_id == 0 && $user_level == 20){
                    $result2 = query("SELECT COUNT(*) AS total_visit FROM visit");
                    for ($i = 0; $row = $result2->fetch(); $i++) {
                        $visit_count = $row["total_visit"];
                    }
                }
                
            ?>

            <div class="row">
                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Visit</span>
                           <a href="visits.php"><span class="info-box-number"><?php echo $visit_count ?></span></a> 
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">BRANCH</span>
                            <span class="info-box-number">0</span>
                            <div class="progress">
                                
                            </div>
                            
                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">RETAIL</span>
                            <span class="info-box-number">0</span>
                            <div class="progress">
                                
                            </div>
                            
                        </div>

                    </div>
                </div>

                
            </div>

   
  

            <div class="box">
   

    <!-- Job List Table -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Employee Name</th>
                    <th>Product Name</th>
                    <th>IMI Number</th>
                    <th>Date</th>
                    <th>Pay Type</th>
                    <th>Amount</th>
                    <th>#</th>
                </tr>
            </thead>

            <tbody>
            <?php 
                $result = query("SELECT * FROM sales WHERE branch_id = '$branch_id' ORDER By id DESC");
                for ($i = 0; $row = $result->fetch(); $i++) {
                    $mpo_name = $row['emp_name'];
                    $product_name = $row['product_name'];
                    $imi_no = $row['imi_number'];
                    $date = $row['date'];
                    $pay_type = $row['pay_type'];
                    $payment = $row['amount'];
                    $project_number = $row['card_number'];
            ?>
                <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo $mpo_name; ?></td>
                <td><?php echo $product_name; ?></td>
                <td><?php echo $imi_no; ?></td>
                <td><?php echo $date; ?></td>
                <td><?php echo $pay_type; ?></td>
                <td><?php echo $payment; ?></td>
                <td>
                    <a class="btn btn-danger" href="progres.php?nic=<?php echo $row['nic']; ?>">
                    <i class="fas fa-eye"></i>
                    </a>
                </td>
                </tr>
            <?php } ?>
            
            </tbody>
        </table>
    </div>
</div>


    </div>


        <!-- Add New Job Popup -->
        
    <!-- /.content-wrapper -->

    <?php include("dounbr.php"); ?>

   <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
       <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <?php include_once("script.php"); ?>

    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>

    

    <script type="text/javascript">
        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false
            });
            
            var a;
            var user_l=<?php echo $user_level ?>;
        var answer = document.getElementById("result");

        if (navigator.userAgent.match(/Android/i) ||
            navigator.userAgent.match(/webOS/i) ||
            navigator.userAgent.match(/iPhone/i) ||
            navigator.userAgent.match(/iPad/i) ||
            navigator.userAgent.match(/iPod/i) ||
            navigator.userAgent.match(/BlackBerry/i) ||
            navigator.userAgent.match(/Windows Phone/i)) {
                if(user_l==1){window.location.href = 'owner_app/index';}
            
        }
        });

            function confirmDelete(id) {
                if (confirm('Are you sure you want to delete this item?')) {
                    // Redirect to a PHP page that handles the deletion
                    window.location.href = 'job_dill.php?id=' + id;
                }
            }


    function click_open(type, id = null) {
        // Hide all popups initially
        document.querySelectorAll('.container-up').forEach(function(popup) {
            popup.classList.add('d-none');
        });

        // Open the Add New Job popup
        if (type === 'add') {
            document.getElementById('add_job_popup').classList.remove('d-none');
        }
        
        // Open the Edit Job popup for the given ID
        if (type === 'edit') {
            document.getElementById('edit_popup_' + id).classList.remove('d-none');
        }
    }

    function click_close(type) {
        // Close the Add Job popup
        if (type === 'add') {
            document.getElementById('add_job_popup').classList.add('d-none');
        } 
        // Close the Edit Job popup for the given ID
        else {
            document.getElementById('edit_popup_' + type).classList.add('d-none');
        }
    }
</script>






</body>

</html>
