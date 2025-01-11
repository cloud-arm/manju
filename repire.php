<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'unit';
$_SESSION['SESS_DEPARTMENT'] = 'Transport';
date_default_timezone_set("Asia/Colombo");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = 0;
}
?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">

    <?php include_once("start_body.php"); ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Vehicle Repire
                <small>Preview</small>
            </h1>

        </section>

        <!-- add item -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">

                    <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">Repire details</h3>
                            </div>

                            <div class="box-body d-block">

                                <form method="POST" action="save/repair_save.php" class="w-100">

                                    <div class="row">

                                    <div class="col-md-3">
            <div class="form-group">
            <?php $result = select('vehicles','*','id='.$id);
                                                for ($i = 0; $row = $result->fetch(); $i++) { 
                                                $number=$row['number'];
                                                }
                                                ?>  
                <label>Vehicle number</label>
                <input type="text" name="veh_no" class="form-control" value="<?php echo htmlspecialchars($number); ?>" readonly>
            </div>
        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>repair type</label>
                                                <select name="re_type" id="select2" class="form-control select2" >   
                                                <?php $result = select('repair_type');  
                                                for ($i = 0; $row = $result->fetch(); $i++) { 
                                                ?>    
                                                 <option value="<?php echo $row['id']  ?>"><?php echo $row['name']  ?></option>
                                                <?php } ?>
                                                </select>
                                            </div>
                                        </div>



                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Value</label>
                                                <input type="text" name="value" class="form-control" autocomplete="off" required>
                                            </div>
                                        </div>

                                        
                                        

                                        <div class="col-md-2" style="height: 75px;display: flex; align-items: end;">
                                            <div class="form-group">
                                                <input type="hidden" name="id" value="0">
                                                <input type="hidden" name="id2" value="<?php echo $id; ?>" >

                                                <input type="submit" value="Save" class="btn btn-success">
                                            </div>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>

                   


                </div>

                <div class="col-md-12">

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Repire history</h3>
                        </div>
                        <div class="box-body d-block">
                            <table id="example2" class="table table-bordered ">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>type</th>
                                        <th>number</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php

                                    $result = query("SELECT * FROM repair WHERE number='$number' ORDER BY id DESC");
                                    for ($i = 0; $row = $result->fetch(); $i++) {  ?>

                                        <tr class="record">
                                            <td><?php echo $row['id'];?> </td>
                                            <td><?php echo $row['type_name'];?></td>
                                            <td><?php echo $row['number'];?></td>

                                            

                                        </tr>

                                    <?php }   ?>
                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>

    <!-- /.content-wrapper -->
    <?php include("dounbr.php"); ?>

    <div class="control-sidebar-bg"></div>
    </div>

    <?php include_once("script.php"); ?>

    <!-- DataTables -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables/dataTables.bootstrap.min.js"></script>
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

            $(".dll_btn").click(function() {
                var element = $(this);
                var id = element.attr("id");
                var info = 'id=' + id;
                if (confirm("Sure you want to delete this Collection? There is NO undo!")) {

                    $.ajax({
                        type: "GET",
                        url: "grn_supply_dll.php",
                        data: info,
                        success: function() {

                        }
                    });
                    $(this).parents(".record").animate({
                            backgroundColor: "#fbc7c7"
                        }, "fast")
                        .animate({
                            opacity: "hide"
                        }, "slow");
                }
                return false;
            });

        });

        $(function() {
            $("#example1").DataTable();
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
        });
    </script>


    <!-- Page script -->
    <script>
        $(function() {
            //Initialize Select2 Elements
            $(".select2").select2();

            //Date range picker
            $('#reservation').daterangepicker();
            //Date range picker with time picker
            //$('#datepicker').datepicker({datepicker: true,  format: 'yyyy/mm/dd '});
            //Date range as a button


            //Date picker
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


        });
    </script>


</body>

</html>