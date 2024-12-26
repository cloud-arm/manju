<!DOCTYPE html>
<html>
<?php
include("head.php");
?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">
    <div class="wrapper">
        <?php
        include_once("auth.php");
        $r = $_SESSION['SESS_LAST_NAME'];
        $_SESSION['SESS_FORM'] = 'sales_rp';


        if ($r == 'admin') {

            include_once("sidebar.php");
        }
        ?>


 <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Sales Report<small>Preview</small></h1>
    </section>

    <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Date Selector</h3>
            </div>
            <div class="box-body">
                <form action="" method="GET">
                    <div class="row" style="margin-bottom: 20px; display: flex; align-items: end;">
                        <div class="col-lg-1"></div>
                        <div class="col-lg-5">
                            <label>Date range:</label>
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" class="form-control pull-right" id="reservation" name="dates" value="<?php echo isset($_GET['dates']) ? $_GET['dates'] : '';?>">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label>Job Type:</label>
                            <select name="type" id="type" class="form-control select2">
                                <option value="all" <?= (!isset($_GET['type']) || $_GET['type'] == 'all') ? 'selected' : ''; ?>>All</option>
                                <option value="corporate" <?= (isset($_GET['type']) && $_GET['type'] == 'corporate') ? 'selected' : ''; ?>>Corporate</option>
                                <option value="retail" <?= (isset($_GET['type']) && $_GET['type'] == 'retail') ? 'selected' : ''; ?>>Retail</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Date Type:</label>
                            <select name="type1" id="type1" class="form-control select2">
                                <option value="job" <?= (!isset($_GET['type1']) || $_GET['type1'] == 'job') ? 'selected' : ''; ?>>Job Date</option>
                                <option value="invoice" <?= (isset($_GET['type1']) && $_GET['type1'] == 'invoice') ? 'selected' : ''; ?>>Invoice Date</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <input type="submit" class="btn btn-info" value="Apply">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include("connect.php");
date_default_timezone_set("Asia/Colombo");

$dates = isset($_GET['dates']) ? $_GET['dates'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : 'all';
$type1 = isset($_GET['type1']) ? $_GET['type1'] : 'job';


// Default date range filter
$d1 = '';
$d2 = '';

if (!empty($dates)) {
    list($start_date, $end_date) = explode(" - ", $dates);
    $d1 = date("Y-m-d", strtotime($start_date));
    $d2 = date("Y-m-d", strtotime($end_date));
}

echo $type1;

if ($type == 'all') {
    $customer_type_condition = "customer_type IN ('corporate', 'retail')";
} else {
    $customer_type_condition = "customer_type = '$type'";
}


?>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Sales Report</h3>
        </div>
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
            <thead>
    <tr>
        <th>Date</th>
        <th>Invoice No</th>
        <th>Pay Type</th>
        <th>Job Number</th>
        <th>Customer Name</th>
        <th>Amount</th>
        <th>View</th>
    </tr>
</thead>
<tbody>
    <?php

if ($type1 == 'job') {
    $result = select('sales', '*', "job_date BETWEEN '$d1' AND '$d2' AND $customer_type_condition", '');
} else {
    $result = select('sales', '*', "date BETWEEN '$d1' AND '$d2' AND $customer_type_condition", '');
}



    while ($row = $result->fetch()) {
        $job_no = $row['job_no'];
        $r1 = select_item('job', 'all_job_no', "id = '$job_no'"); // Ensure this function returns a single value
        ?>
        <tr>
            <td><?php echo ($row['date']); ?></td>
            <td><?php echo ($row['transaction_id']); ?></td>
            <td><?php echo ($row['pay_type']); ?></td>
            <td><?php echo ($r1); ?></td> <!-- Corrected to display the result -->
            <td><?php echo ($row['customer_name']); ?></td>
            <td><?php echo ($row['amount']); ?></td>
            <td>
                <a href="save/print.php?id=<?php echo ($job_no); ?>" class="btn btn-primary btn-sm">
                    <i class="fa fa-print"></i>
                </a>
                <?php if ($row['date'] == date('Y-m-d')) { ?>
                    <a href="#" onclick="invo_dll(<?php echo ($row['transaction_id']); ?>)" class="btn btn-danger btn-sm">
                        <i class="fa fa-trash"></i>
                    </a>
                    <form action="sales_dll.php" method="POST" id="did_<?php echo ($row['transaction_id']); ?>">
                        <input type="hidden" name="id" value="<?php echo ($row['transaction_id']); ?>">
                    </form>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</tbody>
<tfoot>
    <tr>
        <th></th>
        <th></th>
        <th>Total</th>
        <th>F/S</th>
        <th></th>
    </tr>
</tfoot>

            </table>
        </div>
    </div>
</section>


                    </div>
                </div>









                <!-- Main content -->

                <!-- /.row -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php
        include("dounbr.php");
        ?>
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
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>
    <!-- date picker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>

    <!-- page script -->
    <script>
        function invo_dll(did) {
            if (confirm("Sure you want to delete this Invoice? There is NO undo!")) {
               // $('#sales_dll').submit();
                document.getElementById('did_'+did).submit();
            }
            return false;
        }

        $(function() {
            $("#example1").DataTable();
            $("#example2").DataTable();
            $('#example3').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        //Date range picker
        $('#reservation').daterangepicker();
        //Date range picker with time picker
        //$('#datepicker').datepicker({datepicker: true,  format: 'yyyy/mm/dd '});
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            }
        );

        $('#datepicker').datepicker({
            autoclose: true,
            datepicker: true,
            format: 'yyyy-mm-dd '
        });
        $('#datepicker').datepicker({
            autoclose: true
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
</body>

</html>