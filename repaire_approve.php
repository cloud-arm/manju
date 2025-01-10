<!DOCTYPE html>

<html>

<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'management';
$_SESSION['SESS_FORM'] = 'printing';
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
            $result = $db->prepare("SELECT sum(profit) FROM sales WHERE    date='$date' ");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $profit = $row['sum(profit)'];
            }

            $result = $db->prepare("SELECT sum(amount) FROM sales WHERE  dll=0 AND  date='$date'  ");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $sales_total = $row['sum(amount)'];
            }

            $result = $db->prepare("SELECT sum(amount) FROM sales WHERE  dll=0 AND    date='$date' AND customer_name='NO' ");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $dr_amount = $row['sum(amount)'];
            }

            $month1 = date("Y-m-01");
            $month2 = date("Y-m-31");

            date_default_timezone_set("Asia/Colombo");
            $date = date("Y-m-d");
            $result = $db->prepare("SELECT count(transaction_id) FROM sales WHERE  date='$date' ORDER by transaction_id DESC ");
            $result->bindParam(':userid', $date);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $job_count = $row['count(transaction_id)'];
            }

            $date = date("Y-m-d");


            $result = $db->prepare("SELECT * FROM cash WHERE id = 1 ");
            $result->bindParam(':userid', $res);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $petty_blc = $row['amount'];
                $petty_name = $row['name'];
            }

            $result = $db->prepare("SELECT * FROM cash WHERE id = 2 ");
            $result->bindParam(':userid', $res);
            $result->execute();
            for ($i = 0; $row = $result->fetch(); $i++) {
                $main_blc = $row['amount'];
                $main_name = $row['name'];
            }
            ?>


            <div class="row">
                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Retails</span>
                            <span class="info-box-number">
                                <?php 
                $totalCount = 0; // Initialize total count for retail jobs

                $jobResult = select('job', '*', 'customer_type = "retail"');
                if ($jobResult) {
                    while ($row = $jobResult->fetch()) {
                        $jobId = $row['id'];
                        $salesResult = select('sales_list', 'COUNT(id) AS total1', 'status = "printing" AND action = 0 AND job_no = ' . $jobId);
                        if ($salesResult) {
                            $salesRow = $salesResult->fetch();
                            if ($salesRow) {
                                $totalCount += $salesRow['total1']; // Accumulate the count
                            }
                        }
                    }
                } 
                echo $totalCount; // Display the total retail jobs
                ?>
                            </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">jobs available</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Corporate</span>
                            <span class="info-box-number">
                                <?php 
                $totalCount2 = 0; // Initialize total count for corporate jobs

                $jobResult = select('job', '*', 'customer_type = "corporate"');
                if ($jobResult) {
                    while ($row = $jobResult->fetch()) {
                        $jobId = $row['id'];
                        $salesResult = select('sales_list', 'COUNT(id) AS total2', 'status = "printing" AND action = 0 AND job_no = ' . $jobId);
                        if ($salesResult) {
                            $salesRow = $salesResult->fetch();
                            if ($salesRow) {
                                $totalCount2 += $salesRow['total2']; // Accumulate the count
                            }
                        }
                    }
                } 
                echo $totalCount2; // Display the total corporate jobs
                ?>
                            </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">jobs available</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">All jobs</span>
                            <span class="info-box-number">
                                <?php 
                // Calculate the total count of all jobs (retail + corporate + other types if needed)
                $totalAllJobs = $totalCount + $totalCount2; // Combine retail and corporate counts
                
                // Optionally, if you have other job types (e.g., wholesale), include them as well:
                // Add more customer types by repeating the process for other job categories if needed.

                echo $totalAllJobs; // Display the total count of all jobs
                ?>
                            </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description">jobs</span>
                        </div>
                    </div>
                </div>


            </div>



            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">JOB LIST</h3>

                    <!-- Search Bar -->
                    <div class="row mt-2">
                        <small>
                            <form method="get">


                            </form>
                        </small>
                    </div>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">

                        <div class="box-body d-block">
                            <table id="example2" class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>type</th>
                                        <th>number</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $result = select_query("SELECT * FROM repair WHERE approve = 0 ORDER BY id DESC");
                                    for ($i = 0; $row = $result->fetch(); $i++) {  ?>

                                        <tr class="record">
                                            <td><?php echo $row['id'];?> </td>
                                            <td><?php echo $row['type_name'];?></td>
                                            <td><?php echo $row['number'];?></td>

                                            

                                        </tr>

                                    <?php }   ?>
                                </tbody>

                            </table>
                        </div>
                    </table>
                </div>
            </div>

    </div>



    </section>


    </div>


    <?php
    $con = 'd-none';
    ?>


    <!-- /.content-wrapper -->

    <?php include("dounbr.php"); ?>

    <!-- /.control-sidebar -->

    <!-- Add the sidebar's background. This div must be placed

       immediately after the control sidebar -->

    <div class="control-sidebar-bg"></div>
    </div>


    <?php include_once("script.php"); ?>
    <script>
    function click_open(i) {
        // Hide all popups
        $(".popup").addClass("d-none");
        // Show the specific popup for the clicked button
        $("#popup_" + i).removeClass("d-none");
        // Ensure the container holding the popups is visible
        $("#container_up_" + i).removeClass("d-none");
    }

    function click_close(i) {
        // Hide the specific popup container
        if (i) {
            $(".popup").addClass("d-none"); // Hide all popups
            $("#container_up_" + i).addClass("d-none"); // Hide the corresponding container
        } else {
            // Fallback logic (if needed)
            $(".popup").addClass("d-none");
            $("#popup_1").removeClass("d-none");
        }
    }
    </script>

<script>
    function disableButtonAndSubmit(event, button) {
        // Prevent accidental double submission
        button.disabled = true; // Disable the button
        button.value = "Processing..."; // Optional: Change the button text

        // Allow the form to submit by ensuring the event isn't blocked
        const form = button.closest('form'); // Find the closest form element
        form.submit(); // Submit the form programmatically
    }
</script>


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
    });
    </script>

    <!-- ./wrapper -->
    <!-- ChartJS 1.0.1 -->
    <script src="../../plugins/chartjs/Chart.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>



</body>

</html>