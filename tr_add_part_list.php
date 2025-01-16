<!DOCTYPE html>

<html>

<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'transport';
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

            </div>

            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-9">
                            <h3 class="box-title">Vehicle LIST</h3>
                        </div>
                        <div class="col-md-3 text-right">
                            <span onclick="click_open('add')" class="btn btn-primary btn-sm">Add New parts</span>
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
                    <th>name</th>

                </tr>
            </thead>
            <tbody>
<?php
if ($user_level != 5) {
    // For non-level 5 users, show all jobs or filter by customer type
    $result = isset($_GET['type']) && $_GET['type'] !== 'all' 
        ? select('tr_parts_list','*') 
        : select('tr_parts_list', '*');
} else {
    // For level 5 users, default to showing retail jobs
    $result = (!isset($_GET['type']) || $_GET['type'] == 'retail') 
        ? select('tr_parts_list', '*') 
        : select('tr_parts_list', '*');
}

// Current date for comparison
$current_date = new DateTime();

for ($i = 0; $row = $result->fetch(); $i++) {
    // Parse dates for insurance and licence


    ?>

    <tr>
        <td><?php echo $row['id']; ?></td>

        <td><?php echo $row['name']; ?></td>

        <td>

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
            <div class="box box-success popup" style="width: 150%;">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New vehicle</h3>
                    <small onclick="click_close('add')" class="btn btn-sm btn-success pull-right">
                        <i class="fa fa-times"></i>
                    </small>
                </div>

                <div class="box-body d-block">
                    <form method="POST" action="save/tr_part_list_save.php">

                        <div class="row" style="display: block;">












                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Vehicle Parts</label>
                                    <input name="v_parts" type="text" class="form-control"></input>
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