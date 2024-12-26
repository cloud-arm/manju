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
                                <div class="col-md-2">
                                    <select name="type" id="type" class="form-control select2">
                                        <option value="all"
                                            <?= (!isset($_GET['type']) || $_GET['type'] == 'all') ? 'selected' : ''; ?>>
                                            All</option>
                                        <option value="corporate"
                                            <?= (isset($_GET['type']) && $_GET['type'] == 'corporate') ? 'selected' : ''; ?>>
                                            Corporate</option>
                                        <option value="retail"
                                            <?= (isset($_GET['type']) && $_GET['type'] == 'retail') ? 'selected' : ''; ?>>
                                            Retail</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <input type="submit" id="filt1" value="Filter job type" class="btn btn-primary">
                                </div>
                            </form>
                        </small>
                    </div>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Job Name</th>
                                <th>Quantity</th>
                                <th>Job Number</th>
                                <th>Location</th>
                                <th>Disgner note</th>
                                <th>Hright</th>
                                <th>Width</th>
                                <th>Approval Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                    // Filter jobs based on customer type
                    if (!isset($_GET['type']) || $_GET['type'] == 'all') {
                        $jobResult = select('job', '*');
                    } else {
                        $jobResult = select('job', '*', "customer_type='" . $_GET['type'] . "'");
                    }

                    while ($jobRow = $jobResult->fetch()) {
                        $jobId = $jobRow['id'];
                        $dll = $jobRow['dll'];
                        $customer_type = $jobRow['customer_type'];

                if ($dll != 1) {
                    // Fetch sales_list data related to this job and with specific conditions
                    $salesResult = select('sales_list', '*', 'status="printing" AND action=0 AND job_no=' . $jobId);

                    while ($salesRow = $salesResult->fetch()) {
                        $popup_id = $salesRow['id']; // Store row's unique ID for dynamic popup
                        ?>
                            <tr>
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; justify-content: space-between;">
                                        <span><?php echo $jobRow['name']; ?></span>
                                        <div align="center">
                                            <?php 
                                    if ($jobRow['customer_type'] == 'corporate') {
                                        echo '<div class="badge bg-blue"><i class="fas fa-building"></i>';
                                    } elseif ($jobRow['customer_type'] == 'retail') {
                                        echo '<div class="badge bg-yellow"><i class="fas fa-shopping-cart"></i>';
                                    }
                                ?>
                                        </div>
                                        <br>
                                    </div>
                                </td>



                                <td><?php echo $salesRow['qty']; ?></td>
                                <td><?php echo $salesRow['job_no']; ?></td>
                                <td><?php echo $salesRow['location']; ?></td>


                                <td><?php echo $salesRow['art_note'] ?></td>
                                <td><?php echo $salesRow['height']; ?></td>
                                <td><?php echo $salesRow['width']; ?></td>
                                <td><?php echo $salesRow['approvel_note']; ?></td>

                                <td>
                                    <span onclick="click_open(<?php echo $popup_id; ?>)"
                                        class="btn btn-primary btn-sm pull-right mx-2" id="comp_btn"> Complete</span>

                                    <!-- Popup container for 'Complete' action -->
                                    <div class="container-up d-none" id="container_up_<?php echo $popup_id; ?>">
                                        <div class="row w-70">
                                            <div class="box box-success popup" id="popup_<?php echo $popup_id; ?>"
                                                style="width: 50%; padding: 20px;">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Printing Details</h3>
                                                    <small onclick="click_close(<?php echo $popup_id; ?>)"
                                                        class="btn btn-sm btn-success pull-right">
                                                        <i class="fa fa-times"></i>
                                                    </small>
                                                </div>
                                                <div class="box-body d-block">
                                                    <form method="POST"
                                                        action="save/job/printing_save.php?id=<?php echo $salesRow['id']; ?>">
                                                        <div class="row" style="display: block; padding: 15px;">
                                                            <!-- Material selection -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Material</label>
                                                                    <select class="form-control" name="material_id" id="mat_id"
                                                                        style="width: 100%;">
                                                                        <?php
                                                                        $materialResult = select("materials", "*", "category IN ('flex', 'sticker')");
                                                                        while ($materialRow = $materialResult->fetch()) {
                                                                        ?>
                                                                        <option
                                                                            value="<?php echo $materialRow['id']; ?>">
                                                                            <?php echo $materialRow['name']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <!-- Quantity input -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Height</label>
                                                                    <input type="number" name="qty" id="height1" class="form-control"
                                                                        step="0.01" min="0" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <!-- Note input -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Note</label>
                                                                    <textarea name="print_note" id="print_note" class="form-control"
                                                                        rows="5" style="resize: none;"
                                                                        autocomplete="off"
                                                                        placeholder="Enter your note here"></textarea>
                                                                </div>
                                                            </div>
                                                            <!-- Submit button -->
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id2" value="1">
                                                                    <input type="submit"
                                                                    id="print_save"
                                                                        style="margin-top: 23px; width: 100%;"
                                                                        value="Save and Add Designer Note"
                                                                        class="btn btn-info btn-sm">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } } } ?>
                        </tbody>
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