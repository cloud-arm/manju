<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'company';
?>

<body class="hold-transition skin-blue skin-orange sidebar-mini">

    <?php include_once("start_body.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Branch
                <small>View</small>
            </h1>
        </section>
        <section class="content">

            <div class="row">
                <div class="col-md-3"> 

                    <!-- SELECT2 EXAMPLE -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <?php $id=$_GET['id'];
                            $result=select('branch','*','id='.$id);
                for ($i = 0; $row = $result->fetch(); $i++) {
                    $name=$row['name'];
                    $address=$row['address'];
                    $district=$row['district'];
                }
                ?>

                            <h3 class="profile-username text-center"><?php echo $name; ?></h3>
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Address:</b> <i><?php echo $address; ?></i>
                                </li>

                                <li class="list-group-item">
                                    <b>District:</b> <i><?php echo $district; ?></i>
                                </li>
                            </ul>

                            <a href="cus_view.php" class="btn btn-primary btn-block m-0"><b>Back</b></a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
                <!-- /.col (left) -->


                <div class="col-md-9">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#location" data-toggle="tab">MPO Setting</a></li>
            <li><a href="#contact" data-toggle="tab">Manager Setting</a></li>
            <li><a href="#settings" data-toggle="tab">Settings</a></li>
        </ul>
        <div class="tab-content">
            <div class="active tab-pane" id="location">
                <span onclick="click_open('add')" class="btn btn-primary btn-sm mx-2">Add MPO </span>
                <div>
                    <table id="location_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Adress</th>
                                <th>Contact No</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $result = query("SELECT * FROM employee WHERE branch_id = '$id' AND des = 'MPO'");
                            for ($i = 0; $row = $result->fetch(); $i++) {
                                $location_id = $row['id'];
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['phone_no']; ?></td>
                                <td>
                                    <a class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $location_id; ?>)">Delete</a>
                                </td>
                            </tr>

                            <!-- Popup for editing each location -->
                            <div class="container-up d-none" id="edit_popup_<?php echo $location_id; ?>">
                                <div class="row w-70">
                                    <div class="box box-success popup" style="width: 80%;">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Edit Location: <?php echo $row['name']; ?></h3>
                                            <small onclick="click_close(<?php echo $location_id; ?>)" class="btn btn-sm btn-success pull-right">
                                                <i class="fa fa-times"></i>
                                            </small>
                                        </div>
                                        <div class="box-body">
                                            <form method="POST" action="save/location_save.php">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Name</label>
                                                            <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Address</label>
                                                            <input type="text" name="address" class="form-control" value="<?php echo $row['address']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Type</label>
                                                            <input type="text" name="type" class="form-control" value="<?php echo $row['type']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Email</label>
                                                            <input type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="id" value="<?php echo $location_id; ?>">
                                                    <input type="hidden" name="company_id" value="<?php echo $company_id; ?>">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php 
                    $result = query("SELECT * FROM employee WHERE branch_id = '$id' AND des = 'Branch Manager'"); 
                    $rowCount = $result->rowCount(); // Get the number of rows
                    $buttonDisabled = $rowCount >= 1;
                ?>
            <div class="tab-pane" id="contact">
            <span 
            <?php echo $buttonDisabled ? '' : 'onclick="click_open(2)"'; ?> 
                class="btn btn-primary btn-sm mx-2" 
                <?php echo ($rowCount >= 1) ? 'disabled' : ''; ?>>
                Add Manager
            </span>
                <div>
                    <table id="contact_table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Contact No</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                             for ($i = 0; $row = $result->fetch(); $i++) { 
                                $location_id = $row["id"];
                            ?>
                            <tr>
                                <th><?php echo $row['id']; ?></th>
                                <th><?php echo $row['name']; ?></th>
                                <th><?php echo $row['position']; ?></th>
                                <th><?php echo $row['phone_no']; ?></th>
                                <td>
                                    <a onclick="confirmDelete2(<?php echo $location_id; ?>)" class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane" id="settings">
                <form method="post" action="edit_company.php" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" placeholder="Address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">E-mail</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="E-mail">
                        </div>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="unit" value="1">
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox"> I agree to <a href="#">Submit</a>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->
</div>
<!-- /.box-body -->
<!-- /.box -->
<!-- /.col (right) -->
<!-- /.row -->
</section>
<!-- /.content -->




 





    <?php
    $add_con = 'd-none'; // Initially hide the container
   ?>
<!-- Container for the popup -->
<div class="container-up <?php echo $add_con; ?>" id="add_location_container">
    <div class="row w-70">
        <div class="box box-success popup d-none" id="add_location_popup" style="width: 80%;">
            <div class="box-header with-border">
                <h3 class="box-title">MPO SAVE</h3>
                <small onclick="click_close('add')" class="btn btn-sm btn-success pull-right">
                    <i class="fa fa-times"></i>
                </small>
            </div>
            <div class="box-body d-block">
                <form method="POST" action="save/mpo_save.php">
                    <div class="row" style="display: block;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>MPO List</label>
                                <select class="form-control select2 hidden-search" id="com_type" name="mpo_id" style="width: 100%;" required>
                                <?php $result=query("SELECT * FROM employee WHERE des = 'MPO'");
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                         ?>
                                        <option value="<?php echo $row['id']  ?>"> <?php echo $row['name']  ?> </option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="branch_id" value="<?php echo $id; ?>">
                                
                                <input type="hidden" name="id" value="0">
                                <input type="submit" id="com_save" style="margin-top: 23px; width: 100%;" value="Save" class="btn btn-info btn-sm pull-right">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="box box-success popup d-none" id="popup_2" style="width: 80%;">
    <div class="box-header with-border">
        <h3 class="box-title">MANAGER SAVE</h3>
        <small onclick="click_close(2)" class="btn btn-sm btn-success pull-right"><i class="fa fa-times"></i></small>
    </div>

                <div class="box-body d-block">
                    <form method="POST" action="save/manager_save.php">

                        <div class="row" style="display: block;">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Managers </label>
                                    <select class="form-control select2 hidden-search" name="id" style="width: 100%;"
                                        required>
                                        <?php $result=query("SELECT * FROM employee WHERE des = 'Branch Manager'");
                                        for ($i = 0; $row = $result->fetch(); $i++) {
                                         ?>
                                        <option value="<?php echo $row['id']  ?>"> <?php echo $row['name']  ?> </option>
                                        <?php } ?>
                                        

                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="hidden" name="branch_id" value="<?php echo $id; ?>">
                                    <input type="submit" style="margin-top: 23px; width: 100%;" value="Save"
                                        class="btn btn-info btn-sm pull-right">
                                </div>
                            </div>


                        </div>

                    </form>
                </div>
            </div>
        </div>
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
        <script>
function click_open(type, id = null) {
    // Hide all popups initially
    document.querySelectorAll('.container-up').forEach(function(popup) {
        popup.classList.add('d-none');
    });

    // Open the Add New Location or Contact popup
    if (type === 'add') {
        document.getElementById('add_location_popup').classList.remove('d-none');
        document.getElementById('add_location_container').classList.remove('d-none');
    }
    
    // Open the Add New Contact popup
    if (type === 2) {
        document.getElementById('popup_2').classList.remove('d-none');
        document.getElementById('add_contact_container').classList.remove('d-none');
    }

    // Open the Edit Location popup
    if (type === 'edit') {
        document.getElementById('edit_popup_' + id).classList.remove('d-none');
    }
}

function click_close(type) {
    if (type === 'add') {
        document.getElementById('add_location_popup').classList.add('d-none');
        document.getElementById('add_location_container').classList.add('d-none');
    } else if (type === 2) {
        document.getElementById('popup_2').classList.add('d-none');
        document.getElementById('add_contact_container').classList.add('d-none');
    } else {
        document.getElementById('edit_popup_' + type).classList.add('d-none');
    }
}

    </script>

<script> 
function confirmDelete(mpo_id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = "delete_mpo.php?id=" + mpo_id;
    }
}

function confirmDelete2(manager_id) {
    if (confirm("Are you sure you want to delete this record?")) {
        window.location.href = "delete_manager.php?id=" + manager_id;
    }
}
</script>





</body>

</html>