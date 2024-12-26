<!DOCTYPE html>

<html>

<?php
include("../head.php");
include_once("../auth.php");


?>

<body >

    <?php include_once("../start_body.php"); ?>

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
            






            
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">JOB LIST</h3>

                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Company</th>
                                <th>locatin</th>
                                <th>location id</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                          
                            $result = select('job_location','*','m_id= 8 ','');

                            if ($result) {
                               for ($i = 0; $row = $result->fetch(); $i++) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']  ?></td>
                                <td><?php echo $row['company_name']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['location_id']; ?></td>
                                <td><a href="task_view.php?id=<?php echo ($row['location_id'])  ?>"><button class="btn btn-sm btn-info">View</button></a></td>
                               
                            </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='5'>No records found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Main content -->
                </div>
            </div>



        </section>


    </div>


    <?php
    $con = 'd-none';
    ?>


    <!-- /.content-wrapper -->

  

    <!-- /.control-sidebar -->

    <!-- Add the sidebar's background. This div must be placed

       immediately after the control sidebar -->

    <div class="control-sidebar-bg"></div>
    </div>


    


</body>

</html>