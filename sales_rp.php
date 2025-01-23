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



// Default date range filter
$d1 = '';
$d2 = '';

if (!empty($dates)) {
    list($start_date, $end_date) = explode(" - ", $dates);
    $d1 = date("Y-m-d", strtotime($start_date));
    $d2 = date("Y-m-d", strtotime($end_date));
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
        <th>Product name</th>
        <th>Imi number</th>
        <th>Pay type</th>
        <th>Amount</th>
        <th>Down payment</th>
        <th>Balance</th>
        <th>Nic</th>
        <th>Employee name</th>

    </tr>
</thead>
<tbody>
    <?php

 
    $result = select('sales', '*', "date BETWEEN '$d1' AND '$d2'", '');




    while ($row = $result->fetch()) {
        ?>
        <tr>
            <td><?php echo ($row['date']); ?></td>
            <td><?php echo ($row['product_name']); ?></td>
            <td><?php echo ($row['imi_number']); ?></td>
            <td><?php echo ($row['pay_type']); ?></td>
            <td><?php echo ($row['amount']); ?></td>
            <td><?php echo ($row['down_payment']); ?></td>
            <td><?php echo ($row['balance']); ?></td>
            <td><?php echo ($row['nic']); ?></td>
            <td><?php echo ($row['emp_name']); ?></td>






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