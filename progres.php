<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'index';
?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">
    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                JOB
                <small>Details</small>
            </h1>
            <?php
            $nic = ($_GET['nic']);
            $result = select('sales', '*', 'nic=' . $nic);
            
            if ($row = $result->fetch()) {
                $pro_id = $row['product_id'];
            } else {
                // Handle case where no data is found
                $location = $width = $height = $product_name = 'N/A';
            }
            ?>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <!-- Left column (3-column grid) -->
                    <div class="col-md-12">
                        <div class="box box-info">
                            <div class="box-body">
                                <div>





                                    <?php
                            // Fetch measurement data from the database
                             {
                            ?>



                            <?php 
                            $result4 = select('products', '*', 'id=' . $pro_id);
                            if ($row = $result4->fetch()) { // Corrected $result4 usage
                                $product_id = $row['id'];
                                $product_nm = $row['product_name'];
                                $cat = $row['cat'];
                            }
                            ?>

                            <div class="card shadow-sm" style="margin-top: 20px; border-radius: 15px; background-color: #f9f9f9; padding: 20px;">
                                <div class="card-body text-center">
                                    <h4 class="card-title" style="font-weight: bold; color: #333;"><?php echo $product_nm; ?></h4>
                                    <p class="card-text" style="font-size: 1.2rem; color: #666;">Category: <?php echo $cat; ?></p>
                                </div>
                            </div>





                                    </tr>
                                    <div class="container-up d-none" id="edit_popup_<?php echo $row['id']; ?>">
                                        <div class="row w-70">
                                            <div class="box box-success popup" style="width: 50%;">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Edit details</h3>
                                                    <small onclick="edit_close(<?php echo $row['id']; ?>)"
                                                        class="btn btn-sm btn-success pull-right"><i
                                                            class="fa fa-times"></i></small>
                                                    <i class="fa fa-times"></i>
                                                    </small>
                                                </div>
                                                <div class="box-body d-block">
                                                    <form method="POST" action="edit_job_summery.php">
                                                        <div class="row" style="display: block;">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Width</label>
                                                                    <input type="text" name="width" class="form-control"
                                                                        value="<?php echo $row['width']; ?>" required>

                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>height</label>
                                                                    <input type="text" name="height"
                                                                        class="form-control"
                                                                        value="<?php echo $row['height']; ?>" required>

                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Discription</label>
                                                                    <input type="text" name="about" class="form-control"
                                                                        value="<?php echo $row['about']; ?>" required>

                                                                </div>
                                                            </div>


                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>note</label>
                                                                    <input type="text" name="note" class="form-control"
                                                                        value="<?php echo $row['note']; ?>" required>

                                                                </div>
                                                            </div>
                                                            <?php if($status != 'measure' && $status != 'artwork'){ ?>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Designer note</label>


                                                                    <input type="text" name="art_note"
                                                                        class="form-control"
                                                                        value="<?php echo $row['art_note']; ?>"
                                                                        required>

                                                                </div>
                                                            </div>
                                                            <?php } ?>






                                                            <div class="col-md-12">

                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="unit" value="1">
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $row['id']; ?>">

                                                                    <input type="submit"
                                                                        style="margin-top: 23px; width: 100%;"
                                                                        value="Save" class="btn btn-info btn-sm">
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div><br></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" align="center">
                        <button class="btn btn-info" style="width: 150px; height: 25px; font-size: 10px; "
                            onclick="window.location.href='index.php'">
                            Back
                        </button>
                    </div>

                </div>
                <!-- Right column (9-column grid) -->







                <div class="col-md-9">
                    <div class="col-md-12">
                        <ul class="timeline">
                            <li>
                                <?php
                                    $nic =  ($_GET['nic']);
                                    $result = select('visit', '*', 'nic=' . $nic);
                                    if ($row = $result->fetch()) {
                                        $id = $row['id'];
                                        $address = $row['address'];
                                        $phone = $row['phone'];
                                        $nic = $row['nic'];
                                        $date = $row['date'];
                                        $employee = $row['employee'];
                                        $name = $row['name'];
                                        $time = $row['time'];
                                        $product_id = $row['product_id'];

        
                                    }
                                    ?>
                                <i class="fa fa-check-circle bg-yellow"></i>
                                <div class="timeline-item">
                                    <?php 
                                     $date='0000-00-00'; $time='00:00:00';
                    
                                        

                                        
                                    ?>

                                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo $date.' | '.$time?>
                                    </span>
                                    <h3 class="timeline-header">
                                        <a href="#">Visit Done For</a> <?php echo $employee?>
                                    </h3>


                                    <!-- MEASUREMENT shows -->
                                    <div class="timeline-body">
                                        <p>visits done by:</p>
                                        <p><strong>Adress:</strong> <?php echo $address ?>, <strong>phone:</strong>
                                            <?php echo $phone ?>, <strong>nic:</strong> <?php echo $nic ?></p>
                                        <p><strong class="text-primary">Customer name:</strong>
                                            <?php echo $name ?></p>

                                    </div>

                                    <div class="timeline-footer"
                                        style="display: flex; justify-content: space-between; align-items: center;">
    

                                        <div style="margin-left: auto; font-size: 12px; color: #555;">
                                            <?php 
                                    

                                    
                                    // Check if $user_name has a value; if not, set it to "Not set"
                                ?>

                                        </div>

                                    </div>


                                </div>
                            </li>

                            <?php 
                                    $nic = $_GET['nic'];

                                    // Fetch sales details for the given NIC
                                    $result1 = select_item('sales', 'nic', 'nic=' . $nic);

                                    if($result1 != null){

                                    
                                    ?>

                            <li>
    <?php
        // Get NIC from the query parameter
        $nic = $_GET['nic'];

        // Fetch sales details for the given NIC
        $result = select('sales', '*', 'nic=' . $nic);

        // Initialize variables with default values to avoid undefined errors

        if ($row = $result->fetch()) {
            $id = $row['id'];
            $balance = $row['balance'];
            $amount = $row['amount'];
            $down_payment = $row['down_payment'];
            $invoice_no = $row['invoice_no'];
            $nic = $row['nic'];
            $date = $row['date'];
            $mpo_name = $row['emp_name'];
            $time = $row['time'];
            $product_name = $row['product_name'];
            $pay_type = $row['pay_type'];
            $card_number = $row['card_number'];
        }
    ?>

    <i class="fa fa-check-circle bg-yellow"></i>
    <div class="timeline-item border border-primary rounded p-3 mb-3">
        <!-- Display timestamp -->
        <span class="time text-muted d-flex align-items-center">
            <i class="bi bi-clock me-2"></i> 
            <?php echo $date . ' | ' . $time; ?>
        </span>

        <!-- Header -->
        <h3 class="timeline-header mt-3 mb-2">
            <a href="#" class="text-primary">Sales Done For:</a> <?php echo htmlspecialchars($product_name); ?>
        </h3>

        <!-- Sales Details -->
        <div class="timeline-body">
            <p><strong><i class="bi bi-person-fill me-2"></i>MPO Name:</strong> <?php echo htmlspecialchars($mpo_name); ?></p>
            <p><strong><i class="bi bi-person-badge-fill me-2"></i>NIC:</strong> <?php echo htmlspecialchars($nic); ?> , <strong><i class="bi bi-receipt me-2"></i>Invoice No:</strong> <?php echo htmlspecialchars($invoice_no); ?></p>
            <p><strong><i class="bi bi-currency-dollar me-2"></i>Down Payment:</strong> <?php echo htmlspecialchars($down_payment); ?></p>
            <p><strong><i class="bi bi-receipt me-2"></i>Invoice No:</strong> <?php echo htmlspecialchars($invoice_no); ?></p>
            <p><strong><i class="bi bi-credit-card me-2"></i>Payment Details</strong></p>
            <ul>
                <li><strong>Payment Type:</strong> <?php echo htmlspecialchars($pay_type); ?></li>
                <li><strong>Balance:</strong> <?php echo htmlspecialchars($balance); ?></li>
                <li><strong>Amount:</strong> <?php echo htmlspecialchars($amount); ?></li>
            </ul>
        </div>

        <!-- Footer -->

    </div>
</li>


<li>
    <?php
    // Get NIC from the query parameter
    $nic = $_GET['nic'];
    // Fetch sales details for the given NIC
    $result = select('fix', '*', 'project_number=' . $card_number);

    // Initialize variables with default values to avoid undefined errors
    $id = $imi_no = $project_number = $tds_value = $water_source = $nic = $date = $tech_id = $time = 'N/A';

    if ($row = $result->fetch()) {
        $id = $row['id'];
        $imi_no = $row['imi_no'];
        $project_number = $row['project_number'];
        $tds_value = $row['tds_value'];
        $water_source = $row['water_source'];
        $nic = $row['nic'];
        $date = $row['date'];
        $tech_name = $row['tech_name'];
        $time = $row['time'];
    }
    ?>

    <i class="fa fa-check-circle bg-yellow"></i>
    <div class="timeline-item">
        <!-- Display timestamp -->
        <span class="time">
            <i class="fa fa-clock-o"></i> <?php echo htmlspecialchars($date) . ' | ' . htmlspecialchars($time); ?>
        </span>

        <!-- Header -->
        <h3 class="timeline-header">
            <a href="#">Fix done for project no:</a>
            <span class="text-primary"><?php echo htmlspecialchars($project_number); ?></span>
        </h3>

        <!-- Sales Details -->
        <div class="timeline-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>IMI Number:</strong> <?php echo htmlspecialchars($imi_no); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>TDS Value:</strong> <?php echo htmlspecialchars($tds_value); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>NIC:</strong> <?php echo htmlspecialchars($nic); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Water Source:</strong> <?php echo htmlspecialchars($water_source); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Technician :</strong> <?php echo htmlspecialchars($tech_name); ?></p>
                </div>
            </div>
        </div>

        <!-- Footer -->

    </div>
</li>






<?php if ($pay_type == "Credit") { ?>




                            <li>
                                <?php 
        $date = '0000-00-00'; 
        $time = '00:00:00';
        
        // Check if $user_name or $display_name has a value; set a fallback value if not
        $display_name = isset($display_name) ? $display_name : "Not set";

        // Ensure $id is defined to avoid errors
        $id = isset($id) ? $id : 0;

        // Variable to count rows
        $i = 0;
    ?>
                                <i class="fa fa-wrench bg-maroon"></i>
                                <div class="timeline-item">
                                    <span class="time">
                                        <i class="fa fa-clock-o"></i> <?php echo $date . ' | ' . $time; ?>
                                    </span>
                                    <h3 class="timeline-header"><a href="#">Credit Payment Process</a></h3>

                                    <div class="box-body">
                                        <table id="example2" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>pay_date</th>
                                                    <th>customer_name</th>
                                                    <th>amount</th>
                                                    <th>balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                    // Fetch fix materials data from the database
                    if (function_exists('select')) {
                        $result = select('credit_collection', '*', 'project_number=' . $id);
                        
                        if ($result) {
                            while ($row = $result->fetch()) { 
                                $i++;
                    ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo htmlspecialchars($row['pay_date']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['amount']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['balance']); ?></td>
                                                </tr>
                                                <?php 
                            } 
                        } else {
                            echo '<tr><td colspan="5">No data available</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="5">Database function "select" is not defined</td></tr>';
                    }
                    ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <hr>

                                    <div class="timeline-footer"
                                        style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="margin-left: auto; font-size: 12px; color: #555;">
                                            <span class="time">
                                                <i class="fa fa-user" style="margin-right: 5px;"></i> done by
                                                <?php echo htmlspecialchars($display_name); ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </li>


                            <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>




                </div>
                <!-- MEASUREMENT -->

            </div>
    </div>

    <!-- Location -->


    </section>
    <!-- /.content -->

    <!-- /.content-wrapper -->
    <?php include("dounbr.php"); ?>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
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

    <script>
    function edit_note(i) {
        //  $(".popup").addClass("d-none");
        $("#edit_popup_" + i).removeClass("d-none");
    }

    function edit_close(i) {
        //  $(".popup").addClass("d-none");
        $("#edit_popup_" + i).addClass("d-none");
    }

    function pro_select() {
        // Get the selected product ID from the #mat_id dropdown
        let productId = $('#mat_id').val();

        // New AJAX call to fetch units for selected product
        $.ajax({
            type: "GET",
            url: "get_units.php",
            data: {
                mat_id: productId
            },
            success: function(response) {
                // Populate the Unit selector with the received options
                $("#unit").empty();
                $("#unit").append(response);
            },
            error: function() {
                alert("Error fetching unit data");
            }
        });
    }



    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            // Redirect to a PHP page that handles the deletion
            window.location.href = 'process_dill.php?id=' + id;
        }
    }


    function confirmDelete2(id) {
        if (confirm('Are you sure you want to delete this item?')) {
            // Redirect to a PHP page that handles the deletion
            window.location.href = 'delete_fix.php?id=' + id;
        }
    }








    function click_open(i) {
        $(".popup").addClass("d-none");
        $("#popup_" + i).removeClass("d-none");
        $("#container_up").removeClass("d-none");

        if (i == 2) {
            $('#txt_icon').focus();
        }
        if (i == 3) {
            $('#txt_sec').focus();
        }
        if (i == 4) {
            $('#txt_perm').focus();
            $('#txt_perm').select();
        }
    }

    function click_close(i) {
        if (i) {
            $(".popup").addClass("d-none");
            $("#container_up").addClass("d-none");
        } else {
            $(".popup").addClass("d-none");
            $("#popup_1").removeClass("d-none");
        }
    }
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