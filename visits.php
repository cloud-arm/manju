<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_DEPARTMENT'] = 'management';

$_SESSION['SESS_FORM'] = 'store_manage.php';
date_default_timezone_set("Asia/Colombo");
?>

<body class="hold-transition skin-blue skin-orange sidebar-mini ">

    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <h1>
                Visit
                <small>Report</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-sm-6 col-md-4 col-xs-12" style="margin: 20px 0;">
                    <div class="info-box">
                        <span class="info-box-icon"><i class="fa fa-file-text"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Visits</span>
                            <span class="info-box-number">
                                <?php 
                        $totalCount = 0; // Initialize total count for retail jobs

                        
                        $user_id = $_SESSION['USER_EMPLOYEE_ID'];
                        $result = query("SELECT branch_id FROM employee WHERE id = '$user_id'");
                        for ($i = 0; $row = $result->fetch(); $i++) {
                            $branch_id = $row["branch_id"];
                        }

                        $salesResult = select('visit', 'COUNT(id) AS total1', "branch_id = '$branch_id'");
                        if ($salesResult) {
                            $salesRow = $salesResult->fetch();
                            if ($salesRow) {
                                $totalCount += $salesRow['total1']; // Accumulate the count
                            }
                        }
                    
                
                        echo number_format($totalCount); // Display the total corporate jobs with two decimal places
                        ?>
                            </span>
                            <div class="progress">
                                <div class="progress-bar" style="width: 0%"></div>
                            </div>
                            <span class="progress-description"> available</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-8 col-xs-12">
                    <div class="row">
                    <div class="col-md-1"></div>
                        <div class="col-md-8">
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
            <div class="box box-info">

                <div class="box-header with-border">
                    <h3 class="box-title" style="text-transform: capitalize;">Order</h3>
                </div>

                <div class="box-body d-block">
                    <table id="example" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone No</th>
                                <th>NIC</th>
                                <th>Employee</th>
                                <th>TDS Value</th>
                                <th>Date</th>
                                <th>@</th>

                            
                            </tr>
                        </thead>
                        <tbody>
                            <?php
              $a = 0;
              $pay_total = 0;
              $bill_total = 0;
             

                $re = select_query("SELECT * FROM `visit` WHERE date BETWEEN '$d1' AND '$d2'");
                for ($i = 0; $r0 = $re->fetch(); $i++) {
                 
              ?>
                            <tr>
                                <td><?php echo $r0['id'];  ?></td>
                                <td><?php echo $r0['name'];  ?></td>

                                <td><?php echo $r0['address'];  ?></td>
                                <td><?php echo $r0['phone'];  ?></td>
                                <td><?php echo $r0['nic'];  ?></td>
                                <td><?php echo $r0['employee'];  ?></td>
                                <td><?php echo $r0['tds_value'];  ?></td>
                                <td><?php echo $r0['date'];  ?></td>
                                <td>
                                    <a href="progres.php?nic=<?php echo $r0['nic']; ?>" class="btn btn-primary">View</a>
                                </td>


                            </tr>
                            <?php }
              ?>

                        </tbody>

                    </table>
                </div>

            </div>
        </section>

    </div>

    <!-- /.content-wrapper -->
    <?php
  include("dounbr.php");
  ?>
    <div class="control-sidebar-bg"></div>
    </div>

    <?php include_once("script.php"); ?>

    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- InputMask -->
    <script src="../../plugins/input-mask/jquery.inputmask.js"></script>
    <script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="../../plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>

    <script type="text/javascript">
    $(function() {
        $("#example").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
    </script>



    <!-- Page script -->
    <script>
    $(function() {
        //Initialize Select2 Elements
        $(".select2").select2();

        //Datemask dd/mm/yyyy
        $("#datemask").inputmask("YYYY/MM/DD", {
            "placeholder": "YYYY/MM/DD"
        });
        //Datemask2 mm/dd/yyyy
        $("#datemask2").inputmask("YYYY/MM/DD", {
            "placeholder": "YYYY/MM/DD"
        });
        //Money Euro
        $("[data-mask]").inputmask();

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
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'));
            }
        );

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true,
            datepicker: true,
            format: 'yyyy/mm/dd '
        });
        $('#datepicker').datepicker({
            autoclose: true
        });



        $('#datepickerd').datepicker({
            autoclose: true,
            datepicker: true,
            format: 'yyyy/mm/dd '
        });
        $('#datepickerd').datepicker({
            autoclose: true
        });


        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });


    });
    </script>

</body>

</html>