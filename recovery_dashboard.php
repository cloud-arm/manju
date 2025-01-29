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

<script>
    function setProject(pro){
        console.log("working model .! "+pro);
        const inputField = document.getElementById("proInput");
        inputField.value = pro;

        var modal = document.getElementById("myModal");
        modal.classList.remove("d-none");
    }

    function closeModal(){
        var modal = document.getElementById("myModal");
        modal.classList.remove("d-block");
        modal.classList.add("d-none");
    }
        
</script>

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

                $result1 = query("SELECT COUNT(*) AS job_count FROM credit WHERE recovery_officer_id = '0'");
                for ($i = 0; $row = $result1->fetch(); $i++) {
                    $job_count = $row["job_count"];
                }
            ?>

            <div class="row">
                <div class="col-sm-6 col-md-3 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Not Assigned Project</span>
                           <a href=""><span class="info-box-number"><?php echo $job_count ?></span></a> 
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Assigned And Running</span>
                            <span class="info-box-number">0</span>
                            <div class="progress">
                                
                            </div>
                            
                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-xs-12">

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

                <div class="col-sm-6 col-md-3 col-xs-12">

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

   <!-- Modal content -->
   <div id="myModal" class="d-none">
        
        <div style="position: relative; border-radius: 8px;">

        <button 
            onclick="closeModal()" 
            style="
                position: absolute; 
                top: 10px; 
                right: 10px; 
                background: transparent; 
                border: none; 
                font-size: 20px; 
                cursor: pointer;"
        >
            &times;
        </button>

            <form method="post" action="recovery_officer_assign.php" style="width: 30%;">
                <div class="box-body">
                    <div class="row">

                        <div class="col-md-8">
                            <div class="form-group">
                                <h3>Officer Name</h3>
                                <select class="form-control select2" name="reco" style="width: 100%;" autofocus>
                                    <?php
                                    $result = query("SELECT * FROM employee ");
                                    
                                    for ($i = 0; $row = $result->fetch(); $i++) {
                                    ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?>
                                        </option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input class="btn btn-info" type="submit" value="Save" style="margin-top: 55%;">
                        </div>
                    </div>
                </div>
                <!-- /.box -->
                <input type="hidden" id="proInput" name="project" value="">
            </form>
        </div>
    </div>
  

<div class="box">
    <!-- Job List Table -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Credit Amount</th>
                    <th>Number Of Installment</th>
                    <th>Project Number</th>
                    <th>TDS Value</th>
                    <th>Customer Satisfaction</th>
                    <th>#</th>
                </tr>
            </thead>

            <tbody>
            <?php 
                $result = query("SELECT * FROM credit WHERE recovery_officer_id = '0'");
                for ($i = 0; $row = $result->fetch(); $i++) {
                    $credit_amount = $row['credit_amount'];
                    $no_of_installments = $row['no_of_installments'];
                    $project_number = $row['project_number'];
                    $tds_value = $row['tds_value'];
                    $positive = $row['positive'];
            ?>
                <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo $credit_amount; ?></td>
                <td><?php echo $no_of_installments; ?></td>
                <td><?php echo $project_number; ?></td>
                <td><?php echo $tds_value; ?></td>
                <td><?php echo $positive; ?></td>
                <td>
                    <button id="myBtn" class="btn btn-info" onclick="setProject(<?php echo $project_number; ?>)">
                        <i class="glyphicon glyphicon-plus"></i>
                    </button>
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
