<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('hed.php'); 

    include_once("../config.php");?>

    <style>
    .btn_section {
        display: flex;
        justify-content: center;
        margin: 10px 0 5px;
        padding: 0 25px;
    }

    .btn_section span {
        padding: 8px 10px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .btn_section span:first-child {
        border-radius: 10px 0 0 10px;
    }

    .btn_section span:last-child {
        border-radius: 0 10px 10px 0;
    }

    .job-card {
        border-radius: 15px;
        background-color: #181929;
        color: aliceblue;
        margin: 2%;
        padding: 10px;
        height: 200px;
        /* Fixed height for consistency */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .job-card table {
        width: 100%;
    }

    .job-title {
        color: #D1D1D1;
        margin: 10px;
    }

    .job-detail {
        color: #959595;
    }

    .job-id {
        color: #686868;
    }

    .view-button {
        color: #dbdbdb;
        width: 100px;
        text-align: center;
        border-radius: 15px 0px 15px 0px;
        background-color: 89CFF0;
        padding: 5px;
    }

    .view-button:hover {
        background-color: darkred;
    }
    </style>
</head>

<body>
    <?php include('preload.php');
include("../connect.php"); 
$id = $_GET['id'];
?>

    <div class="notify-alert-box">
        <img src="img/AUTO_LOGO.png" alt="">
        <p>We'd like to send notify</p>
        <div class="buttons">
            <button id="notify-cancel-button">Cancel</button>
            <button id="notify-button">Allow</button>
        </div>
    </div>

    <br><br>

    <table>
        <tr>
            <th><img src="img/cloud_arm.png" width="80px" style="text-align: right;" alt=""></th>
            <th>
                <?php 
                                            $r2 =  select('purchases_list', '*', "id='$id'", '../');
                                            if ($r2) {
                                                while ($row2 = $r2->fetch()) {
                                                    $name1 = $row2['name'];
                                                }}?>

                <h3 style="color: #fff;"> <?php echo $name1 ?></h3>
                </h5>
            </th>
        </tr>
    </table>
    <br>

    <!-- small box -->
    <?php 

$m_id = $_SESSION['USER_EMPLOYEE_ID'];

$user_l = $_SESSION['SESS_LAST_NAME'];
if ($user_l == "admin") { ?>
    <div class="hederbar" style="overflow-x:auto;">

    </div>

    <div class="box-header">
        <h3 class="box-title">Purchase order</h3>

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div
                    style="border-radius: 15px; background-color: #181929; color: aliceblue; margin: 2%; padding: 10px;">
                    <table style="width:100%;">
                        <?php
                        $result = select('purchases_list', '*', "id='$id' AND type='Order'", '../');

                        if ($result) {
                            for ($i = 0; $row = $result->fetch(); $i++) {
                                $id = $row['id'];
                                $approved = $row['approve'];
                                $qty1 = $row['qty'];
                                ?>
                        <tr>


                        </tr>
                    </table>

                    <table style="width:100%;">
                        <tr>
                            <td colspan="2">

                                <div align="left" style="width:100%;">

                                    <div
                                        style="color:#6d949e; background-color: #1f2031; text-align: center; border-radius: 10px 10px 10px 10px ;">
                                        <strong><i class="fas fa-tag text-success"></i> Price:</strong> <?php echo $row['sell']; ?><br>
<strong><i class="fas fa-cogs text-primary"></i> Quantity:</strong> <?php echo $row['qty']; ?><br>

                                    </div>

                                </div>
                            </td>



                        </tr>
                    </table>

                    <br>
                    <table>
                        <tr>

                            <td>
                                <div align="right" style="width:100%;">
                                    <div class="bg-info"
                                        style="color:#000000; width:250px; text-align: center; border-radius: 10px 10px 10px 10px;">
                                        <strong>NEW purchase Amount:</strong> <?php echo $row['sell'] * $row['qty']; ?>
                                    </div>
                                </div>
                            </td>

                        </tr>
                    </table>
                    <br>

                </div>
            </div>
            <?php
        }
    } else {
        echo "<div class='col-12'><p>No records found.</p></div>";
    }
    ?>
        </div>

        <div class="box-header">
            <h3 class="box-title">Perchasing histry</h3>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div
                        style="border-radius: 15px; background-color: #181929; color: aliceblue; margin: 2%; padding: 10px;">
                        <table style="width:100%;">
                            <?php
                $result = select('purchases_list', '*', "id='$id'", '../');

                if ($result) {
                    while ($row = $result->fetch()) {
                        $id = $row['id'];
                        $approved = $row['approve'];
                        $product_id = $row['product_id'];

                        $innerResult = select('purchases_list', 'MAX(id) AS max_id, date, qty, amount', "product_id='$product_id' AND type='GRN'", '../');
                        if ($innerResult) {
                            while ($innerRow = $innerResult->fetch()) {
                                $date = $innerRow['date'];
                                $qty = $innerRow['qty'];
                                $amount = $innerRow['amount'];
                                $id4 = $innerRow['max_id'];
                                
                                ?>
                            <tr>

                            </tr>
                        </table>

                        <?php
                            $r2 = select('materials', '*', "id='$product_id'", '../');
                            if ($r2) {
                                while ($row2 = $r2->fetch()) {
                                    $available = $row2['available_qty'];
                                    $reorder = $row2['re_order'];
                                    ?>
                        <table style="width:100%;">
                            <tr>
                                <td colspan="2">
                                    <div align="left" style="width:100%;">
                                        <div
                                            style="color:#6d949e; background-color: #1f2031; text-align: center; border-radius: 10px 10px 10px 10px">
                                            <i class="fas fa-calendar-check text-primary"></i> <strong>Last Purchase
                                                Date:</strong> <?php echo $date; ?><br>
                                            <i class="fas fa-box-open text-info"></i> <strong>Last Purchase
                                                Qty:</strong>
                                            <?php echo $qty; ?><br>


                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </table>
                        <br>
                        <table>
                            <tr>

                                <td>
                                    <div align="right" style="width:100%;">
                                        <div class="bg-info"
                                            style="color:#000000; width:250px; text-align: center; border-radius: 10px 10px 10px 10px">
                                            <strong>Last purchase Amount:</strong> <?php echo $amount ?>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </table>
                    </div>
                </div>
                <?php
                                  }  }
                            }
                        } else {
                            echo "<div class='col-12'><p>No records found.</p></div>";
                        }
                    }
                }
                ?>
            </div>
        </div>

        <div class="box-header">
            <h3 class="box-title">Quantity Details</h3>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div
                        style="border-radius: 15px; background-color: #181929; color: aliceblue; margin: 2%; padding: 10px;">
                        <table style="width:100%;">
                            <?php
                $result = select('purchases_list', '*', "id='$id'", '../');

                if ($result) {
                    while ($row = $result->fetch()) {
                        $id = $row['id'];
                        $approved = $row['approve'];
                        $product_id = $row['product_id'];

                        $innerResult = select('purchases_list', 'MAX(id) AS max_id, date, qty, amount', "product_id='$product_id' AND type='GRN'", '../');
                        if ($innerResult) {
                            while ($innerRow = $innerResult->fetch()) {
                                $date = $innerRow['date'];
                                $qty = $innerRow['qty'];
                                $amount = $innerRow['amount'];
                                ?>
                            <tr>

                            </tr>
                        </table>

                        <?php
                            $r2 = select('materials', '*', "id='$product_id'", '../');
                            if ($r2) {
                                while ($row2 = $r2->fetch()) {
                                    $available = $row2['available_qty'];
                                    $reorder = $row2['re_order'];
                                    ?>
                        <table style="width:100%;">
                            <tr>
                                <td colspan="2">
                                    <div align="left" style="width:100%;">
                                        <div
                                            style="color:#6d949e; background-color: #1f2031; text-align: center; border-radius: 10px 10px 10px 10px;">


                                            <i class="fas fa-warehouse text-success"></i> <strong>Stock Qty:</strong>
                                            <?php echo $available; ?><br>
                                            <i class="fas fa-exclamation-circle text-warning"></i> <strong>Reorder
                                                Qty:</strong> <?php echo $reorder; ?><br>
                                            <i class="fas fa-exclamation-circle text-warning"></i> <strong>After Order
                                                Qty:</strong> <?php echo $available+$qty1; ?><br>

                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </table>
                        <br>
                        <table>
                            <tr>
                                <td style="width:100%">
                                    <?php if ($available >= $reorder ): ?>
                                    <!-- Approve button (yellow) -->
                                    <a class="btn btn-success">
                                        <i class="fas fa-check-circle"></i> Enouph Stock available
                                    </a>

                                    <?php endif; ?>

                                    <?php if ($reorder >$available): ?>
                                    <!-- Edit button (blue) -->
                                    <!-- Decline button (red) -->
                                    <a class="btn btn-danger">
                                        <i class="fas fa-times-circle"></i> Not enouph Stock
                                    </a>
                                    <?php endif; ?>
                                </td>


                            </tr>
                        </table>
                    </div>
                </div>
                <?php
                                  }  }
                            }
                        } else {
                            echo "<div class='col-12'><p>No records found.</p></div>";
                        }
                    }
                }
                ?>
            </div>
        </div>


        <div class="box-header">
    <h3 class="box-title">Fixing users history</h3>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
            <div style="border-radius: 15px; background-color: #181929; color: aliceblue; margin: 2%; padding: 10px;">
                <table style="width:100%;">
                    <?php
                    $result = select('inventory', '*', "material_id = '$product_id' AND type = 'out' ORDER BY id DESC LIMIT 5", '../');

                    if ($result) {
                        while ($row = $result->fetch()) {
                            $sales_id = $row['sales_list_id'];
                            $qty4 = $row['qty'];
                            $job_no = $row['job_no'];
                $date = $row['date'];
                                    ?>
                                    <tr>
                                        <td colspan="2">
                                            <div align="left" style="width:100%;">
                                            <div style="color:#6d949e; background-color: #1f2031; text-align: center; border-radius: 10px 10px 10px 10px; padding: 10px;">
                                                <i class="fas fa-briefcase text-info"></i> <strong>Job No:</strong> <?php echo $job_no; ?><br>
                                                <i class="fas fa-sort-numeric-up text-warning"></i> <strong>Quantity:</strong> <?php echo $qty4; ?><br>
                                            </div>

                                            </div>
                                        </td>
                                    </tr>
                                    <table>
                                    <tr>
                                        <td>
                                            <div align="right" style="width:100%;">
                                                <div class="bg-primary" style="color:#000000; width:250px; text-align: center; border-radius: 10px 10px 10px 10px;">
                                                    <strong>Date:</strong> <?php echo $date ?><br>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </table>
                                    <br>
                                    <?php
                                }
                            
                            }
                        
                    
                    ?>
                </table>
                
            </div>
        </div>
    </div>
</div>









    <br><br>


    <?php $nav="GRN"; include('nav.php'); ?>

    <?php } ?>
</body>
<!-- jQuery 2.2.3 -->
<script src="../../../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../../../bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="../../../plugins/morris/morris.min.js"></script>

<script src="pwa/app.js"></script>

<script src="js/notify.js"></script>
<script src="js/nav.js"></script>
<script>
function confirmApp(id) {
    if (confirm('Are you sure you want to Approve this item?')) {
        // Redirect to a PHP page that handles the deletion
        window.location.href = '../grn_order_app_save.php?id=' + id + '&id2=1' + '&app=1';
    }
}

function confirmDelete(id) {
    if (confirm('Are you sure you want to reject this item?' + id)) {
        // Redirect to a PHP page that handles the deletion
        window.location.href = '../grn_order_app_save.php?id=' + id + '&id2=5' + '&app=1';
    }
}
</script>
<script>
$(function() {


    // LINE CHART
    var line = new Morris.Line({
        element: 'line-chart',
        resize: true,
        data: [
            //----------------------######################################## ---------------------------------------//
            {
                y: '<?php echo $y = date("Y") - 2; ?> Q1',
                item1: <?php $date1 = $y . "-01-01"; $date2 = $y . "-03-31";
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },
            {
                y: '<?php echo date("Y") - 2; ?> Q2',
                item1: <?php $date1 = $y . "-04-01"; $date2 = $y . "-06-31";$ex = 0;$gf = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },


            {
                y: '<?php echo date("Y") - 2; ?> Q3',
                item1: <?php $date1 = $y . "-07-01"; $date2 = $y . "-09-31";$ex = 0;$gf = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },


            {
                y: '<?php echo date("Y") - 2; ?> Q4',
                item1: <?php $date1 = $y . "-10-01"; $date2 = $y . "-12-31";$ex = 0;$gf = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },
            //----------------------######################################## ---------------------------------------//


            //----------------------######################################## ---------------------------------------//
            {
                y: '<?php echo $y = date("Y") - 1; ?> Q1',
                item1: <?php $date1 = $y . "-01-01"; $date2 = $y . "-03-31";$gf = 0;$ex = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },


            {
                y: '<?php echo date("Y") - 1; ?> Q2',
                item1: <?php $date1 = $y . "-04-01"; $date2 = $y . "-06-31";$ex = 0;$gf = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },


            {
                y: '<?php echo date("Y") - 1; ?> Q3',
                item1: <?php $date1 = $y . "-07-01"; $date2 = $y . "-09-31";$ex = 0;$gf = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },

            {
                y: '<?php echo date("Y") - 1; ?> Q4',
                item1: <?php $date1 = $y . "-10-01"; $date2 = $y . "-12-31";$ex = 0;$gf = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },
            //----------------------######################################## ---------------------------------------//


            //----------------------######################################## ---------------------------------------//
            {
                y: '<?php echo $y = date("Y"); ?> Q1',
                item1: <?php $date1 = $y . "-01-01"; $date2 = $y . "-03-31";$gf = 0;$ex = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },


            {
                y: '<?php echo date("Y"); ?> Q2',
                item1: <?php $date1 = $y . "-04-01"; $date2 = $y . "-06-31";$ex = 0;$gf = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },


            {
                y: '<?php echo date("Y"); ?> Q3',
                item1: <?php $date1 = $y . "-07-01"; $date2 = $y . "-09-31";$ex = 0;$gf = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            },

            {
                y: '<?php echo date("Y"); ?> Q4',
                item1: <?php $date1 = $y . "-10-01"; $date2 = $y . "-12-31";$ex = 0;$gf = 0;
                    $result1 = $db->prepare("SELECT  sum(profit) FROM sales WHERE action='active' AND date BETWEEN '$date1' AND '$date2'  ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $gf = $row1['sum(profit)'];
                    }

                    $result1 = $db->prepare("SELECT  sum(amount) FROM expenses_records WHERE date BETWEEN '$date1' AND '$date2'   ");
                    $result1->bindParam(':userid', $date);
                    $result1->execute();
                    for ($i = 0; $row1 = $result1->fetch(); $i++) {
                        $ex = $row1['sum(amount)'];
                    }

                    echo $gf - $ex;
                    ?>
            }
            //----------------------######################################## ---------------------------------------//
        ],
        xkey: 'y',
        ykeys: ['item1'],
        labels: ['Value'],
        lineColors: ['#ffffff'],
        gridTextColor: ['#ffffff'],
        hideHover: 'auto'
    });

});
</script>

</html>