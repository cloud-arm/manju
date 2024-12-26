<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");

$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'grn_order_rp';
$user_level = $_SESSION['USER_LEWAL'];

$id = $_GET['id'];

?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">

    <?php include_once("start_body.php"); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <?php 
            $r2 = select('purchases_list', '*', "id='$id'", '');
            if ($r2) {
                while ($row2 = $r2->fetch()) {
                    $name1 = $row2['name'];
                }
            }
            ?>
            <h1>
                <?php echo $name1 ?> 
                <small>Details</small>
            </h1>
        </section>

        <section class="content">
            <!-- Purchase History Section -->
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Purchase History</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            $result = select('purchases_list', '*', "id='$id'", '');
                            if ($result) {
                                while ($row = $result->fetch()) {
                                    $product_id = $row['product_id'];
                                    $innerResult = select('purchases_list', 'MAX(id) AS max_id, date, qty', "product_id='$product_id' AND type='GRN'", '');
                                    if ($innerResult) {
                                        while ($innerRow = $innerResult->fetch()) {
                                            $date = $innerRow['date'];
                                            $qty = $innerRow['qty'];
                            ?>
                            <div class="info-box">
                                <span class="info-box-icon bg-blue"><i class="fa fa-calendar"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Last Purchase Date</span>
                                    <span class="info-box-number"><?php echo $date; ?></span>
                                    <span class="info-box-text">Quantity: <?php echo $qty; ?></span>
                                </div>
                            </div>
                            <?php
                                        }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Quantity Details</h3>
                        </div>
                        <div class="box-body">
                            <?php
                            $result = select('materials', '*', "id='$product_id'", '');
                            if ($result) {
                                while ($row = $result->fetch()) {
                                    $available = $row['available_qty'];
                                    $reorder = $row['re_order'];
                            ?>
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="fa fa-cubes"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Stock Quantity</span>
                                    <span class="info-box-number"><?php echo $available; ?></span>
                                </div>
                            </div>
                            <div class="info-box">
                                <span class="info-box-icon bg-orange"><i class="fa fa-exclamation-triangle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Reorder Quantity</span>
                                    <span class="info-box-number"><?php echo $reorder; ?></span>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Purchase Trends</h3>
                        </div>
                        <div class="box-body">
                            <canvas id="purchaseChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Fixing History</h3>
                        </div>
                        <div class="box-body">
                            <?php
                                $result = query(" SELECT * 
                                FROM inventory
                                WHERE material_id = '$product_id' 
                                AND type = 'out' 
                                ORDER BY id DESC LIMIT 10", '');
                            if ($result) {
                                while ($row = $result->fetch()) { ?>
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="fa fa-wrench"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Job No: <?php echo $job_no = $row['job_no']; ?></span>
                                    <span class="info-box-text">Quantity: <?php echo $qty4 = $row['qty']; ?></span>
                                    <span class="info-box-number"><?php echo $date = $row['date']; ?></span>
                                </div>
                            </div>
                            <?php  }  }  ?>
                        </div>

                    </div>
                </div>
            </div>




            <?php

// Query to fetch the purchase quantity and dates
$result = query("SELECT date, SUM(qty) AS total_qty 
FROM purchases_list 
WHERE type = 'GRN' 
AND product_id = '$product_id'
GROUP BY date 
ORDER BY date LIMIT 10;", '');

$labels = [];
$data = [];

if ($result) {
    while ($row = $result->fetch()) {
        $labels[] = $row['date'];
        $data[] = $row['total_qty'];
    }


}

// Convert PHP arrays to JSON for JavaScript
$labelsJSON = json_encode($labels);
$dataJSON = json_encode($data);
?>


            <!-- Fixing History Section -->
            <div class="row">

            </div>
        </section>
    </div>

    <?php include("dounbr.php"); ?>
    <div class="control-sidebar-bg"></div>
    <?php include_once("script.php"); ?>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Use PHP to inject dynamic data into JavaScript
    const labels = <?php echo $labelsJSON; ?>; // Dates
    const data = <?php echo $dataJSON; ?>; // Quantities

    const ctx = document.getElementById('purchaseChart').getContext('2d');
    const purchaseChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Purchase Quantity',
                data: data,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4 // Add smooth curves
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Quantity: ${context.raw}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Quantity'
                    }
                }
            }
        }
    });
    </script>

</body>