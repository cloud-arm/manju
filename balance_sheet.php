<?php
include("head.php");
include_once("auth.php");

$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'balance_sheet';
$user_level = $_SESSION['USER_LEWAL'];

include_once("start_body.php");

// Fetch the date from GET parameters
$date = $_GET['date'] ;

// Initialize variables for storing query results and totals
$invoiceResults = '';
$expensesResults = '';
$invoiceTotal = 0;
$expensesTotal = 0;

// Fetch invoice data
$invoiceResults = select('payment', '*', "pay_type != 'credit' AND date = '$date'");
foreach ($invoiceResults as $row) {
    $invoiceTotal += $row['amount'];
}

// Fetch expenses data
$expensesResults = select('expenses_records', '*', "date = '$date'");
foreach ($expensesResults as $row) {
    $expensesTotal += $row['amount'];
}
?>

<!DOCTYPE html>
<html>
<body class="hold-transition skin-blue skin-orange sidebar-mini">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Tools Details <small>Preview</small></h1>
        </section>

        <!-- Date Selector -->
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
                                <div class="col-lg-8">
                                    <label>Date:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="date" class="form-control" name="date" value="<?php echo htmlspecialchars($date); ?>">
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

        <!-- Invoice Data Section -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Invoice Data</h3>
                </div>
                <div class="box-body">
                    <table id="invoiceTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Payment Method</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $result= select('payment', '*', "pay_type != 'credit' AND date = '$date'"); 
                               for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['invoice_no']; ?></td>
                                        <td>Invoice</td>
                                        <td><?php echo $row['pay_type']; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo number_format($row['amount'], 2); ?></td>
                                    </tr>
                                <?php }
                              { ?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Total Invoice Amount:</strong></td>
                                <td><?php echo number_format($invoiceTotal, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>

        <!-- Expenses Data Section -->
        <section class="content">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Expenses Data</h3>
                </div>
                <div class="box-body">
                    <table id="expensesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Payment Method</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $result = select('expenses_records', '*', "date = '$date'");
                                for ($i = 0; $row = $result->fetch(); $i++) { ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['invoice_no']; ?></td>
                                        <td><?php echo $row['type']; ?></td>
                                        <td><?php echo $row['pay_type']; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><?php echo number_format($row['amount'], 2); ?></td>
                                    </tr>
                                <?php }
                              { ?>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right"><strong>Total Expenses Amount:</strong></td>
                                <td><?php echo number_format($expensesTotal, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <?php include("dounbr.php"); ?>
    <div class="control-sidebar-bg"></div>
    <?php include_once("script.php"); ?>

    <!-- Additional Scripts -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="../../plugins/fastclick/fastclick.js"></script>

    <script>
        $(function() {
            $("#invoiceTable").DataTable({ "autoWidth": false });
            $("#expensesTable").DataTable({ "autoWidth": false });
        });
    </script>
</body>
</html>
