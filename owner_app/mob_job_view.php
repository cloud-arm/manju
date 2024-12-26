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
                                            $r2 =  select('job', '*', "id='$id'", '../');
                                            if ($r2) {
                                                while ($row2 = $r2->fetch()) {
                                                    $name1 = $row2['name'];
                                                }}?>

                <h3 style="color: #fff;"> <?php echo $name1 ?></h3>

                <?php $r = select('job_location', '*', 'job_id=' . $id,'../');
                                        while ($locationRow = $r->fetch()) {?>
                <div align="center">
                    <div class="badge " style="background-color: #20303e; ">
                        <i class="fas fa-map-marker-alt" style="margin-right: 5px;"></i>
                        <?php echo $locationRow['name']; ?>
                    </div>
                    <br>
                </div>
                <?php } ?>


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
        <h3 class="box-title"> Payments details</h3>

        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                <div
                    style="border-radius: 15px; background-color: #181929; color: aliceblue; margin: 2%; padding: 10px;">


                    <table style="width:100%;">
    <tr>
        <td colspan="2">
            <?php
            // Fetch the data from the database
            $result = select('sales_list', '*', 'job_no = ' . $id . ' AND amount > 0', '../');
            
            // Initialize total amount variable
            $totalAmount = 0;

            // Loop through the fetched data
            while ($row = $result->fetch()) {
                $totalAmount += $row['amount']; // Sum the amounts
                $location = $row['location'];
                $name = $row['name'];
                $qty1 = $row['qty'];
                $about = $row['about'];
                $amount = $row['amount'];
                $totalAmount += $row['amount']; // Sum the amounts

            ?>
                <!-- Display the fetched data -->
                <div align="left" style="width:100%;">
                    <div style="color:#6d949e; background-color: #1f2031; text-align: center; border-radius: 10px; padding: 10px; margin-bottom: 10px;">
                        <strong><i class="fas fa-tag text-success"></i> Location:</strong> 
                        <?php echo htmlspecialchars($location); ?><br>
                        
                        <strong><i class="fas fa-cogs text-primary"></i> Name:</strong> 
                        <?php echo htmlspecialchars($name); ?><br>
                        
                        <strong><i class="fas fa-cogs text-primary"></i> Quantity:</strong> 
                        <?php echo htmlspecialchars($qty1); ?><br>
                        
                        <strong><i class="fas fa-dollar-sign text-warning"></i> Amount:</strong> 
                        <?php echo htmlspecialchars($amount); ?><br>
                    </div>
                </div>
            <?php
            }
            ?>
        </td>

    </tr>
</table>





                    <br>

                    <br>

                </div>
            </div>
            <?php
        
    
    ?>
        </div>

        <div class="box-header">
            <h3 class="box-title"> Product details</h3>

            <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
                    <div
                        style="border-radius: 15px; background-color: #181929; color: aliceblue; margin: 2%; padding: 10px;">


                        <table style="width:100%;">
                            <tr>
                                <table style="width:100%;">
                                    <tr>
                                        <td colspan="2">
                                            <?php
                                        // Fetch the data from the database
                                        $result = select('sales_list', '*', "job_no='$id'", '../');
                                            // Loop through the fetched data
                                            for ($i = 0; $row = $result->fetch(); $i++)  {
                                                $id = $row['id'];
                                                $qty1 = $row['qty'];
                                                $name = $row['name'];
                                                $about = $row['about'];
                                                $status = $row['status'];


                                                // Determine the icon and badge style based on the status
                                                $icon = '';
                                                $badgeStyle = 'color:#89CFF0; width:100px; text-align: center; border-radius: 50px; display: flex; align-items: center; justify-content: center; transform: skew(-10deg);';

                                                switch ($status) {
                                                    case 'fix':
                                                        $icon = 'fas fa-wrench';
                                                        break;
                                                    case 'on_aprove':
                                                        $icon = 'fas fa-exclamation-circle';
                                                        break;
                                                    case 'printing':
                                                        $icon = 'fas fa-print';
                                                        break;
                                                    case 'artwork':
                                                        $icon = 'fas fa-palette';
                                                        break;
                                                    case 'measure':
                                                        $icon = 'fas fa-ruler';
                                                        break;
                                                    case 'complete':
                                                        $icon = 'fas fa-check-circle';
                                                        break;
                                                    default:
                                                        $icon = 'fas fa-question'; // Default icon for unknown status
                                                }
                                                ?>

                                            <!-- Display the fetched data -->
                                            <div align="left" style="width:100%;">
                                                <div
                                                    style="color:#6d949e; background-color: #1f2031; text-align: center; border-radius: 10px;">
                                                    <strong><i class="fas fa-tag text-success"></i> Name:</strong>
                                                    <?php echo htmlspecialchars($name); ?><br>
                                                    <strong><i class="fas fa-cogs text-primary"></i> Quantity:</strong>
                                                    <?php echo htmlspecialchars($qty1); ?><br>
                                                    <strong><i class="fas fa-cogs text-primary"></i>
                                                        Description:</strong>
                                                    <?php echo htmlspecialchars($about); ?><br>
                                                    <strong><i class="fas fa-cogs text-primary"></i> Status:</strong>
                                                    <div align="center" style="width:100%;">
                                                        <div class="badge bg-blue" style="<?php echo $badgeStyle; ?>">
                                                            <i class="<?php echo $icon; ?>"
                                                                style="margin-right: 5px;"></i>
                                                            <?php echo htmlspecialchars($status); ?>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <br>
                                            <?php
                }
                
             {
            }
            ?>
                                        </td>
                                    </tr>
                                </table>



                            </tr>
                        </table>

                        <br>

                        <br>

                    </div>
                </div>
                <?php
        
    
    ?>
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