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
                <h1>
                    Sales Report
                    <small>Preview</small>
                </h1>
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
                                <div class="row" style="margin-bottom: 20px;display: flex;align-items: end;">
                                    <div class="col-lg-1"></div>
                                    <div class="col-lg-8">
                                        <label>Date range:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="reservation" name="dates" value="<?php echo $_GET['dates']; ?>">
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

            $dates = $_GET['dates'];
            $d1 = date_format(date_create(explode("-", $dates)[0]), "Y-m-d");
            $d2 = date_format(date_create(explode("-", $dates)[1]), "Y-m-d");

            ?>

            <section class="content">

                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sales Report</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">

                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice no</th>
                                    <th>Pay Type</th>
                                    <th>Table No</th>
                                    <th>Profit</th>
                                    <th>Amount</th>
                                    <th>View</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php

                                $_SESSION['SESS_BACK'] = 'sales_rp.php?d1=' . $d1 . '&d2=' . $d2;

                                $tot = 0;
                                $prof = 0;
                                $result = $db->prepare("SELECT * FROM sales WHERE dll=0 AND date BETWEEN '$d1' AND '$d2'  ");
                                $result->bindParam(':userid', $date);
                                $result->execute();
                                for ($i = 0; $row = $result->fetch(); $i++) {

                                    $type = $row['type'];
                                    $id = $row['invoice_number'];

                                ?>
                                    <tr>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo $row['transaction_id']; ?></td>
                                        <td><?php echo $row['pay_type']; ?></td>
                                        <td><?php echo $row['room_no']; ?></td>
                                        <td><?php echo $row['profit']; ?></td>
                                        <td><?php echo $row['amount']; ?></td>
                                        <td>
                                            <a href="bill.php?id=<?php echo $id; ?>" class="btn btn-primary btn-sm"> <i class="fa fa-print"></i> </a>
                                            <?php if ($row['date'] == date('Y-m-d')) { ?>
                                                <a href="#" onclick="invo_dll(<?php echo $row['transaction_id']; ?>)" class="btn btn-primary btn-sm"> <i class="fa fa-trash"></i> </a>
                                                <form action="sales_dll.php" method="POST" id="did_<?php echo $row['transaction_id']; ?>">
                                                    <input type="hidden" name="id" value="<?php echo $row['transaction_id']; ?>">
                                                </form>
                                            <?php } ?>
                                        </td>

                                    </tr>

                                    <?php
                                    $tot += $row['amount'];
                                    $prof += $row['profit']; ?>
                                <?php } ?>


                            </tbody>
                            <tfoot>


                                <tr>

                                    <th></th>
                                    <th></th>
                                    <th>Total </th>

                                    <th>F/S</th>

                                    <th><?php echo number_format($prof, 2); ?></th>
                                    <th><?php echo number_format($tot, 2); ?></th>
                                    <th></th>
                                </tr>

                                <?php
                                $hold = 0;

                                $ex = 0;


                                $result = $db->prepare("SELECT sum(amount) FROM sales WHERE pay_type='Card' and action='active' and date BETWEEN '$d1' AND '$d2'  ");
                                $result->bindParam(':userid', $date);
                                $result->execute();
                                for ($i = 0; $row = $result->fetch(); $i++) {
                                    $card_tot = $row['sum(amount)'];
                                }


                                

                                $cash = $tot - $card_tot;
                                $total = $cash - $ex;

                                ?>
                            </tfoot>
                        </table>

                    </div>
                </div>


                <?php
                    $ex_tot = 0;
                    $ex_cash=0;
                    $grn = 0;
                    $cash_grn=0;
                    $ex_tot=select_item('expenses_records','sum(amount)',"date BETWEEN '$d1' AND '$d2' ");
                    $ex_cash=select_item('expenses_records','sum(amount)',"pay_type='cash' AND date BETWEEN '$d1' AND '$d2' ");
                    $grn=select_item('purchases','sum(amount)',"date BETWEEN '$d1' AND '$d2' ");
                    $cash_grn=select_item('supply_payment', 'SUM(amount)', "pay_type = 'Cash' AND date BETWEEN '$d1' AND '$d2'" );
                    
                    ?>

                <div class="row">

                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Summary</h3>
                            </div>
                            <!-- /.box-header -->

                            <div class="box-body">
                                <table class="table table-borderless table-hover">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h3 style="margin: 0">Bill Total  </h3>
                                            </td>
                                            <td>
                                                <h3 style="margin: 0"><small>Rs.</small><?php echo number_format($tot, 2); ?></h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 style="margin: 0;">Card Bill  </h4>
                                            </td>
                                            <td>
                                                <h4 style="margin: 0"><small>Rs.</small><?php echo number_format($card_tot, 2); ?></h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 style="margin: 0">Cash Bill  </h4>
                                            </td>
                                            <td>
                                                <h4 style="margin: 0"><small>Rs.</small><?php echo number_format($cash, 2); ?></h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 style="margin: 0">Expenses Total  </h4>
                                            </td>
                                            <td>
                                                <h4 style="margin: 0"><small>Rs.</small><?php echo number_format($ex_tot, 2); ?></h4>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <h4 style="margin: 0">Purchases Total  </h4>
                                            </td>
                                            <td>
                                                <h4 style="margin: 0"><small>Rs.</small><?php echo number_format($grn, 2); ?></h4>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <h4 style="margin: 0">Balance  </h4>
                                            </td>
                                            <td>
                                                <h4 style="margin: 0"><small>Rs.</small><?php echo number_format($tot-($cash_grn+$ex_cash), 2); ?></h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>

                    

                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Cash Summary</h3>
                            </div>
                            <!-- /.box-header -->

                            <div class="box-body">
                                <table class="table table-borderless table-hover">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <h3 style="margin: 0">CASH Invoice </h3>
                                            </td>
                                            <td>
                                                <h3 style="margin: 0"><small>Rs.</small> <?php echo number_format($cash, 2); ?></h3>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 style="margin: 0">CASH Purchases </h4>
                                            </td>
                                            <td>
                                                <h4 style="margin: 0"><small>Rs.</small> <?php echo number_format($cash_grn, 2); ?></h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 style="margin: 0">CASH Expenses </h4>
                                            </td>
                                            <td>
                                                <h4 style="margin: 0"><small>Rs.</small> <?php echo number_format($ex_cash, 2); ?></h4>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <h4 style="margin: 0">CASH Balance  </h4>
                                            </td>
                                            <td>
                                                <h4 style="margin: 0"><small>Rs.</small> <?php echo number_format($cash - ($ex_cash + $cash_grn), 2); ?></h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                        </div>
                    </div>
                    <!-- /.box-body -->
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