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
                $location = 'location';
                $width = 'width';
                $height = 'height';
                $product_name='name';
                $status = 'status';
                $job_no = 'job_no';
                $address = "address";
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
                                    <div class="form-group">
                                        <label>Location:</label>
                                        <p><?php echo $location; ?></p>
                                    </div>

                                    <div class="form-group">
                                        <label>Branch Name:</label>
                                        <p><?php echo $product_name; ?></p>
                                    </div>

                                    <div class="form-group">
                                        <label>Address:</label>
                                        <p><?php echo $address; ?></p>
                                    </div>

                                    <?php
                            // Fetch measurement data from the database
                            $id = $_GET['id'];
                            $result3 = select('purchases', '*', "invoice_no='$id'");
                            if ($row = $result3->fetch()) {
                                $act = $row['action'];
                                $status = 'status';
                                $reject = $row['approve'];
                                $status_id = $row['action'];
                                $note = $row['reject_note'];
                            ?>
                                    

                                    <?php 
                                        $icon = '';
                                        $badgeStyle = 'color: white; padding: 5px 20px; border-radius: 30px; display: inline-flex; align-items: center; justify-content: center; margin-top: 10px; font-size: 1.2rem;';
                                        $backgroundColor = '#7393B3'; // Default background color

                                        if ($status == 1) {
                                            $icon = 'fas fa-check-circle';
                                            $backgroundColor = '##ffc107'; // yellow for approve
                                        } elseif ($status == 2) {
                                            $icon = 'fas fa-print';
                                            $backgroundColor = '#007bff'; // Blue for printing
                                        } elseif ($status == 3) {
                                            $icon = 'fas fa-palette';
                                            $backgroundColor = '#17a2b8'; // Coral for artwork
                                        } elseif ($status == 4) {
                                            $icon = 'fas fa-exclamation-circle';
                                            $backgroundColor = '#ffc107'; // Yellow for pending
                                        } 
                                        // elseif ($status == 'measure') {
                                        //     $icon = 'fas fa-ruler';
                                        //     $backgroundColor = '#1434A4'; // Gray for measure
                                        // } elseif ($status == 'fix') {
                                        //     $icon = 'fas fa-wrench';
                                        //     $backgroundColor = '#5D3FD3'; // Teal for fix
                                        // } elseif ($status == 'complete') {
                                        //     $icon = 'fas fa-check-double';
                                        //     $backgroundColor = '#28a745'; // Green for complete
                                        // }

                                        // Apply the background color to the badge
                                        if ($icon) {
                                            echo '<div align="center" style="width:100%; margin-top: 20px;">
                                                    <div class="badge" style="' . $badgeStyle . ' background-color: ' . $backgroundColor . ';">
                                                        <i class="' . $icon . '" style="margin-right: 10px;"></i>' . ucfirst($status) . '
                                                    </div>
                                                </div>';
                                        }
                                        ?>

                                    <?php if($status == 'measure'){ ?>
                                    <div class="text-center" style="margin-top: 20px;">
                                        <h5>If you wish to delete this job process without adding details, click the
                                            button below:</h5>
                                        <a class="btn btn-sm btn-danger"
                                            style="padding: 5px 25px; font-size: 1.2rem; background-color: #FF4433; color: white; border: none;"
                                            onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                            Delete
                                        </a>
                                    </div>
                                    <?php } ?>
                                    </tr>
                                    
                                    <?php } ?>

                                    <div><br></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" align="center">
                        <button class="btn btn-info" style="width: 150px; height: 25px; font-size: 10px; "
                            onclick="window.location.href='grn_order_rp.php'">
                            Back
                        </button>
                    </div>

                </div>
                <!-- Right column (9-column grid) -->







                <div class="col-md-9">
                    <div class="col-md-12">
                        <ul class="timeline">



                <?php if ($status_id >= 0){ ?>
                <li>
                    <i class="fa fa-check-circle bg-green"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 5 days ago</span>
                        <h3 class="timeline-header"><a href="#">Purchases Order Details</a></h3>
                        <div class="box-body">
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                                
                                <th>#</th>

                            </tr>
                                                </thead>
                                                <tbody>
                            <?php
                            // Fetch purchase list data based on invoice number
                            $r1 = select_query("SELECT * FROM purchases_list WHERE invoice_no='$id' AND type='Order'");
                            $i = 1; // Initialize counter for numbering rows
                            while ($row = $r1->fetch()) {
                                $invo = $row['invoice_no'];
                                $type = $row['type'];
                                $date = $row['date'];
                                $qty = $row['qty'];
                                $action = $row['action'];
                                //$amount = $row['amount'];
                                $price = $row['sell'];
                                $id = $row['id'];
                                $approved = $row['approve'];
                                $name = $row['name'];


                                // Only display rows where approval is not equal to 5
                                if ($approved != 5) {
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td> <!-- Increment row number -->
                                <td> <a href="grn_summery.php?id=<?php echo $id; ?>"  style="width: 120px; text-align: center; line-height: 32px; text-decoration: none;"><?php echo $name; ?></a>
                                </td>
                                <td><?php echo $type; ?></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $price; ?></td>

                                <td><?php echo $action ?></td>
                                 <?php  
                                    $u_id = $_SESSION['SESS_MEMBER_ID'];
                                    $result = query("SELECT * FROM user WHERE id = '$u_id'");
                                    for ($i = 0; $r01 = $result->fetch(); $i++) {
                                        $user_level = $r01['user_lewal'];  
                                    }
                                 ?>
                                <td>
                                    <!-- if logged user is RM -->
                                    <?php if ($user_level == 1): ?>
                                    <?php if ($approved != 1 && $approved != 20): ?>
                                    <!-- Hide buttons if approved is 1 or 5 -->
                                    <a class="btn btn-danger" onclick="confirmApp(<?php echo $id; ?>)">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                    <?php endif; ?>

                                    <?php if ($approved != 5 && $approved != 20): ?>
                                    <!-- Hide edit button only when approved is 5 -->
                                    <a class="btn btn-danger" onclick="edit_note(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                    <a class="btn btn-danger" onclick="edit_note2(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php endif; ?>

                                </td>


                            </tr>

                            <div class="container-up d-none" id="edit_popup_2<?php echo $row['id']; ?>">
                                <div class="row w-70">
                                    <div class="box box-success popup" style="width: 100%;">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Edit details</h3>
                                            <small onclick="edit_close(<?php echo $row['id']; ?>)"
                                                class="btn btn-sm btn-success pull-right"><i
                                                    class="fa fa-times"></i></small>
                                            <i class="fa fa-times"></i>
                                            </small>
                                        </div>
                                        <div class="box-body d-block">
                                            <form method="POST" action="edit_grn_order.php">
                                                <div class="row" style="display: block;">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>qty</label>
                                                            <input type="number" name="qty" class="form-control"
                                                                value="" required>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">

                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="emp_id" value="<?php echo $u_id ?>">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $row['id']; ?>">

                                                        <input type="submit" style="margin-top: 23px; width: 100%;"
                                                            value="Save" class="btn btn-info btn-sm">
                                                    </div>
                                                </div>

                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="container-up d-none" id="edit_popup_<?php echo $row['id']; ?>">
                                <div class="row w-70">
                                    <div class="box box-success popup" style="width: 100%;">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Reject details</h3>
                                            <small onclick="edit_close(<?php echo $row['id']; ?>)"
                                                class="btn btn-sm btn-success pull-right"><i
                                                    class="fa fa-times"></i></small>
                                            <i class="fa fa-times"></i>
                                            </small>
                                        </div>
                                        <div class="box-body d-block">
                                            <form method="POST" action="reject_grn_order.php">
                                                <div class="row" style="display: block;">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>note</label>
                                                            <input type="text" name="note" class="form-control"
                                                                value="" required>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">

                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="emp_id" value="<?php echo $u_id ?>">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $row['id']; ?>">

                                                        <input type="submit" style="margin-top: 23px; width: 100%;"
                                                            value="Save" class="btn btn-info btn-sm">
                                                    </div>
                                                </div>

                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                </div>
                <?php
                        } 
                        ?>
                <?php
        }
    
    ?>
                </tbody>
                                            </table>
                                        </div>
                    </div>
                </li>
                <?php } ?>

                <?php if ($status_id >= 1){ ?>
                    <li>
                    <i class="fa fa-check-circle bg-green"></i>
                    <div class="timeline-item p-3 bg-light rounded shadow-sm">
                        <span class="time text-muted"><i class="fa fa-clock-o"></i> 5 days ago</span>
                        <h3 class="timeline-header"><a href="#" class="text-primary">Purchases Order Details</a></h3>

                        <div class="row mt-3 align-items-center box-body">
                            <div class="col-md-6">
                            <?php if($reject == "approve" && $act >= 2) {?>
                                    <h5 class="timeline-header font-weight-bold">This Purchase Order Approve By Sales coordinator:</h5>
                                <?php }elseif($reject == "reject"  && $act == 1){ ?>
                                    <h5 class="timeline-header font-weight-bold">This Purchase Order Reject By Sales coordinator:</h5>
                                <?php }else { ?>
                                    <h5 class="timeline-header font-weight-bold">This Purchase Order is waiting for Sales coordinator Approval:</h5>
                               <?php } ?>
                            </div>

                            <?php 
                                $u_id = $_SESSION['SESS_MEMBER_ID']; 
                                $result = query("SELECT * FROM user WHERE id = '$u_id'");
                                for ($i = 0; $r01 = $result->fetch(); $i++) {
                                    $user_level = $r01['user_lewal'];  
                                } 
                            ?>
                        <div  <?php if ($user_level != 2): ?>
                                style="display: none;"
                            <?php endif; ?>
                            >
                            <div class="col-md-3">
                                <?php $u_id = $_SESSION['SESS_MEMBER_ID'];  ?>
                                <a
                                    <?php if ($act == 1 && $reject != "reject"): ?>
                                        href="purchase_order_approve.php?id=<?php echo $_GET['id']; ?>&emp_id=<?php echo $u_id ?>"
                                        class="btn btn-primary btn-sm w-100"
                                    <?php else: ?>
                                        class="btn btn-primary btn-sm disabled w-100"
                                    <?php endif; ?>
                                >
                                    Approve
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a
                                    <?php if ($act == 1 && $reject != "reject"): ?>
                                        class="btn btn-danger btn-sm w-100"
                                        onclick="edit_notecc()"
                                    <?php else: ?>
                                        class="btn btn-danger btn-sm disabled w-100"
                                    <?php endif; ?>
                                >
                                    Reject
                                </a>
                            </div>

                            <div class="container-up d-none" id="edit_popup_3">
                                <div class="row w-70">
                                    <div class="box box-success popup" style="width: 100%;">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Reject details</h3>
                                            <small onclick="edit_close(<?php echo $_GET['id']; ?>)"
                                                class="btn btn-sm btn-success pull-right"><i
                                                    class="fa fa-times"></i></small>
                                            <i class="fa fa-times"></i>
                                            </small>
                                        </div>
                                        <div class="box-body d-block">
                                            <form method="POST" action="grm_purchase_reject.php">
                                                <div class="row" style="display: block;">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>note</label>
                                                            <input type="text" name="note" class="form-control"
                                                                value="" required>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">

                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="emp_id" value="<?php echo $u_id ?>">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $_GET['id']; ?>">

                                                        <input type="submit" style="margin-top: 23px; width: 100%;"
                                                            value="Save" class="btn btn-info btn-sm">
                                                    </div>
                                                </div>

                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

        </div>
    </div>
</div>

                </li>
                <?php } ?>

                <?php if ($status_id >= 2){ ?>
                    <li>
                    <i class="fa fa-check-circle bg-green"></i>
                    <div class="timeline-item p-3 bg-light rounded shadow-sm">
                        <span class="time text-muted"><i class="fa fa-clock-o"></i> 5 days ago</span>
                        <h3 class="timeline-header"><a href="#" class="text-primary">Purchases Order Details</a></h3>

                        <div class="row mt-3 align-items-center  box-body">
                            <div class="col-md-6">
                                <?php if($reject == "approve" && $act >= 3) {?>
                                    <h5 class="timeline-header font-weight-bold">This Purchase Order Approve By Accountant:</h5>
                                <?php }elseif($reject == "reject" && $act == 2){ ?>
                                    <h5 class="timeline-header font-weight-bold">This Purchase Order Reject By Accountant:</h5>
                                <?php }else { ?>
                                    <h5 class="timeline-header font-weight-bold">This Purchase Order is waiting for Accountant Approval:</h5>
                               <?php } ?>
                            </div>

                            <?php 
                                $u_id = $_SESSION['SESS_MEMBER_ID']; 
                                $result = query("SELECT * FROM user WHERE id = '$u_id'");
                                for ($i = 0; $r01 = $result->fetch(); $i++) {
                                    $user_level = $r01['user_lewal'];  
                                } 
                            ?>
                        <div  <?php if ($user_level != 3): ?>
                                style="display: none;"
                            <?php endif; ?>
                            >
                            <div class="col-md-3">
                                <a
                                    <?php if ($act == 2 && $reject != "reject"): ?>
                                        href="purchase_order_approve.php?id=<?php echo $_GET['id']; ?>&emp_id=<?php echo $u_id ?>"
                                        class="btn btn-primary btn-sm w-100"
                                    <?php else: ?>
                                        class="btn btn-primary btn-sm disabled w-100"
                                    <?php endif; ?>
                                >
                                    Approve
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a
                                    <?php if ($act == 2 && $reject != "reject"): ?>
                                        href="grm_purchase_reject.php?id=<?php echo $_GET['id']; ?>&emp_id=<?php echo $u_id ?>"
                                        class="btn btn-danger btn-sm w-100"
                                    <?php else: ?>
                                        class="btn btn-danger btn-sm disabled w-100"
                                    <?php endif; ?>
                                >
                                    Reject
                                </a>
                            </div>
                        </div>
    </div>
</div>

                </li>
                <?php } ?>

                <?php if ($status_id >= 3){ ?>
                    <li>
                    <i class="fa fa-check-circle bg-green"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 5 days ago</span>
                        <h3 class="timeline-header"><a href="#">Purchases Order Details</a></h3>
                        <div class="box-body">
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Action</th>
                                
                                <th>#</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // Fetch purchase list data based on invoice number
                            $id = $_GET['id'];
                            $r1 = select_query("SELECT * FROM purchases_list WHERE invoice_no='$id' AND type='Order'");
                            while ($row = $r1->fetch()) {
                                $invo = $row['invoice_no'];
                                $type = $row['type'];
                                $date = $row['date'];
                                $qty = $row['qty'];
                                $action = $row['action'];
                                //$amount = $row['amount'];
                                $price = $row['sell'];
                                $id = $row['id'];
                                $approved = $row['approve'];
                                $name = $row['name'];


                                // Only display rows where approval is not equal to 5
                                if ($approved != 5) {
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td> <!-- Increment row number -->
                                <td> <a href="grn_summery.php?id=<?php echo $id; ?>"  style="width: 120px; text-align: center; line-height: 32px; text-decoration: none;"><?php echo $name; ?></a>
                                </td>
                                <td><?php echo $type; ?></td>
                                <td><?php echo $date; ?></td>
                                <td><?php echo $qty; ?></td>
                                <td><?php echo $price; ?></td>

                                <td><?php  echo $action ?></td>
                                 <?php  
                                    $u_id = $_SESSION['SESS_MEMBER_ID'];
                                    $result = query("SELECT * FROM user WHERE id = '$u_id'");
                                    for ($i = 0; $r01 = $result->fetch(); $i++) {
                                        $user_level = $r01['user_lewal'];  
                                    }
                                 ?>
                                <td> 
                                    <!-- if logged user is stores manager -->
                                    <?php if ($user_level == 4): ?>
                                        <?php if ($approved != 5 && $approved != 20): ?>
                                        <a class="btn btn-danger" onclick="confirmApp2(<?php echo $id; ?>)">
                                        <i class="fas fa-check-circle"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($approved != 2 && $approved != 20): ?>
                                    <!-- Hide buttons if approved is 1 or 5 -->
                                    <a class="btn btn-danger" onclick="edit_note(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-times-circle"></i>
                                    </a>
                                    <a class="btn btn-danger" onclick="edit_note2(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php 
                                        $result = query("SELECT COUNT(*) AS emi_count FROM imi_no WHERE purchase_list_id = '$id'");
                                        for ($i = 0; $r01 = $result->fetch(); $i++) {
                                            $count = $r01['emi_count'];
                                        }
                                    ?>
                                    <?php if($approved == 2 && $count != $qty) { ?>
                                        <a class="btn btn-danger" href="emi_add.php?id=<?php echo $row['id']; ?>">
                                            <i class="fas fa-plus"></i>
                                        </a>

                                    <?php } ?>
                                    <?php endif; ?>

                                </td>


                            </tr>

                            <div class="container-up d-none" id="edit_popup_2<?php echo $row['id']; ?>">
                                <div class="row w-70">
                                    <div class="box box-success popup" style="width: 100%;">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Edit details</h3>
                                            <small onclick="edit_close(<?php echo $row['id']; ?>)"
                                                class="btn btn-sm btn-success pull-right"><i
                                                    class="fa fa-times"></i></small>
                                            <i class="fa fa-times"></i>
                                            </small>
                                        </div>
                                        <div class="box-body d-block">
                                            <form method="POST" action="edit_grn_order.php">
                                                <div class="row" style="display: block;">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>qty</label>
                                                            <input type="number" name="qty" class="form-control"
                                                                value="" required>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">

                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="emp_id" value="<?php echo $u_id ?>">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $row['id']; ?>">

                                                        <input type="submit" style="margin-top: 23px; width: 100%;"
                                                            value="Save" class="btn btn-info btn-sm">
                                                    </div>
                                                </div>

                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="container-up d-none" id="edit_popup_<?php echo $row['id']; ?>">
                                <div class="row w-70">
                                    <div class="box box-success popup" style="width: 100%;">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Reject details</h3>
                                            <small onclick="edit_close(<?php echo $row['id']; ?>)"
                                                class="btn btn-sm btn-success pull-right"><i
                                                    class="fa fa-times"></i></small>
                                            <i class="fa fa-times"></i>
                                            </small>
                                        </div>
                                        <div class="box-body d-block">
                                            <form method="POST" action="reject_grn_order.php">
                                                <div class="row" style="display: block;">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>note</label>
                                                            <input type="text" name="note" class="form-control"
                                                                value="" required>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">

                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <input type="hidden" name="emp_id" value="<?php echo $u_id ?>">
                                                        <input type="hidden" name="id"
                                                            value="<?php echo $row['id']; ?>">

                                                        <input type="submit" style="margin-top: 23px; width: 100%;"
                                                            value="Save" class="btn btn-info btn-sm">
                                                    </div>
                                                </div>

                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                </div>
                <?php
                        } 
                        ?>
                <?php
        }
    
    ?>
                </tbody>
                                            </table>
                                        </div>
                    </div>
                </li>
                <?php } ?>

                <?php if ($status_id >= 4){ ?>
                    <li>
                    <i class="fa fa-check-circle bg-green"></i>
                    <div class="timeline-item p-3 bg-light rounded shadow-sm">
                        <span class="time text-muted"><i class="fa fa-clock-o"></i> 5 days ago</span>
                        <h3 class="timeline-header"><a href="#" class="text-primary">GRI Order Details</a></h3>

                        <?php 
                            $invo = $_GET['id'];
                            $result = query("SELECT SUM(qty) FROM purchases_list WHERE invoice_no = '$invo' AND approve != 20");
                            for ($i = 0; $r01 = $result->fetch(); $i++) {
                                $sum = $r01['SUM(qty)'];
                            }

                            $imi_count = 0;
                            $result = query("SELECT * FROM purchases_list WHERE invoice_no = '$invo'");
                            for ($i = 0; $r01 = $result->fetch(); $i++) {
                                $p_id = $r01['id'];
                                $result1 = query("SELECT COUNT(*) AS imi_count FROM imi_no WHERE purchase_list_id = '$p_id'");
                                for ($i = 0; $r02 = $result1->fetch(); $i++) {
                                    $imi_count += $r02['imi_count'];
                                }
                            }
                        ?> 
                        <?php if ($sum == $imi_count){ ?>
                            <form method="POST" action="gri_create.php">
                                <div class="row mt-3 align-items-center  box-body">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Driver List</label>
                                            <select class="form-control select2" name="driver_id" style="width: 100%;" required>
                                                <?php
                                                    $result = query("SELECT * FROM employee");
                                                    while ($row = $result->fetch()) {
                                                ?>
                                                <option value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['name']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                    <div class="form-group">
                                            <label>Vehicle List</label>
                                            <select class="form-control select2" name="vehicle_id" style="width: 100%;" required>
                                                <?php
                                                    $result = query("SELECT * FROM vehicle");
                                                    while ($row = $result->fetch()) {
                                                ?>
                                                <option value="<?php echo $row['id']; ?>">
                                                    <?php echo $row['vehicle_no']; ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                    <input type="hidden" name="invoice_id" value="<?php echo $_GET['id']; ?>">
                                    <?php if ($user_level == 4): ?>
                                    <input type="submit" style="margin-top: 23px; width: 100%;"
                                    value="Create GRI" class="btn btn-info btn-sm">
                                    <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        <?php }else{ ?>
                            <div class="row mt-3 align-items-center  box-body">
                                <div class="col-md-12">
                                    <h5 class="timeline-header font-weight-bold" style="color: red;"> This order does not match the IMI number count. </h5>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </li>
                <?php } ?>

                <?php if ($reject == "reject"){ ?>
                    <li>
                    <i class="fa fa-check-circle bg-green"></i>
                    <div class="timeline-item p-3 bg-light rounded shadow-sm">
                        <span class="time text-muted"><i class="fa fa-clock-o"></i> 5 days ago</span>
                        <h3 class="timeline-header"><a href="#" class="text-primary">Reject Order Details</a></h3>

                        <div class="row mt-3 align-items-center  box-body">
                        <div class="col-md-12">
                                <h5 class="timeline-header font-weight-bold"><?php echo $note ?></h5>
                            </div>
                        </div>
                    </div>

                </li>
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
  function edit_notecc() {
        //  $(".popup").addClass("d-none");
        $("#edit_popup_3").removeClass("d-none");
    }

    function edit_note(i) {
        //  $(".popup").addClass("d-none");
        $("#edit_popup_" + i).removeClass("d-none");
    }

    function edit_note2(i) {
        //  $(".popup").addClass("d-none");
        $("#edit_popup_2" + i).removeClass("d-none");
    }

  

    function confirmApp(id) {
        if (confirm('Are you sure you want to Approve this item?')) {
            // Redirect to a PHP page that handles the deletion
            window.location.href = 'grn_order_app_save.php?id=' + id + '&id2=1' + '&app = 0';
        }
    }

    function confirmApp2(id) {
        if (confirm('Are you sure you want to Approve this item?')) {
            // Redirect to a PHP page that handles the deletion
            window.location.href = 'purchase_order_stores_approve.php?id=' + id;
        }
    }

    function edit_close(i) {
        //  $(".popup").addClass("d-none");
        $("#edit_popup_" + i).addClass("d-none");
        $("#edit_popup_2" + i).addClass("d-none");
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