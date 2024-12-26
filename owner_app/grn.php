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
include("../connect.php"); ?>

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
                <h3 style="color: #fff;">CLOUD ARM</h3>
                <h5>Hi <?php echo $_SESSION['SESS_FIRST_NAME'];
           ?></h5>
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
        <table>
            <tr>
                <td>
                    <div class="model-box v-2">
                        <table>
                            <tr>
                                <td><i style="font-size:40px; margin:15px; color:#D1D1D1" class="fa fa-spinner fa-spin" ></i>
                                </td>
                                <td>
                                    <h4 style="color:#686868">Pending</h4>
                                    <p style="padding-bottom: 5px; font-size: 25px; color:#959595;">
                                        <?php $date = date("Y-m-d");
                                       $result = $db->prepare("SELECT count(transaction_id)  FROM purchases  WHERE action = '0' AND type = 'Order' AND approve !='approve'");
                                        $result->bindParam(':userid', $date);
                                        $result->execute();
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                            echo $row['count(transaction_id)'];
                                        } ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

                <td>
                    <div class="model-box v-2">
                        <table>
                            <tr>
                                <td><i style="font-size:20px; margin:15px; color:#D1D1D1" class="fa fa-check"></i>
                                </td>
                                <td>
                                    <h4 style="color:#686868">Approved</h4>
                                    <p style="padding-bottom: 5px; font-size: 25px; color:#959595;">
                                        <?php $date = date("Y-m-d");
                                       $result = $db->prepare("SELECT count(transaction_id)  FROM purchases  WHERE action = '0' AND type = 'Order' AND approve ='approve'");
                                        $result->bindParam(':userid', $date);
                                        $result->execute();
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                            echo $row['count(transaction_id)'];
                                        } ?>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

                <td>
                    <div class="model-box v-4">
                        <table>
                            <tr>
                                <td><i style="font-size:60px; margin:15px; color:#D1D1D1;" class="ion-stats-bars"></i>
                                </td>
                                <td>
                                    <h4 style="color:#686868">coming soon</h4>
                                    <p style="padding-bottom: 5px; font-size: 25px; color:#959595;">


                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>

                <td>

                </td>
            </tr>
        </table>
    </div>

    <div class="box-header">
        <h3 class="box-title">AVAILABLE GRN LIST</h3>

        <div class="row">
            <?php
        $result = select('purchases', '*', "action = '0' AND type = 'Order' AND approve !='approve'", '../');

                if ($result) {
                   for ($i = 0; $row = $result->fetch(); $i++) {
            ?>
            

            <div
        style="border-radius: 15px; background-color: #181929; color:aliceblue;  margin: 10px; color:#959595; text-align: center;">
        <table width="100%">
            <tr>
                <td width="10%"><img style="width: 80px; color:#dbdbdb;" src="img/invoice.png" alt=""></td>
                <td align="left">
                <div class="align-line">
                    <p style="color: #fff;">PO No - <?php echo $row['supplier_invoice'] ?></p>
                    <p style="color:#858585" align="right" ><?php echo $row['date'] ?></p>
                    </div>
                    <b style="color:#afb3b8"><?php echo $row['supplier_name'] ?></b>
                </td>
                

            </tr>
        </table>
        <table style="width:100%">
                        <tr>
                            <td>
                            </td>
                            <td>
                                <div align="left" style="width:100%;">

                                    <div
                                        style="color:#6d949e; background-color: #1f2031; text-align: center; border-radius: 0px 15px 0px 15px ;">
                                         Rs.<?php echo $row['amount']; ?></div>

                                </div>
                            </td>
                            <td>
                                <div align="right" style="width:100%;">
                                <a href="grn_order_view_mob.php?id=<?php echo $row['invoice_no']; ?>">
                                        <div class="bg-primary"
                                            style="color:#000000; width:100px; text-align: center; border-radius: 15px 0px 15px 0px;">
                                            View</div>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </table>
       
        
    </div>
            <?php
                    }
                } else {
                    echo "<div class='col-12'><p>No records found.</p></div>";
                }
            ?>
        </div>
    </div>
    </div>








    <br><br>


    <?php $nav="GRN"; include('nav.php'); ?>

    <?php }
$user_pos = $_SESSION['SESS_LAST_NAME'];
if ($user_pos == 'tech') {
    $user_id = $_SESSION['SESS_MEMBER_ID'];
    $result1 = $db->prepare(" SELECT *  FROM user  WHERE id='$user_id' ");
    $result1->bindParam(':userid', $date);
    $result1->execute();
    for ($i = 0; $row1 = $result1->fetch(); $i++) {
        $emp_id = $row1['emp_id'];
    }


    $result = $db->prepare("SELECT job.id, job.time, job.date, job.km, job.vehicle_no,customer.customer_name, customer.contact, job.invoice_no, job.img , job.img_date, job.r_person_name, job.type FROM job INNER JOIN customer ON job.cus_id=customer.id WHERE job.type='active'  ORDER by job.id ASC LIMIT 1;");
    $result->bindParam(':userid', $date);
    $result->execute();
    for ($i = 0; $row = $result->fetch(); $i++) {


        $date = $row['date'];


        $date1 = date("Y-m-d");

        $sday = strtotime($date);
        $nday = strtotime($date1);
        $tdf = abs($nday - $sday);
        $nbday1 = $tdf / 86400;
        $time_on = intval($nbday1);
        $time_type = "Day";
        $color = "red";
        ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3">
        <div style="border-radius: 15px; background-color: #181929; color:aliceblue; margin: 2%; ">


            <table style="width:100%;  margin: 10px;">
                <tr>
                    <td>
                        <img src="../<?php echo $row['img'] ?>" width="100px" alt="">
                    </td>
                    <td>
                        <h3 style="color:#D1D1D1; margin: 10px;"><?php echo $row['vehicle_no']; ?></h3>
                    </td>

                </tr>
                <tr>
                    <td style="color:#686868"><?php echo $row['img_date']; ?></td>
                    <td style="color:#959595"><?php // echo $row['customer_name'];
                            ?></td>
                </tr>

                <tr>
                    <?php $id = $row['id'];
                        $to_co = 0;
                        $end = 0;
                        $result1 = $db->prepare(" SELECT *  FROM job_list  WHERE job_no='$id' AND emp_id='$emp_id' ORDER BY id DESC ");
                        $result1->bindParam(':userid', $date);
                        $result1->execute();
                        for ($i = 0; $row1 = $result1->fetch(); $i++) {
                            $to_co += 1;
                            if ($row1['type'] == 'end') {
                                $end += 1;
                            }
                        } ?>
                    <td style="color:#959595"><?php echo $to_co . "/" . $end; ?></td>
                    <td style="color:#959595"><?php // echo $row['contact'];
                            ?></td>
                </tr>
                <tr>

                </tr>
            </table>

            <table style="width:100%">
                <tr>
                    <td>
                        <div align="left" style="width:100%;">

                            <div class="bg-<?php echo $color; ?>"
                                style="color:#dbdbdb; width:100px;  text-align: center; border-radius: 15px 15px 15px 15px ">
                                <?php echo $time_on . " " . $time_type; ?></div>

                        </div>
                    </td>


                    <td>
                        <div align="right" style="width:100%;">
                            <a href="job_list_view.php?id=<?php echo $row['id']; ?>">
                                <div class="bg-red"
                                    style="color:#dbdbdb; width:100px;  text-align: center; border-radius: 15px 0px 15px 0px">
                                    View
                                </div>
                            </a>

                        </div>
                    </td>
                </tr>
            </table>

        </div>
    </div>
    <?php }
} ?>
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