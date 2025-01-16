<!DOCTYPE html>

<html>

<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'Transport';
$_SESSION['SESS_FORM'] = 'vehicle';
$user_level = $_SESSION['USER_LEWAL'];

?>

<body class="hold-transition skin-yellow skin-orange sidebar-mini">

    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                Vehicle 
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
            $vehicle_id = $_GET['id'];

            $result = select('vehicles','*', 'id='.$vehicle_id);
                            for ($i = 0; $row = $result->fetch(); $i++) {
                                $number = $row['number'];

                            }
            // Assuming `select` is a custom function you created that runs a query
$result = select('repair', '*', 'vehicle_id = ' . $vehicle_id . ' AND type_id = 1 ORDER BY date DESC LIMIT 1');
echo $vehicle_id;

// Fetch the latest repair entry
if ($row = $result->fetch()) {
    $last_service_date = $row['date']; // Assuming the date column is named 'date'
} else {
    $last_service_date = "No service data available";
}

            // Assuming `select` is a custom function you created that runs a query
            $result = select('repair', 'Sum(value)', 'vehicle_id = ' . $vehicle_id . ' AND type_id = 1');

            // Fetch the latest repair entry
            if ($row = $result->fetch()) {
                $value_spent = $row['Sum(value)']; // Assuming the date column is named 'date'
            } else {
                $value_spent = 0;
            }

            // Assuming `select` is a custom function you created that runs a query
            $result = select('repair', '*', 'vehicle_id = ' . $vehicle_id . ' AND type_id = 4 ORDER BY date DESC LIMIT 1');

            // Fetch the latest repair entry
            if ($row = $result->fetch()) {
                $last_tyre_date = $row['date']; // Assuming the date column is named 'date'
                $number = $row['number']; // Other details like number
            } else {
                $last_tyre_date = "No Tyre changes yet";
            }

// Assuming `select` is a custom function you created that runs a query
$result = select('repair', '*', 'vehicle_id = ' . $vehicle_id . ' AND type_id != 1 || type_id != 4 ORDER BY date DESC LIMIT 1');

// Fetch the latest repair entry
if ($row = $result->fetch()) {
    $last_repair_date = $row['date']; // Assuming the date column is named 'date'
} else {
    $last_service_date = "No service data available";
}

$result = select('tr_parts_record', 'count(id)', 'vehicle_no=' . "'" . $number . "'");

// Fetch the latest repair entry
if ($row = $result->fetch()) {
    $total_repairs = $row['count(id)']; // Assuming the date column is named 'date'
} else {
    $last_service_date = 0;
}

            ?>



<div class="row">
    <!-- Vehicle Count -->
    <div class="col-sm-6 col-md-4 col-xs-12">
        <div class="info-box bg-lightblue">
            <span class="info-box-icon text-orange"><i class="fas fa-truck"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Vehicle COUNT</span>
                <span class="info-box-number"><?php echo $last_repair_date ?></span>
                <div class="progress">
                    <div class="progress-bar bg-blue" style="width: 100%"></div>
                </div>
                <span class="progress-description text-dark">
                    Total running jobs
                </span>
            </div>
        </div>
    </div>

    <!-- Last Service Date -->
    <div class="col-sm-6 col-md-4 col-xs-12">
        <div class="info-box bg-lightgreen">
            <span class="info-box-icon text-blue"><i class="fas fa-tools"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Last Service Date</span>
                <span class="info-box-number"><?php echo $last_service_date ?></span>
                <div class="progress">
                    <div class="progress-bar bg-green" style="width: 100%"></div>
                </div>
                <span class="progress-description text-dark">
                    Last service performed
                </span>
            </div>
        </div>
    </div>

    <!-- Last Tyre Date -->
    <div class="col-sm-6 col-md-4 col-xs-12">
        <div class="info-box bg-lightorange">
            <span class="info-box-icon text-yellow"><i class="fas fa-circle-notch"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Last Tyre Date</span>
                <span class="info-box-number"><?php echo $last_tyre_date ?></span>
                <div class="progress">
                    <div class="progress-bar bg-orange" style="width: 100%"></div>
                </div>
                <span class="progress-description text-dark">
                    Last tyre change
                </span>
            </div>
        </div>
    </div>

    <!-- Total Repairs -->
    <div class="col-sm-6 col-md-4 col-xs-12">
        <div class="info-box bg-lightpurple">
            <span class="info-box-icon text-green"><i class="fas fa-tools"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Repairs</span>
                <span class="info-box-number"><?php echo $total_repairs ?></span>
                <div class="progress">
                    <div class="progress-bar bg-purple" style="width: 100%"></div>
                </div>
                <span class="progress-description text-dark">
                    Repairs completed
                </span>
            </div>
        </div>
    </div>

    <!-- Total Value Spent -->
    <div class="col-sm-6 col-md-4 col-xs-12">
        <div class="info-box bg-lightyellow">
            <span class="info-box-icon text-red"><i class="fas fa-dollar-sign"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Value Spent</span>
                <span class="info-box-number"><?php echo $value_spent ?></span>
                <div class="progress">
                    <div class="progress-bar bg-yellow" style="width: 100%"></div>
                </div>
                <span class="progress-description text-dark">
                    Amount spent on services
                </span>
            </div>
        </div>
    </div>

    <!-- Next -->
    <div class="col-sm-6 col-md-4 col-xs-12">
        <div class="info-box bg-lightgray">
            <span class="info-box-icon text-white"><i class="fas fa-calendar-alt"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Vehicle number</span>
                <span class="info-box-number"><?php echo $number ?></span>
                <span class="progress-description text-dark">
                    Upcoming maintenance
                </span>
            </div>
        </div>
    </div>
</div>





            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h3 class="box-title">Repire list LIST</h3>
                        </div>

                    </div>



                    <!-- Search Bar -->
                    <?php if($user_level != 5){ ?>
                    <div class="row mt-2">

                    </div>
                    <?php }?>

                </div>

                <!-- Job List Table -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Parts</th>
                                <th>Value</th>

                            </tr>
                        </thead>
                        <?php

$result = select('tr_parts_record', '*', 'vehicle_no=' . "'" . $number . "'");
for ($i = 0; $row = $result->fetch(); $i++) {  ?>

                        <tr class="record">
                            <td><?php echo $row['date'];   ?> </td>
                            <td><?php echo $row['parts'];   ?></td>
                            <td><?php echo $row['value'];   ?></td>

                        </tr>

                        <?php }   ?>

                    </table>
                </div>

            </div>


    </div>


    <!-- Add New Job Popup -->
    <div class="container-up d-none" id="add_job_popup">
        <div class="row w-70">
            <div class="box box-success popup" style="width: 50%;">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New vehicle</h3>
                    <small onclick="click_close('add')" class="btn btn-sm btn-success pull-right">
                        <i class="fa fa-times"></i>
                    </small>
                </div>

                <div class="box-body d-block">
                    <form method="POST" action="save/vehicle_save.php">

                        <div class="row" style="display: block;">







                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Vehicle type</label>
                                    <select class="form-control select2 " id="com_id" name="veh_id" style="width: 100%;"
                                        tabindex="1" autocomplete="off">
                                        <?php 
                                                                        $result = select('vehicle_type', '*');
                                                                        while ($row = $result->fetch()) { 
                                                                        $com_id = $row['id']; 
                                                                    ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['name']; ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>




                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Vehicle brand</label>
                                    <input name="brand" type="text" class="form-control"></input>
                                </div>
                            </div>



                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Vehicle number</label>
                                    <input name="number" type="text" class="form-control"></input>
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Insurance Expire date</label>
                                    <input class="form-control" type="text" id="datepicker1" name="insurance_date"
                                        placeholder="Select date">
                                </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Licence Expire date</label>
                                    <input class="form-control" type="text" id="datepicker" name="licence_date"
                                        placeholder="Select date">
                                </div>
                            </div>









                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" name="cus_id" value="0" id="cus_id">

                                    <input type="submit" style="margin-top: 23px; width: 100%;" id="u1" value="Save"
                                        class="btn btn-info btn-sm pull-right">
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
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

    <!-- Select2 -->
    <script src="../../plugins/select2/select2.full.min.js"></script>

    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>



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

    <script>
    //Date picker
    $('#datepicker1').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd '
    });
    $('#datepicker').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd'
    });
    $('#datepicker2').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd'
    });


    $('#datepickerd').datepicker({
        autoclose: true,
        datepicker: true,
        format: 'yyyy-mm-dd '
    });
    $('#datepickerd').datepicker({
        autoclose: true
    });
    </script>

    <script>
    function find_cus() {
        var contact = document.getElementById('phone').value;

        var data = 'ur';
        fetch("customer_data_get.php?contact=" + contact)
            .then((response) => response.json())
            .then((json) => fill(json));
    }

    function fill(json) {
        console.log(json);

        if (json.action == "true") {
            console.log("old patient");
            document.getElementById('cus_name').value = json.cus_name;
            document.getElementById('cus_address').value = json.cus_address;
            document.getElementById('phone').value = json.cus_phone_no;
            document.getElementById('cus_id').value = json.cus_id;


            document.getElementById('cus_name').disabled = true;
            document.getElementById('cus_address').disabled = true;


            document.getElementById('cus_name').style = 'border: 1px solid #0cc40f';
            document.getElementById('cus_address').style = 'border: 1px solid #0cc40f';
            document.getElementById('phone').style = 'border: 1px solid #0cc40f';


        } else {
            console.log("new patient");
            document.getElementById('cus_name').value = '';
            document.getElementById('cus_address').value = '';
            document.getElementById('cus_id').value = '0';


            document.getElementById('cus_name').disabled = false;
            document.getElementById('cus_address').disabled = false;
            document.getElementById('phone').disabled = false;

            document.getElementById('cus_name').style = 'border: 1px solid ';
            document.getElementById('cus_address').style = 'border: 1px solid ';
            document.getElementById('phone').style = 'border: 1px solid ';

        }
    }

    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            // Redirect to a PHP page that handles the deletion
            window.location.href = 'delete/vehicle_dill.php?id=' + id;
        }
    }
    </script>






    <script>
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