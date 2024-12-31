<!DOCTYPE html>
<html>
<?php
include("head.php");
include("connect.php");
?>

<body class="hold-transition skin-yellow sidebar-mini">
    <div class="wrapper" style="overflow-y: hidden;">
        <?php
        include_once("auth.php");
        $r = $_SESSION['SESS_LAST_NAME'];
        $_SESSION['SESS_FORM'] = '14';

        include_once("sidebar.php");
        ?>

        <?php $id = $_GET['id']; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    EMI
                    <small>Preview</small>
                </h1>
            </section>


            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                    <div class="box box-warning">
                        <form method="POST" action="emi_save.php">
                        <div class="row mt-3 align-items-center  box-body">
                                <div class="col-md-6">
                                <div class="form-group">
                                            <label class="col-sm-8 control-label">Emi Number</label>
                                            <div class="">
                                                <input type="text" class="form-control" name="emi_no" value="" autocomplete="off">
                                            </div>
                                        </div>
                                </div>

                                <div class="col-md-2">
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                                <input type="submit" style="margin-top: 26px; width: 100%;"
                                value="Add" class="btn btn-info btn-sm">
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-header">
                                    <h3 class="box-title">Emi List</h3>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body">
                                    <table id="example2" class="table table-bordered table-striped">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>EMI No</th>
                                                <th>Time</th>
                                            </tr>

                                        </thead>
                                            <?php 
                                                $result = query("SELECT * FROM imi_no WHERE date = '$date' AND purchase_list_id = '$id'");
                                                for ($i = 0; $r01 = $result->fetch(); $i++) {
                                                    $imi_no = $r01['imi_no'];
                                                    $date = $r01['date'];
                                                    $id = $r01['id'];
                                                    $time = $r01['time'];
                                                    ?>

                                                    <tr>
                                                    <td><?php echo $id; ?></td>
                                                    <td><?php echo $date; ?></td>
                                                    <td><?php echo $imi_no; ?></td>
                                                    <td><?php echo $time; ?></td>
                                                    </tr>

                                              <?php } ?>
                                           
                                        <tbody>
                                            
                                        </tbody>
                                        <tfoot>
                                           
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        <!-- /.box -->
                    </div>
                </div>
                <!-- /.box -->
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

    <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="../../plugins/select2/select2.full.min.js"></script>
    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- Dark Theme Btn-->
    <script src="https://dev.colorbiz.org/ashen/cdn/main/dist/js/DarkTheme.js"></script>
    <!-- page script -->
    <script>
        $(function() {
            $(".select2").select2();
            $('.select2.hidden-search').select2({
                minimumResultsForSearch: -1
            });

            $("#example1").DataTable();
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