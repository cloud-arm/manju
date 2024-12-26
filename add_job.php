<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'index';
?>
<style>
    .floating-element{
        transition: transform 0.2s ease; /* Smooth transition */
    }
</style>
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

        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <div  id="element1">
                    <div class="box box-info">
                        <div class="box-body">

                            <div style=" margin: 20px;">
                                <div class="row <?php if($action==1){echo "text-selecter";} ?>">
                                    <div class="col-md-1"><label class="<?php if($action > 1){echo "text-green";} ?>"><i
                                                class="fa fa-circle-o"></i></label></div>
                                    <div class="col-md-9 "><label>COMPANY DETAILS</label></div>
                                </div><br>
                                <div class="row <?php if($action==2){echo "text-selecter";} ?>">
                                    <div class="col-md-1"><label class="<?php if($action > 2){echo "text-green";} ?>"><i class="fa fa-circle-o"></i></label></div>
                                    <div class="col-md-9 "><label>PRODUCT SELECTION</label></div>
                                </div><br>
                                <div class="row <?php if($action==3){echo "text-selecter";} ?>">
                                    <div class="col-md-1"><label class="<?php if($action > 3){echo "text-green";} ?>"><i class="fa fa-circle-o"></i></label></div>
                                    <div class="col-md-9 "><label>PROSESING</label></div>
                                </div><br>
                                <div class="row <?php if($action==4){echo "text-selecter";} ?>">
                                    <div class="col-md-1"><label class="<?php if($action > 4){echo "text-green";} ?>"><i class="fa fa-circle-o"></i></label></div>
                                    <div class="col-md-9 "><label>PRICEING </label></div>
                                </div><br>
                                <div class="row <?php if($action==5){echo "text-selecter";} ?>">
                                    <div class="col-md-1"><label><i class="fa fa-circle-o"></i></label></div>
                                    <div class="col-md-9 "><label>PAYMENT </label></div>
                                </div>

                                <!-- DONUT CHART -->
                                

                                <?php
                            // Assuming you already have a valid database connection
                            // Assuming $id is already set to the current job_no

                            // Fetching details from the sales_list table for the given job_no

                            // Loop through all rows in the sales_list table for the given job_no
                            while ($row = $result->fetch()) {
                                $approvel_doc = $row['approvel_doc'];
                                $app_note = $row['approvel_note'];  
                                $m_img = $row['m_img'];
                                $sales_list_id = $row['id']; // Get the sales_list table ID
                            }

                            // Query to count jobs for each status_id in a specific job_no
                            $query = "SELECT status_id, COUNT(*) AS total_jobs
                                    FROM sales_list
                                    WHERE job_no = :id
                                    GROUP BY status_id";

                            $stmt = $db->prepare($query);

                            // Prepare data for the chart
                            $status_counts = [0, 0, 0, 0, 0, 0];  // Default counts for [measure, artwork, on_approval, printing, fix, complete]
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $status_id = (int)$row['status_id'];
                                if (isset($status_counts[$status_id])) {
                                    $status_counts[$status_id] = (int)$row['total_jobs'];  // Set the count for each status
                                }
                            }

                            // Pass the status counts to JavaScript for rendering the donut chart
                            echo "<script>
                                var pieData = " . json_encode($status_counts) . ";
                            </script>";
                            ?>
                            </div>
                    </div>
                    </div>


                             <?php if($action >= 3){ ?>

                            


                                <div class="box box-info">
                                <div class="box-body">

                            <form method="POST" action="save/job/job_appr_pic_save.php?id=<?php echo $id?>"
                                enctype="multipart/form-data">


                                <div class="form-group">
                                    <label for="document">Upload Approved (PNG or JPG)</label>
                                    <input type="file" name="document" class="form-control"
                                        accept=".pdf,.jpg,.jpeg,.png" required>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Add Approved photos" class="btn btn-info btn-sm"
                                        style="width: 100%;">
                                </div>
                            </form>





                            <div style="margin: 20px;">
                                <h4>Approved document photo</h4>
                                <?php
                                    // Assuming $id is already set to the current job_no
                                    $result = select('img_hub', '*', 'job_no=' . $id . ' AND type = "approve_img"');

                                    // Loop through all rows in the img_hub table for the given job_no and type = "approve_img"
                                    while ($row = $result->fetch()) {
                                        $photo_name = $row['name'];  // Fetch the photo name from the 'name' column
                                        $img_hub_id = $row['id'];  // Get the img_hub table ID for reference
                                    ?>
                                <div style="display: inline-block; vertical-align: top; margin-right: 10px;">
                                    <strong>Approved Photo:</strong><br>
                                    <?php if (!empty($photo_name)) { ?>
                                    <!-- Display the photo -->
                                    <a href="app/save/uploads/product_img/<?php echo $photo_name; ?>" target="_blank">
                                        <img src="app/save/uploads/product_img/<?php echo $photo_name; ?>"
                                            alt="Uploaded Photo" style="width: 200px; height: auto;">
                                    </a>
                                    <br>
                                    <!-- View Button -->
                                    <a href="view_photo_approve.php?id=<?php echo $img_hub_id; ?>"
                                        style="margin-top: 10px;" target="_blank">View</a>
                                    <?php } else { ?>
                                    <?php } ?>
                                </div>
                                <?php } ?>
                            </div>
                            </div>
                            </div>
                        



                            
                            <div class="box box-info">
                                <div class="box-body"></div>

                            <div style="height: 350px;">
                            <canvas id="pieChart" ></canvas></div>
                            
                            </div>
                        
                        <?php } ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <!-- location -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3>Costomer Details <small> Add</small></h3>
                        </div>
                        <div class="box-body">
                            <form action="save/job/add_job_save.php" method="post">
                                <div class="row">


     
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Costomer Name</label>
                                            <input type="text" id="cus_name" class="form-control" name="name" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label>Nic name</label>
                                            <input type="text" class="form-control" id="nic_name" name="nic_name" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" id="cus_address" name="address" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" >
                                            <label>nic </label>
                                            <input type="text" id="nic_input"  class="form-control" name="id_no" onchange="find_cus()" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Mobile No</label>
                                            <input type="text" class="form-control" id="cus_phone_no" name="mobile" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Filter ID</label>
                                            <input type="text" class="form-control" name="filter_id" style="width: 100%;"
                                                >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="text" class="form-control" name="date" style="width: 100%;"
                                                >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="text" class="form-control" name="amount" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sales Name</label>
                                            <input type="text" class="form-control" name="sales_name" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sales Id</label>
                                            <input type="text" class="form-control" name="sales_id" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sales phone no</label>
                                            <input type="text" class="form-control" name="sales_phone" style="width: 100%;"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Macanic Name</label>
                                            <input type="text" class="form-control" name="mac_name" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Macanic Id</label>
                                            <input type="text" class="form-control" name="mac_id" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Machanic phone no</label>
                                            <input type="text" class="form-control" name="mac_phone" style="width: 100%;"
                                                >
                                        </div>
                                    </div>

       

                                  <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Details</label>
                                            <input type="text" class="form-control" name="road" style="width: 100%;"
                                                >
                                        </div>
                                    </div>




                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="submit" style="margin-top: 23px; width: 100%;" id="u3"
                                                value="Save" class="btn btn-info btn-sm">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                                 <!-- location -->
                                        <div class="box box-info">
                        <div class="box-header">
                            <h3>Road Mapping <small> Add</small></h3>
                        </div>
                        <div class="box-body">
                            <form action="save/job/job_product_save.php" method="post">
                                <div class="row">


     
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Details</label>
                                            <input type="text" class="form-control" name="about" style="width: 100%;"
                                                required>
                                        </div>
                                    </div>




 


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Machanic phone no</label>
                                            <input type="text" class="form-control" name="about" style="width: 100%;"
                                                required>
                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="submit" style="margin-top: 23px; width: 100%;" id="u3"
                                                value="Save" class="btn btn-info btn-sm">
                                        </div>
                                    </div>
                                </div>
                            </form>


                        </div>

                    </div>
                    <!-- location -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3>MEASURER <small>Assigning</small></h3>
                        </div>
                        <div class="box-body <?php if($action >= 3) {} else { echo 'd-none'; } ?>">
                            <form action="save/job/job_supervisor.php" method="post">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <select class="form-control select2 " id="m_id" name="m_id"
                                                style="width: 100%;" autofocus>
                                                <?php 
                                                    $result = select('employee', '*', '');
                                                    while ($row = $result->fetch()) {  
                                                    ?>
                                                <option value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['username']; ?>
                                                </option>
                                                <?php 
                                                } 
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Location</label>
                                            <select class="form-control select2 hidden-search" id="location_id"
                                                name="location_id" style="width: 100%;" autofocus>
                                                <?php 
                                                    $result = select('job_location', '*', 'job_id=' . $id);
                                                    while ($row = $result->fetch()) {  
                                                    ?>
                                                <option value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['name']; ?>
                                                </option>
                                                <?php 
                                              } 
                                              ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="unit" value="1">
                                            <input type="submit" style="margin-top: 23px; width: 100%;" id="u4"
                                                value="Save" class="btn btn-info btn-sm">
                                        </div>
                                    </div>
                                    <input type="hidden" name="job_no" value="<?php echo $id; ?>">
                                </div>

                                <!-- Table to display job location details -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="example2" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Branch Name</th>
                                                    <th>Measurer Name</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $result = select('job_location', '*', 'job_id='.$id);
                                                while ($row = $result->fetch()) { ?>
                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['name']; ?></td>
                                                    <?php
                                                        $employeeResult = select('employee', '*', 'id='.$row['m_id']);
                                                        $employee = $employeeResult->fetch();
                                                        ?>
                                                    <td><?php echo $employee['username']; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>

                        

                    </div>
                    <?php if($user_level == '5' || $user_level == '1'){ ?>
                    <div class="box box-info">
                        <div class="box-header">
                            <h3>Price <small>Generate</small></h3>
                        </div>

                        <div class="box-body <?php if ($action >= 4) {} else { echo 'd-none'; } ?>">
                            <?php
                        $result = select('sales_list', '*', "job_no = $id AND status != 'reject' AND status != 'delete'", '');
                        if ($result) {
                                    $row = $result->fetch();
                                    if ($row) {
                                        $price = $row['price'];
                                        $qty = $row['qty'];
                                        $id1 = $row['id'];
                                    }
                                }
                                ?>

                            <form action="save/job/amount_save.php" method="post">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label>Job List</label>
                                            <select class="form-control select2 " id="price_item" name="id"
                                                style="width: 100%;" onchange="price_type();" autofocus>
                                                <?php 
                                            $result = select('sales_list', '*', "job_no = $id AND status != 'reject' AND status != 'delete' ", '');
                                            while ($row = $result->fetch()) {  
                                                    ?>
                                                <option pro_type="indirect" value="<?php echo $row['id']; ?>"
                                                    <?php if($row['id'] == $id1) echo 'selected'; ?>>
                                                    <?php echo $row['name'].' ['.$row['about'].'] '.number_format($row['width']).'X'.number_format($row['height']); ?>
                                                </option>
                                                <?php } ?>
                                            <?php 
                                            $result=select('products','*',"type='direct_selling'");
                                            while ($row = $result->fetch()) { 
                                            ?>
                                            <option pro_type="direct" value="<?php echo $row['id']  ?>"><?php echo $row['product_name'];  ?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2" id="qty_input" style=" display: none;">
                                        <div class="form-group">
                                            <label>QTY</label>
                                            <input type="text" class="form-control"  name="qty"
                                                value="1">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                value="0">
                                        </div>
                                    </div>

                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <input type="submit" style="margin-top: 23px; width: 100%;" id="u5"
                                                value="Save" class="btn btn-info btn-sm">
                                        </div>
                                    </div>
                                    <input type="hidden" value="<?php echo $id; ?>" name="job_no">
                                    <input type="hidden" value="indirect" name="type" id="pricing_type">
                                </div>
                                </form>

<div class="row">
    <div class="col-md-12">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Location</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                                $totalAmount = 0;
                                $totaljobs = 0; // Initialize totaljobs
                                $result = select('sales_list', '*', 'job_no = ' . $id . '');
                                while ($row = $result->fetch()) { 
                                    $totalAmount += $row['amount']; // Sum the amounts
                                    $amount = number_format($row['amount'], 2); // Format the amount
                
                                    if ($amount == 0) {
                                        $totaljobs += 1; // Increment totaljobs
                                    }
                                } ?>
                <?php
                $totalAmount = 0;
                $result = select('sales_list', '*', 'job_no = ' . $id . ' AND amount > 0');
                while ($row = $result->fetch()) { 
                    $totalAmount += $row['amount']; // Sum the amounts


                ?>
                <tr>
                    <td><?php echo $row['location']; ?></td>
                    <td>
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <span><?php echo $row['name']; ?></span>
                            <div align="center">
                                <?php if (!empty($row['about'])): ?>
                                <div class="badge bg-green">
                                    <?php echo $row['about']; ?>
                                </div>
                                <br>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $row['qty']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Total Amount</th>
                    <th colspan="2"></th>
                    <th><?php echo $totalAmount; ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php if ($totaljobs > 0): ?>
<div class="alert alert-danger">
    <strong>Error:</strong> There are <?php echo $totaljobs; ?> jobs with zero amount. Please check before generating the invoice.
</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="text-right">
            <?php
            // Fetch the pay_type from the sales table for the current job_no
            $result = select('sales', '*', 'job_no = ' . $id);

            // Initialize variable for pay_type
            $type = '';

            // Fetch the pay_type from the database if the record exists
            if ($result) {
                while ($row = $result->fetch()) {
                    $type = $row['pay_type'];
                }
            }

            // Check if the pay_type is 'credit'
            if ($type === 'credit') { ?>
            <div class="btn-group">
                <button type="button" onclick="location.href = 'save/print.php?id=<?php echo base64_decode($_GET['id']); ?>' "
                    class="btn btn-default btn-flat" style="border-radius: 10px 0px 0px 10px">Print</button>
                <button type="button" class="btn btn-default btn-flat dropdown-toggle" data-toggle="dropdown"
                    style="border-radius: 0px 10px 10px 0px">
                    <span class="caret"></span>
                    <span class="sr-only">Format</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="save/print.php?id=<?php echo base64_decode($_GET['id']); ?>&type=location">Location</a></li>
                    <li><a href="save/print.php?id=<?php echo base64_decode($_GET['id']); ?>">Product</a></li>
                </ul>
            </div>
            <?php } else { ?>
            <a href="javascript:void(0);" onclick="confirmInvoiceGeneration('<?php echo base64_decode($_GET['id']); ?>');">
                <button class="btn btn-sm btn-info" id="generate_invo">Generate Invoice</button>
            </a>
            <?php } ?>
        </div>
    </div>
</div>
</div>
</div>

                    <div class="box box-info">
                        <div class="box-header">
                            <h3>Payment <small>section</small></h3>
                        </div>

                        <div class="box-body <?php if ($action >= 5) {} else { echo 'd-none'; } ?>">
                            <?php
                        $result = select('sales_list', '*', "job_no = $id AND status != 'reject' AND status != 'delete'", '');
        if ($result) {
            $row = $result->fetch();
            if ($row) {
                $price = $row['price'];
                $qty = $row['qty'];
                $id1 = $row['id'];
            }
        }
        ?>

                            <form action="save/job/payment_save.php" method="post">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pay_type">Type</label>
                                            <select name="pay_type" class="form-control" onchange="select_pay()"
                                                id="pay_type" required>
                                                <option value="">Select type</option>
                                                <option value="card">Card</option>
                                                <option value="cash">Cash</option>
                                                <option value="chq">Cheque</option>
                                                <option value="Bank">Bank</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Pay Amount</label>
                                            <input class="form-control" step="0.01" min="0"  type="number" name="amount" autocomplete="off"
                                                required>
                                        </div>
                                    </div>

                                    <div class="col-md-3 slt-chq" style="display:none;">
                                        <div class="form-group">
                                            <label>Chq Number</label>
                                            <input class="form-control" type="text" name="chq_no" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3 slt-chq" style="display:none;">
                                        <div class="form-group">
                                            <label>Chq Date</label>
                                            <input class="form-control" id="datepicker1" type="text" name="chq_date"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3 slt-chq" style="display:none;">
                                        <div class="form-group">
                                            <label>Bank</label>
                                            <input type="text" class="form-control" id="bank_name" name="bank_name"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3 slt-bank" style="display:none;">
                                        <div class="form-group">
                                            <label>Bank</label>
                                            <input type="text" class="form-control" id="bank_name" name="bank_name"
                                                autocomplete="off">
                                        </div>
                                    </div>

                                    <input type="hidden" name="id" value="<?php echo base64_decode($_GET['id']); ?>">

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="submit" style="margin-top: 23px; width: 100%;" id="u8"
                                                value="Save" class="btn btn-info btn-sm">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="example2" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th>Chq No</th>
                                                    <th>Chq Date</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $result = select('payment', '*', 'job_no = ' . $id);
                                                while ($row = $result->fetch()) { ?>
                                                <tr>
                                                    <td><?php echo $row['pay_type']; ?></td>
                                                    <td><?php echo $row['chq_no']; ?></td>
                                                    <td><?php echo $row['chq_date']; ?></td>
                                                    <td>
                                                        <div style="display: flex; align-items: center;">
                                                            <span
                                                                style="margin-right: 5px;"><?php echo $row['amount']; ?></span>
                                                            <?php if ($row['pay_type'] == 'credit') { ?>
                                                            <div
                                                                style="display: flex; align-items: center; justify-content: center;">
                                                                <div class="badge bg-blue"
                                                                    style="display: inline-block; margin-left: 5px;">
                                                                    <?php echo $row['credit_balance']; ?>
                                                                </div>
                                                            </div>
                                                            <?php } ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <?php
                    $totalpayAmount = 0;
                    $result = select('payment', '*', 'job_no = ' . $id . ' AND pay_type != "credit"');
                    while ($row = $result->fetch()) {
                        $totalpayAmount += $row['amount'];
                    }
                    ?>

                                        <h5>Total Amount: <?php echo $totalAmount; ?></h5>
                                        <h5>Pay Amount: <?php echo $totalpayAmount; ?></h5>
                                        <h5>Balance: <?php echo $totalAmount - $totalpayAmount; ?></h5>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>


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

    <!-- Select2 -->
    <script src="../../plugins/select2/select2.full.min.js"></script>

    <!-- date-range-picker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <script>

function find_cus(){
    var nic_input = document.getElementById('nic_input').value;
   
    var data = 'ur';
        fetch("customer_data_get.php?nic_input=" + nic_input)
            .then((response) => response.json())
            .then((json) => fill(json));
}

function fill(json) {
        console.log(json);

        if (json.action == "true") {
            console.log("old patient");
            document.getElementById('cus_name').value = json.cus_name;
            document.getElementById('cus_address').value = json.cus_address;
            document.getElementById('phone').value = json.cus_phone_no;
            document.getElementById('cus_id').value = json.cus_id;


            document.getElementById('cus_name').disabled = true;
            document.getElementById('cus_address').disabled = true;
            

            document.getElementById('cus_name').style= 'border: 1px solid #0cc40f';
            document.getElementById('cus_address').style= 'border: 1px solid #0cc40f';
            document.getElementById('phone').style= 'border: 1px solid #0cc40f';


        } else {
            console.log("new patient");
            document.getElementById('cus_name').value = '';
            document.getElementById('cus_address').value = '';
            document.getElementById('cus_id').value = '0';


            document.getElementById('cus_name').disabled = false;
            document.getElementById('cus_address').disabled = false;
            document.getElementById('phone').disabled = false;

            document.getElementById('cus_name').style= 'border: 1px solid ';
            document.getElementById('cus_address').style= 'border: 1px solid ';
            document.getElementById('phone').style= 'border: 1px solid ';

        }
    }
    </script>



    <script>
    // Calculate total and create labels with percentages
    var total = pieData.reduce((acc, val) => acc + val, 0);

    var pieLabels = ["Measure", "Artwork", "On Approval", "Printing", "Fix", "Complete"].map(function(label, index) {
        var percentage = ((pieData[index] / total) * 100).toFixed(2);
        return label + ' (' + percentage + '%)';
    });

    // Get the context of the canvas where the chart will be drawn
    var pieChartCanvas = document.getElementById("pieChart").getContext("2d");

    // Create the doughnut chart
    var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: {
            labels: pieLabels, // Add labels with percentages
            datasets: [{
                data: pieData, // Actual data values from server
                backgroundColor: ["#f56954", "#f39c12", "#00c0ef", "#3c8dbc", "#d2d6de", "#00a65a"],
                hoverBackgroundColor: ["#f56954", "#f39c12", "#00c0ef", "#3c8dbc", "#d2d6de", "#00a65a"]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutoutPercentage: 60, // Adjust this for the size of the inner hole (50% makes it donut-shaped)
            animation: {
                animateRotate: true,
                animateScale: false
            }
        }
    });
    </script>




    <script type="text/javascript">

window.addEventListener("scroll", () => {
    const scrollPosition = window.scrollY;
    const element1 = document.getElementById("element1");

    // Hold Box 1 to scroll at a slower rate to give a 'held' effect
    element1.style.transform = `translateY(${scrollPosition * 0.3}px)`;

    
});


    $(function() {
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
    <script>
function price_type(){
    var select = document.getElementById('price_item');
    var selectedOption = select.options[select.selectedIndex];
    // Get the 'pro_type' attribute from the selected option
    var item = selectedOption.getAttribute('pro_type');
    
    if(item=='direct'){
        document.getElementById('qty_input').style.display = 'block';
        document.getElementById('pricing_type').value = 'direct';
    }else{
        document.getElementById('qty_input').style.display = 'none';
        document.getElementById('pricing_type').value = 'indirect';
    }

}


    function select_pay() {
        var val = $('#pay_type').val(); // Added '#' for correct ID selector
        if (val === "Bank") {
            $('.slt-bank').show();
        } else {
            $('.slt-bank').hide();
        }

        if (val === "chq") {
            $('.slt-chq').show();
        } else {
            $('.slt-chq').hide();
        }
    }

    //Date picker
    $('#datepicker1').datepicker({
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