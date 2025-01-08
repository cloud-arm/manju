<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'grn_order_rp';
date_default_timezone_set("Asia/Colombo");
?>

<body class="hold-transition skin-blue skin-orange sidebar-mini ">

<?php 
    include_once("start_body.php"); 
    include("connect.php");
      date_default_timezone_set("Asia/Colombo");
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>View</small>
      </h1>
    </section>

<section class="content">
<div class="box box-info">
<div class="box-header with-border">
    <div class="container my-5">
        <!-- Header Section -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-highlight p-3">
                    <div class="row">
                        <div class="col-6">
                            <h5>Total Time</h5>
                            <h2 class="text-highlight">03 : 29</h2>
                            <p>Daily: 01:05</p>
                        </div>
                        <div class="col-6 text-end">
                            <img src="https://via.placeholder.com/150" alt="Employee" class="img-fluid">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4 text-center">
                            <div class="card p-2">
                                <h6>Visit Count</h6>
                                <h4>25</h4>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="card p-2">
                                <h6>Clients</h6>
                                <h4>3</h4>
                            </div>
                        </div>
                        <div class="col-4 text-center">
                            <div class="card p-2">
                                <h6>Completed Tasks</h6>
                                <h4>17</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-highlight p-3 mt-3">
                    <h5>Branch Manager Working Hours</h5>
                    <canvas id="chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Latest Orders</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th width="20%">Model</th>
                                            <th width="50%">Percentage</th>
                                            <th>Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $color="green";

                    $result1 = Query("SELECT sum(amount) FROM model ");
                                        
                    for($i=0; $row1 = $result1->fetch(); $i++){
                    $month_amount=$row1['sum(amount)'];
                    }
			
                $result = query("SELECT * FROM model ORDER by amount DESC limit 0,7");
                for($i=0; $row = $result->fetch(); $i++){
					  
					if($i==0){ $color="green"; $color1="success"; }
					if($i==1){ $color="yellow"; $color1="warning"; }
					if($i==2){ $color="red"; $color1="danger"; }
					if($i==3){ $color=""; $color1=""; }
					if($i==4){ $color=""; $color1=""; }

                    $h1=$month_amount;
                    $h2=$row['amount'];
                    $h3=$h1/100;
                    $h41=$h2/$h3;
                    $h41=number_format($h41,1);
					?>
                                        <tr>
                                            <td><img style="width: 110px" src="<?php echo $row['parth'];?>">


                                            </td>
                                            <td><?php echo $row['name'];?><div class="progress progress active">
                                                    <div class="progress-bar progress-bar-<?php echo $color;?> progress-bar-striped"
                                                        style="width: <?php echo $h41;?>%"></div>
                                                </div>
                                            </td>
                                            <td><span
                                                    class="badge bg-<?php echo $color;?>"><?php echo $h41;?>%</span><br>
                                                <span class="badge bg-">Rs.<?php echo $row['amount'];?></span>
                                            </td>

                                        </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.table-responsive -->

                        </div>


                    </div>
        </div>

        <div class="col-md-6">
                    <!-- LINE CHART -->
                    <div class="box box-solid bg-teal-gradient">
                        <div class="box-header">
                            <i class="fa fa-th"></i>

                            <h3 class="box-title">Net Profit Graph</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i
                                        class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body border-radius-none">
                            <div class="chart" id="line-chart" style="height: 300px;"></div>
                        </div>
                    </div>

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Emp Month Sale</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart">
                                <canvas id="barChart" style="height:230px"></canvas>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>



        </div>
    </div>

    <div class="box box-info">

                <div class="box-header with-border">

                    <h3 class="box-title"><?php echo date("Y")-1 ?> to <?php echo date("Y") ?> Sales Chart</h3>
                    <div class="chart">

                        <canvas id="lineChart" style="height:250px"></canvas>

                    </div>

                    <!-- Main content -->
                </div>

    </div>

</div>
</div>
</section>
</div>

<?php
  include("dounbr.php");
  ?>

<div class="control-sidebar-bg"></div>
  </div>

  <?php 
//   include_once("script.php"); 
  ?>

    <!-- jQuery 2.2.3 -->
    <script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../../bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../../plugins/morris/morris.min.js"></script>
    <!-- FastClick -->
    <script src="../../plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
    <!-- page script -->

    <!-- ChartJS 1.0.1 -->
    <script src="../../plugins/chartjs/Chart.min.js"></script>

<?php

// include_once("script.php");
include("chart.php");

?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sample Chart Data
        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Working Hours',
                    data: [5, 10, 15, 20, 10, 15, 5],
                    borderColor: '#007bff',
                    borderWidth: 2,
                    fill: false
                }]
            }
        });
    </script>
</body>
</html>
