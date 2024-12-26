<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");

$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'tools';
$user_level = $_SESSION['USER_LEWAL'];

$id = $_GET['id'];

?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">

    <?php include_once("start_body.php"); 
  ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <?php 
                                            $r2 =  select('purchases_list', '*', "id='$id'", '');
                                            if ($r2) {
                                                while ($row2 = $r2->fetch()) {
                                                    $name1 = $row2['name'];
                                                }}?>
            <h1>
                <?php echo $name1 ?> details
                <small>Report</small>
            </h1>
        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="box-title me-3">perchase history</h3>

                        </div>
                    </div>
                </div>

                <!-- /.box-header -->

                <div class="box-body">


                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Last perchase date</th>
                                <th>Last perchase QTY</th>

                            </tr>

                        </thead>
                        <tbody>
                            <?php $result = select('purchases_list', '*', "id='$id'", '');

                        if ($result) {
                            while ($row = $result->fetch()) {
                                $id = $row['id'];
                                $approved = $row['approve'];
                                $product_id = $row['product_id'];

                                $innerResult = select('purchases_list', 'MAX(id) AS max_id, date, qty, amount', "product_id='$product_id' AND type='GRN'", '');
                                if ($innerResult) {
                                    while ($innerRow = $innerResult->fetch()) {
                                        $date = $innerRow['date'];
                                        $qty = $innerRow['qty'];
                                        $amount = $innerRow['amount'];
                                        $id4 = $innerRow['max_id']; ?>

                            <?php
                                                    $r2 = select('materials', '*', "id='$product_id'", '');
                                                    if ($r2) {
                                                        while ($row2 = $r2->fetch()) {
                                                            $available = $row2['available_qty'];
                                                            $reorder = $row2['re_order'];
                                                            ?>
                            <tr>
                                <th><?php echo $date  ?></th>
                                <th><?php echo $qty ?></th>
                            </tr>
                            <!-- Edit Popup for each material -->

                            <?php } }}}}}?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="box-title me-3">Quantity Details</h3>

                        </div>
                    </div>
                </div>

                <!-- /.box-header -->

                <div class="box-body">


                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Stock QTY</th>
                                <th>Re oder qty</th>
                                <th>after oder</th>

                            </tr>

                        </thead>
                        <tbody>
                            <?php $result = select('purchases_list', '*', "id='$id'", '');

while ($row = $result->fetch()) {
    $id = $row['id'];
    $approved = $row['approve'];
    $product_id = $row['product_id'];
    $qty1 = $row['qty'];
    $innerResult = select('purchases_list', 'MAX(id) AS max_id, date, qty, amount', "product_id='$product_id' AND type='GRN'", '');
    if ($innerResult) {
        while ($innerRow = $innerResult->fetch()) {
            $date = $innerRow['date'];
            $qty = $innerRow['qty'];
            $amount = $innerRow['amount'];?>

                            <?php
                            $r2 = select('materials', '*', "id='$product_id'", '');
                            if ($r2) {
                                while ($row2 = $r2->fetch()) {
                                    $available = $row2['available_qty'];
                                    $reorder = $row2['re_order'];
                                    ?>
                            <tr>
                                <th><?php echo $available; ?></th>
                                <th><?php echo $reorder  ?></th>
                                <th><?php echo $available+$qty1  ?></th>

                            </tr>

                            <?php }}} }}?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

        <section class="content">
            <div class="box">
                <div class="box-header">
                    <div class="row align-items-center mb-3">
                        <div class="col-md-6 d-flex align-items-center">
                            <h3 class="box-title me-3">Fixing history</h3>

                        </div>
                    </div>
                </div>

                <!-- /.box-header -->

                <div class="box-body">


                    <table id="example1" class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>Job No:</th>
                                <th>Quantity:</th>
                                <th>Date:</th>

                            </tr>

                        </thead>
                        <tbody>
                            <?php $result =  select('fix_materials', '*', "mat_id='$product_id'", '');

if ($result) {
    while ($row = $result->fetch()) {
        $sales_id = $row['sales_list_id'];
        $qty4 = $row['qty'];
        $job_no = $row['job_no'];

        // Fetch last five results
        $inventoryResult = query("SELECT * 
                                    FROM inventory 
                                    WHERE sales_list_id = '$sales_id' 
                                    AND type = 'out' 
                                    ORDER BY date DESC 
                                    LIMIT 5;
                                    ", '');

        if ($inventoryResult) {
            while ($inventoryRow = $inventoryResult->fetch()) {
                $date = $inventoryRow['date'];
                ?>

                            <tr>
                                <th><?php echo $job_no  ?></th>
                                <th><?php echo $qty4 ?></th>
                                <th><?php echo $date ?></th>

                            </tr>

                            <?php } }}}?>
                        </tbody>
                    </table>
                </div>
            </div>

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
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>



    <!-- page script -->
    <script>





    $(function() {
        $("#example1").DataTable({
            "autoWidth": false
        });
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
</body>

</html>