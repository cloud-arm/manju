<!DOCTYPE html>
<html>
<?php
include("head.php");
include_once("auth.php");
$r = $_SESSION['SESS_LAST_NAME'];
$_SESSION['SESS_FORM'] = 'index';
$user_level = $_SESSION['USER_LEWAL'];

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
            $id = base64_decode($_GET['id']);
            $result = select('sales_list', '*', 'id=' . $id);
            if ($row = $result->fetch()) {
                $location = $row['location'];
                $width = $row['width'];
                $height = $row['height'];
                $product_name = $row['name'];
                $status = $row['status'];
                $job_no = $row['job_no'];
                $status_id = $row['status_id'];
                $about = $row['about'];
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
                                    <div class="form-group">
                                        <label>Location:</label>
                                        <p><?php echo $location; ?></p>
                                    </div>

                                    <div class="form-group">
                                        <label>Product Name:</label>
                                        <p><?php echo $product_name; ?></p>
                                    </div>

                                    <div class="form-group">
                                        <label>Discription:</label>
                                        <p><?php echo $about; ?></p>
                                    </div>

                                    <?php
                            // Fetch measurement data from the database
                            $result3 = select('sales_list', '*', 'id=' . $id);
                            if ($row = $result3->fetch()) {
                            ?>
                                    <div class="form-group">
                                        <label>Width:</label>
                                        <p><?php echo $row['width'] ?></p>
                                    </div>

                                    <div class="form-group">
                                        <label>Height:</label>
                                        <p><?php echo $row['height'] ?> </p>
                                    </div>

                                    <div class="form-group">
                                        <label>Square Area:</label>
                                        <p><?php echo $row['sqrt'] ?> </p>
                                    </div>

                                    <?php 
                                        $status = $row['status'];
                                        $icon = '';
                                        $badgeStyle = 'color: white; padding: 5px 20px; border-radius: 30px; display: inline-flex; align-items: center; justify-content: center; margin-top: 10px; font-size: 1.2rem;';
                                        $backgroundColor = '#7393B3'; // Default background color

                                        if ($status == 'on_aprove') {
                                            $icon = 'fas fa-check-circle';
                                            $backgroundColor = '##ffc107'; // yellow for approve
                                        } elseif ($status == 'printing') {
                                            $icon = 'fas fa-print';
                                            $backgroundColor = '#007bff'; // Blue for printing
                                        } elseif ($status == 'artwork') {
                                            $icon = 'fas fa-palette';
                                            $backgroundColor = '#17a2b8'; // Coral for artwork
                                        } elseif ($status == 'pending') {
                                            $icon = 'fas fa-exclamation-circle';
                                            $backgroundColor = '#ffc107'; // Yellow for pending
                                        } elseif ($status == 'measure') {
                                            $icon = 'fas fa-ruler';
                                            $backgroundColor = '#1434A4'; // Gray for measure
                                        } elseif ($status == 'fix') {
                                            $icon = 'fas fa-wrench';
                                            $backgroundColor = '#5D3FD3'; // Teal for fix
                                        } elseif ($status == 'complete') {
                                            $icon = 'fas fa-check-double';
                                            $backgroundColor = '#28a745'; // Green for complete
                                        }

                                        // Apply the background color to the badge
                                        if ($icon) {
                                            echo '<div align="center" style="width:100%; margin-top: 20px;">
                                                    <div class="badge" style="' . $badgeStyle . ' background-color: ' . $backgroundColor . ';">
                                                        <i class="' . $icon . '" style="margin-right: 10px;"></i>' . ucfirst($status) . '
                                                    </div>
                                                </div>';
                                        }
                                        ?>

                                    <?php if($status != 'measure'){ ?>
                                    <div class="text-center" style="margin-top: 20px;">
                                        <button onclick="edit_note(<?php echo $row['id']; ?>)"
                                            class="btn btn-sm btn-info" id="edit_measure" style="padding: 5px 25px; font-size: 1rem;">
                                            <i class="fas fa-edit"></i> Edit Note
                                        </button>
                                    </div>
                                    <?php } ?>


                                    <?php if($status == 'measure'){ ?>
                                    <div class="text-center" style="margin-top: 20px;">
                                        <h5>If you wish to delete this job process without adding details, click the
                                            button below:</h5>


       
                                        <button onclick="delete_note(<?php echo $row['id']; ?>)"
                                            class="btn btn-sm btn-danger" id="del_note" style="padding: 5px 25px; font-size: 1.2rem; background-color: #FF4433; color: white; border: none;"
                                            >
                                           Delete
                                        </button>
                                    </div>
                                    <?php } ?>

                                    <!-- delete popup-->
                                    <div class="container-up d-none" id="delete_popup_<?php echo $row['id']; ?>">
                                        <div class="row w-70">
                                            <div class="box box-success popup" style="width: 150%;">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Reason for the Delete</h3>
                                                    <small onclick="delete_close(<?php echo $row['id']; ?>)"
                                                        class="btn btn-sm btn-success pull-right"><i
                                                            class="fa fa-times"></i></small>
                                                    <i class="fa fa-times"></i>
                                                    </small>
                                                </div>
                                                <div class="box-body d-block">
                                                    <form method="POST" action="process_dill.php">
                                                        <div class="row" style="display: block;">




                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label>Reason for delete</label>
                                                                    <input type="text" name="reason" class="form-control"
                                                                         required>

                                                                </div>
                                                            </div>





                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="unit" value="1">
                                                                    <input type="hidden" name="id"
                                                                        value="<?php echo $row['id']; ?>">

                                                                    <input type="submit"
                                                                        style="margin-top: 23px; background-color: #FF4433; color: white; width: 100%;"
                                                                        value="Click hear for delete" class="btn btn-info btn-sm">
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                  <!-- edit popup-->
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
                            onclick="window.location.href='job_view.php?id=<?php echo base64_encode($job_no); ?>'">
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
                                <?php
                                    $id =  base64_decode($_GET['id']);
                                    $result = select('sales_list', '*', 'id=' . $id);
                                    if ($row = $result->fetch()) {
                                        $location = $row['location'];
                                        $width = $row['width'];
                                        $height = $row['height'];
                                        $product_name = $row['name'];
                                        $status = $row['status'];
                                        $job_no = $row['job_no'];
                                        $m_date = $row['m_date'];
                                        $sqrt = $row['sqrt'];
                                        $m_img = $row['m_img'];
                                        $approvel_doc = $row['approvel_doc'];
                                        $sales_list_id=$row['id'];
                                    }
                                    ?>
                                <i class="fa fa-ruler bg-blue"></i>
                                <div class="timeline-item">
                                    <?php 
                                     $date='0000-00-00'; $time='00:00:00';
                    
                                        $re = select('user_activity', '*', 'source_id=' . $id . ' AND activity="measure"');
                                        $user_name = ''; // Initialize the variable to check later
                                        
                                        while ($row = $re->fetch()) {
                                            $user_name = $row['user_name'];
                                            $date=$row['date'];
                                            $time=$row['time'];
                                        }
                                        
                                        // Check if $user_name has a value; if not, set it to "Not set"
                                        $display_name = !empty($user_name) ? $user_name : 'Not set';
                                    ?>
                                    <?php if ($status != 'measure') { ?>

                                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo $date.' | '.$time?>
                                    </span>
                                    <h3 class="timeline-header">
                                        <a href="#">Measurement Added For</a> <?php echo $product_name ?>
                                    </h3>
                                    <?php } else { ?>
                                    <span class="time"><i class="fa fa-clock-o"></i> <?php echo "not yet" ?> </span>
                                    <h3 class="timeline-header">
                                        <a href="#">Measurement details Form</a> aded via admin
                                    </h3>
                                    <?php } ?>

                                    <!-- MEASUREMENT shows -->
                                    <?php if ($status != 'measure') { ?>
                                    <div class="timeline-body">
                                        <p>Assigned measurer or admin input measurement details:</p>
                                        <p><strong>Width:</strong> <?php echo $width ?>, <strong>Height:</strong>
                                            <?php echo $height ?>, <strong>SQRT:</strong> <?php echo $sqrt ?></p>
                                        <p><strong class="text-primary">Measurer Note:</strong>
                                            <?php echo $row['note'] ?></p>
                                        <?php if (!empty($m_img)) { ?>
                                        <img src="app/save/uploads/product_img/<?php echo $m_img; ?>"
                                            alt="Uploaded Photo" style="width: 200px; height: auto;">
                                        <?php } else { ?>
                                        No photo uploaded.
                                        <?php } ?>
                                    </div>

                                    <div class="timeline-footer"
                                        style="display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <a class="btn btn-primary btn-xs">Read more</a>
                                            <a class="btn btn-danger btn-xs">Delete</a>
                                        </div>

                                        <div style="margin-left: auto; font-size: 12px; color: #555;">
                                            <?php 
        $re = select('user_activity', '*', 'source_id=' . $id . ' AND activity="measure"');
        $user_name = ''; // Initialize the variable to check later
        
        while ($row = $re->fetch()) {
            $user_name = $row['user_name'];
        }
        
        // Check if $user_name has a value; if not, set it to "Not set"
        $display_name = !empty($user_name) ? $user_name : 'Not set';
    ?>
                                            <span class="time">
                                                <i class="fa fa-user" style="margin-right: 5px;"></i> done by
                                                <?php echo $display_name ?>
                                            </span>
                                        </div>

                                    </div>





                                    <?php } ?>

                                    <!-- Add Measurement Form -->
                                    <?php if ($status == 'measure') { ?>

                                    <div class="timeline-body">
                                        <form method="POST" action="app/save/task_save.php"
                                            enctype="multipart/form-data">
                                            <div class="row" style="padding: 15px;">
                                                <div class="form-group col-md-6">
                                                    <label for="width">Width:</label>
                                                    <input type="number" id="width" name="width" class="form-control"
                                                        step="0.01" min="0" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="height">Height:</label>
                                                    <input type="number" id="height" name="height" class="form-control"
                                                        step="0.01" min="0" required>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="fileToUpload">Select Image to Upload:</label>
                                                    <input type="file" name="fileToUpload" id="fileToUpload"
                                                        class="form-control">
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <label for="note">Note:</label>
                                                    <textarea name="note" id="m_note" class="form-control" rows="5"
                                                        style="resize: none;"
                                                        placeholder="Enter your note here"></textarea>
                                                </div>

                                                <div class="form-group col-md-12">
                                                    <input type="hidden" name="id" value="<?php echo $sales_list_id;?>">
                                                    <input type="hidden" name="id2" value="0">
                                                    <input type="submit" id="m_save" value="Save" class="btn btn-info btn-sm"
                                                        style="width: 100%; margin-top: 15px;">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php } ?>


                                </div>
                            </li>

                            <?php } ?>

                            <?php if ($status_id >= 1){ ?>
                            <li>
                                <i class="fa fa-palette bg-aqua"></i>
                                <div class="timeline-item">
                                    <?php 
                                     $date='0000-00-00'; $time='00:00:00';
                    
                                        $re = select('user_activity', '*', 'source_id=' . $id . ' AND activity="art_work"');
                                        $user_name = ''; // Initialize the variable to check later
                                        
                                        while ($row = $re->fetch()) {
                                            $user_name = $row['user_name'];
                                            $date=$row['date'];
                                            $time=$row['time'];
                                        }
                                        
                                        // Check if $user_name has a value; if not, set it to "Not set"
                                        $display_name = !empty($user_name) ? $user_name : 'Not set';
                                    ?>
                                    <?php if ($status != 'artwork') { ?>
                                    <span class="time"><i
                                            class="fa fa-clock-o"></i><?php echo $date.' | '.$time ?></span>
                                    <h3 class="timeline-header">
                                        <a href="#" class="text-primary">Art Work Completed</a>
                                    </h3>

                                    <div class="timeline-body">
                                        <p>The artwork has been completed by the designer.</p>
                                        <p><strong class="text-primary">Designer Note:</strong>
                                            <?php echo $row['art_note']; ?></p>
                                    </div>

                                    <div class="timeline-footer"
                                        style="display: flex; justify-content: space-between; align-items: center;">


                                        <div style="margin-left: auto; font-size: 12px; color: #555;">

                                            <span class="time">
                                                <i class="fa fa-user" style="margin-right: 5px;"></i> done by
                                                <?php echo $display_name ?>
                                            </span>
                                        </div>

                                    </div>


                                    <?php } ?>
                                    <?php if ($status == 'artwork') { ?>
                                    <span class="time"><i class="fa fa-clock-o"></i> not yet</span>
                                    <h3 class="timeline-header">
                                        <a href="#" class="text-primary">Add designer note</a>
                                    </h3>

                                    <div class="timeline-body">
                                        <div class="row" style="padding: 15px;">
                                            <div class="box box-success" style="width: 100%; padding: 20px;">


                                                <!-- First form: Note and File Upload -->
                                                <form method="POST"
                                                    action="save/job/job_summery_save.php?id=<?php echo $id ?>"
                                                    enctype="multipart/form-data">
                                                    <div class="row" style="padding: 15px;">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>Note</label>
                                                                <textarea name="note" id="d_note" class="form-control" rows="5"
                                                                    style="resize: none;" autocomplete="off"
                                                                    placeholder="Enter your note here"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id2" value="1">
                                                                <input type="submit"
                                                                    style="margin-top: 23px; width: 100%;"
                                                                    id="d_save"
                                                                    value="Save and Add Designer Note"
                                                                    class="btn btn-info btn-sm">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>

                                    <?php } ?>

                            </li>
                            <?php } ?>

                            <?php if ($status_id >= 2){ ?>
                            <li>
                                <i class="fa fa-check-circle bg-yellow"></i>
                                <div class="timeline-item">
                                    <?php 
                                     $date='0000-00-00'; $time='00:00:00';
                    
                                        $re = select('user_activity', '*', 'source_id=' . $id . ' AND activity="approve"');
                                        $user_name = ''; // Initialize the variable to check later
                                        
                                        while ($row = $re->fetch()) {
                                            $user_name = $row['user_name'];
                                            $date=$row['date'];
                                            $time=$row['time'];
                                        }
                                        
                                        // Check if $user_name has a value; if not, set it to "Not set"
                                        $display_name = !empty($user_name) ? $user_name : 'Not set';
                                    ?>

                                    <?php if ($status != 'on_aprove' && $status != 'reject') { ?>
                                    <span class="time"><i class="fa fa-clock-o"></i>
                                        <?php echo $date.' | '.$time ?></span>
                                    <h3 class="timeline-header"><a href="#">Job Approved taken successfully</a></h3>

                                    <div class="timeline-body">
                                        <p>Approval has been given by the admin with the following note and document:
                                        </p>
                                        <p><strong class="text-primary">Approve Note:</strong>
                                            <?php echo $row['approvel_note'] ?></p>
                                        <?php if (!empty($approvel_doc)) { ?>
                                        <img src="app/save/uploads/product_img/<?php echo $approvel_doc; ?>"
                                            alt="Uploaded Photo" style="width: 200px; height: auto;">
                                        <?php } else { ?>
                                        No photo uploaded.
                                        <?php } ?>
                                    </div>
                                    <div class="timeline-footer"
                                        style="display: flex; justify-content: space-between; align-items: center;">


                                        <div style="margin-left: auto; font-size: 12px; color: #555;">

                                            <span class="time">
                                                <i class="fa fa-user" style="margin-right: 5px;"></i> done by
                                                <?php echo $display_name ?>
                                            </span>
                                        </div>

                                    </div>

                                    <?php } ?>

                                    <?php if ($status == 'on_aprove') { ?>

                                    <span class="time"><i class="fa fa-clock-o"></i>0000-00-00</span>
                                    <h3 class="timeline-header"><a href="#">Job Approved Form</a></h3>

                                    <div class="timeline-body">
                                        <div class="row" style="padding: 15px;">
                                            <div class="box box-success" style="width: 100%; padding: 20px;">


                                                <div class="box-body">
                                                    <!-- First form: Note and File Upload -->
                                                    <form method="POST"
                                                        action="save/job/measure_save.php?id=<?php echo $id ?>"
                                                        enctype="multipart/form-data">
                                                        <div class="row" style="padding: 15px;">
                                                            <div class="form-group col-md-12">
                                                                <label for="note">Note:</label>
                                                                <textarea name="note" id="app_note" class="form-control" rows="5"
                                                                    style="resize: none;" autocomplete="off"
                                                                    placeholder="Enter your note here"></textarea>
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <label for="document">Upload Document (PDF or
                                                                    Image):</label>
                                                                <input type="file" name="document" class="form-control"
                                                                    accept=".pdf,.jpg,.jpeg,.png">
                                                            </div>

                                                            <div class="form-group col-md-12">
                                                                <div class="row">
                                                                    <!-- Save and Accept Button -->
                                                                    <div class="col-md-6">
                                                                        <input type="hidden" name="id2" 
                                                                            value="0">
                                                                        <!-- Default id2 value for "Save and Accept" -->
                                                                        <button type="submit"
                                                                            class="btn btn-info btn-sm"
                                                                            id="id2"

                                                                            style="width: 100%; margin-top: 15px;">Save
                                                                            and Accept</button>
                                                                    </div>

                                                                    <!-- Decline Button -->
                                                                    <div class="col-md-6">
                                                                        <button type="submit" name="id2" value="2"
                                                                            class="btn btn-danger btn-sm"
                                                                            style="width: 100%; margin-top: 15px;">Decline</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <?php }if($status == 'reject'){?>

                                    <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>
                                    <h3 class="timeline-header"><a href="#">Job Rejected</a></h3>
                                    <div class="timeline-body">
                                        <p>The job request was rejected by the admin and cannot be processed further.
                                        </p>
                                        </p>
                                        <p><strong class="text-primary">REJECT</strong>
                                        </p>

                                    </div>
                                </div>

                                <?php } ?>


                    </div>
                    </li>
                    <?php } ?>

                    <?php if ($status_id >= 4){ ?>
                    <li>
                        <?php 
                                     $date='0000-00-00'; $time='00:00:00';
                    
                                        $re = select('user_activity', '*', 'source_id=' . $id . ' AND activity="printing"');
                                        $user_name = ''; // Initialize the variable to check later
                                        
                                        while ($row = $re->fetch()) {
                                            $user_name = $row['user_name'];
                                            $date=$row['date'];
                                            $time=$row['time'];
                                        }
                                        
                                        // Check if $user_name has a value; if not, set it to "Not set"
                                        $display_name = !empty($user_name) ? $user_name : 'Not set';
                                    ?>
                        <i class="fa fa-print bg-purple"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i><?php echo $date.' | '.$time ?></span>
                            <h3 class="timeline-header"><a href="#">Printing Completed</a></h3>
                            <div class="timeline-body">
                                <p>The product was printed by the printing department.</p>
                                <p><strong>Printing Note:</strong> <?php echo $row['print_note'] ?></p>
                                <p><strong>Printing Quantity:</strong> <?php echo $row['print_qty'] ?></p>
                            </div>
                            <div class="timeline-footer"
                                style="display: flex; justify-content: space-between; align-items: center;">

                                <div style="margin-left: auto; font-size: 12px; color: #555;">

                                    <span class="time">
                                        <i class="fa fa-user" style="margin-right: 5px;"></i> done by
                                        <?php echo $display_name ?>
                                    </span>
                                </div>

                            </div>
                        </div>

                    </li>
                    <?php } ?>

                    <?php if ($status_id >= 4){ ?>
                    <li>
                        <?php 
                                     $date='0000-00-00'; $time='00:00:00';
                    
                                        $re = select('user_activity', '*', 'source_id=' . $id . ' AND activity="fix"');
                                        $user_name = ''; // Initialize the variable to check later
                                        
                                        while ($row = $re->fetch()) {
                                            $user_name = $row['user_name'];
                                            $date=$row['date'];
                                            $time=$row['time'];
                                        }
                                        
                                        // Check if $user_name has a value; if not, set it to "Not set"
                                        $display_name = !empty($user_name) ? $user_name : 'Not set';
                                    ?>
                        <i class="fa fa-wrench bg-maroon"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> <?php echo $date.' | '.$time ?></span>
                            <h3 class="timeline-header"><a href="#">Fix Completed</a></h3>
                            <?php if ($user_level == 1 || $user_level == 3 || $user_level == 5) { ?>

                            <div class="timeline-body">
                                <?php if($status == 'fix') {?>

                                <div class="box box-info">
                                    <div class="box-header">
                                        <h3>FIX Materials <small>Add</small></h3>
                                    </div>
                                    <div
                                        class="box-body <?php if ($status == 'fix' || $status == 'complete') {} else { echo 'd-none'; } ?>">
                                        <form action="save/job/job_fix_save.php?id=<?php echo $id ?>" method="post">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Used Materials</label>
                                                        <select class="form-control select2 " id="mat_id" name="mat_id"
                                                            onchange="pro_select()" style="width: 100%;" tabindex="1"
                                                            autofocus required>
                                                            <?php 
                                                                        $result = select('materials', '*');
                                                                        while ($row = $result->fetch()) { 
                                                                            $mat_id = $row['id']; 
                                                                    ?>
                                                            <option value="<?php echo $row['id']; ?>">
                                                                <?php echo $row['name']; ?>
                                                            </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                                <label>Unit</label>
                                                            <select class="form-control select2" name="unit" id="unit"
                                                                style="width: 100%;" tabindex="1" autofocus>
                                                                <option value="0">Default</option>

                                                                <!-- Options will be populated dynamically by JavaScript -->
                                                            </select>
                                                    </div>
                                                </div>


                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Quantity</label>
                                                        <input type="number" class="form-control" name="qty" id="qty"
                                                            step="0.001" min="0" style="width: 100%;" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="hidden" value="1" name="id2">
                                                        <input type="submit" style="margin-top: 23px; width: 100%;"
                                                            id="u3" value="Save" class="btn btn-info btn-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="box-body">
                                            <table id="example2" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Name</th>
                                                        <th>Unit</th>
                                                        <th>Type</th>
                                                        <th>QTY</th>
                                                        <th>@</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                         // Fetch fix materials data from the database
                                                          $result = select('fix_materials', '*', 'sales_list_id=' . $id);
                                                           while ($row = $result->fetch()) { ?>
                                                    <tr>
                                                        <td><?php echo $row['id']; ?></td>
                                                        <td><?php echo $row['mat_name']; ?></td>
                                                        <td><?php echo $row['unit']; ?></td>
                                                        <td><?php echo $row['type']; ?></td>
                                                        <td><?php echo $row['qty']; ?></td>
                                                        <td> <a class="btn btn-sm btn-danger"
                                                                onclick="confirmDelete2(<?php echo $row['id']; ?>)"><i
                                                                    class="fa fa-trash"></i></a></td>

                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Fix done button -->
                                        <form action="save/job/job_fix_save.php?id=<?php echo $id; ?>" method="post">
                                            <input type="hidden" value="0" name="id2">
                                            <!-- Set id2 to 0 for Fix done -->
                                            <?php if ($status == 'fix') { ?>
                                            <button type="submit" class="btn btn-sm btn-info"
                                                style="padding: 8px 20px;">Fix done</button>
                                            <?php } ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>



                            <?php } ?>

                            <?php if($status != 'fix') {?>

                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>QTY</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                                    // Fetch fix materials data from the database
                                                    $result = select('fix_materials', '*', 'sales_list_id=' . $id);
                                                    while ($row = $result->fetch()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['mat_name']; ?></td>
                                            <td><?php echo $row['type']; ?></td>
                                            <td><?php echo $row['qty']; ?></td>


                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <hr>

                            <?php }  ?>
                            <div class="timeline-footer"
                                style="display: flex; justify-content: space-between; align-items: center;">


                                <div style="margin-left: auto; font-size: 12px; color: #555;">

                                    <span class="time">
                                        <i class="fa fa-user" style="margin-right: 5px;"></i> done by
                                        <?php echo $display_name ?>
                                    </span>
                                </div>

                            </div>
                        </div>

                </div>
                </li>
                <?php } ?>

                <?php if ($status_id >= 5){ ?>
                <li>
                    <i class="fa fa-check-circle bg-green"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> 5 days ago</span>
                        <h3 class="timeline-header"><a href="#">Job Completed</a></h3>
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
    function edit_note(i) {
        //  $(".popup").addClass("d-none");
        $("#edit_popup_" + i).removeClass("d-none");
    }

    function edit_close(i) {
        //  $(".popup").addClass("d-none");
        $("#edit_popup_" + i).addClass("d-none");
    }

    function delete_note(i) {
        //  $(".popup").addClass("d-none");
        $("#delete_popup_" + i).removeClass("d-none");
    }

    function delete_close(i) {
        //  $(".popup").addClass("d-none");
        $("#delete_popup_" + i).addClass("d-none");
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