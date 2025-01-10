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


            <div class="row">
                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fas fa-truck"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Vehicle COUNT</span>
                            <span
                                class="info-box-number"><?php echo $tot_job=select_item('vehicles','COUNT(id)'); ?></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                            </div>
                            <span class="progress-description">
                                Total running jobs
                            </span>
                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">NEXT</span>
                            <span class="info-box-number"></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo ($cop_job/$tot_job)*100 ?>%"></div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-sm-6 col-md-4 col-xs-12">

                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-shopping-cart"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">NEXT</span>
                            <span class="info-box-number"></span>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo ($ret_job/$tot_job)*100 ?>%"></div>
                            </div>

                        </div>

                    </div>
                </div>


            </div>




            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h3 class="box-title">Vehicle LIST</h3>
                        </div>
                        <div class="col-md-3 text-right">
                            <span onclick="click_open('add')" class="btn btn-primary btn-sm">Add New Vehicle</span>
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
                    <th>No</th>
                    <th>Vehicle Number</th>
                    <th>Vehicle Type</th>


                    <th>Brand</th>
                    <th>Insurance date</th>
                    <th>license date</th>


                    <th>#</th>

                </tr>
            </thead>
            <tbody>
<?php
if ($user_level != 5) {
    // For non-level 5 users, show all jobs or filter by customer type
    $result = isset($_GET['type']) && $_GET['type'] !== 'all' 
        ? select('vehicles') 
        : select('vehicles');
} else {
    // For level 5 users, default to showing retail jobs
    $result = (!isset($_GET['type']) || $_GET['type'] == 'retail') 
        ? select('vehicles', '*') 
        : select('vehicles', '*');
}

// Current date for comparison
$current_date = new DateTime();

for ($i = 0; $row = $result->fetch(); $i++) {
    // Parse dates for insurance and licence
    $insurance_date = new DateTime($row['insurance_date']);
    $licence_date = new DateTime($row['licence_date']);

    // Calculate date differences
    $insurance_diff = $current_date->diff($insurance_date)->format('%r%a'); // Days difference
    $licence_diff = $current_date->diff($licence_date)->format('%r%a'); // Days difference

    // Determine CSS class for insurance date
    $insurance_class = $insurance_diff <= 30 && $insurance_diff <= 0 
        ? 'bg-red' 
        : ($insurance_diff <= 60 && $insurance_diff > 30 
            ? 'bg-warning' 
            : ($insurance_diff > 0 ? 'bg-green' : ''));

    // Determine CSS class for licence date
    $licence_class = $licence_diff <= 30 && $licence_diff <= 0 
        ? 'bg-red' 
        : ($licence_diff <= 60 && $licence_diff > 30 
            ? 'bg-warning' 
            : ($licence_diff > 0 ? 'bg-green' : ''));
    ?>

    <tr>
        <td><?php echo $row['id']; ?></td>
        <td>
            <div class="d-flex align-items-center">
                <label for="$day" class="badge bg-blue"><?php echo $row['number']; ?></label>
            </div>
        </td>
        <td><?php echo $row['type_name']; ?></td>
        <td><?php echo $row['brand']; ?></td>
        <td>
            <span class="badge <?php echo $insurance_class; ?>">
                <?php echo $row['insurance_date']; ?>
            </span>
        </td>
        <td>
            <span class="badge <?php echo $licence_class; ?>">
                <?php echo $row['licence_date']; ?>
            </span>
        </td>
        <td>
            <a href="repire.php?id=<?php echo $row['id']; ?>">
                <button class="btn btn-sm btn-info"><i class="fas fa-hammer"></i></button>
            </a>
            <?php if ($user_level == 1): ?>
                <a class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                    <i class="fas fa-trash"></i>
                </a>
            <?php endif; ?>
        </td>
    </tr>

<?php } ?>
</tbody>

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
                                    <input class="form-control" type="text" id="datepicker1" name="insurance_date" placeholder="Select date" >
                                    </div>
                            </div>

                            <div class="col-md-10">
                                <div class="form-group">
                                    <label>Licence Expire date</label>
                                    <input class="form-control" type="text" id="datepicker" name="licence_date" placeholder="Select date" >
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