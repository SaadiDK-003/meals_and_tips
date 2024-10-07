<?php
require_once './core/database.php';
if (isLoggedin() === false || $userRole == 'patient') {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= TITLE ?> | Dashboard</title>
    <?php include './includes/css_links.php'; ?>
    <link rel="stylesheet" href="./css/style.min.css">
</head>

<body class="cafe_owner_dashboard_page">
    <?php include_once './includes/header.php'; ?>
    <main>
        <section class="cafe_owner_dashboard">
            <div class="container my-5">
                <div class="row">
                    <div class="col-12 text-center position-relative">
                        <h1>Dashboard</h1>
                        <h5>Welcome, <?= $userName ?></h5>
                        <a href="edit_profile.php?u_id=<?= $userID ?>" class="edit-profile-btn position-absolute btn btn-primary">Edit Information</a>
                        <a href="edit_profile.php?profile_id=<?= $userID ?>" class="edit-profile-btn edit-profile-pic position-absolute btn btn-secondary">Edit Picture</a>
                    </div>

                    <!-- RESERVATION TABLE START -->
                    <div class="col-12">
                        <h3>Appointment Table</h3>
                    </div>
                    <div class="col-12">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Start Time</th>
                                    <th>Status</th>
                                    <th>Patient Info</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $date = '';
                                $getR_Q = $db->query("CALL `get_appointment_patient`($userID)");
                                while ($getRow = mysqli_fetch_object($getR_Q)) :
                                    $date = date('d-M-Y h:i A', strtotime($getRow->start_time));
                                ?>
                                    <tr>
                                        <td><?= $getRow->r_id ?></td>
                                        <td><?= $date ?></td>
                                        <td><?php
                                            if ($getRow->r_status == 'pending') : ?>
                                                <span class="btn btn-warning"><?= $getRow->r_status ?></span>
                                            <?php elseif ($getRow->r_status == 'reserved') : ?>
                                                <span class="btn btn-info"><?= $getRow->r_status ?></span>
                                            <?php else : ?>
                                                <span class="btn btn-success"><?= $getRow->r_status ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><a href="#!" class="btn btn-secondary patient-id" data-id="<?= $getRow->patient_id ?>">Patient Info</a></td>
                                        <td><a href="#!" data-id="<?= $getRow->r_id ?>" class="btn btn-primary btn-sm update-info">Update</a></td>
                                    </tr>
                                <?php endwhile;
                                $getR_Q->close();
                                $db->next_result();
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Start Time</th>
                                    <th>Status</th>
                                    <th>Patient Info</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- RESERVATION TABLE END -->


                    <!-- RESERVATION TABLE COMPLETED START -->
                    <div class="col-12">
                        <h3>Appointment Table</h3>
                    </div>
                    <div class="col-12">
                        <table id="example1" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Start Time</th>
                                    <th>Status</th>
                                    <th>Patient Info</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $date = '';
                                $getR_Q = $db->query("CALL `get_appointment_patient_completed`($userID)");
                                while ($getRow = mysqli_fetch_object($getR_Q)) :
                                    $date = date('d-M-Y h:i A', strtotime($getRow->start_time));
                                ?>
                                    <tr>
                                        <td><?= $getRow->r_id ?></td>
                                        <td><?= $date ?></td>
                                        <td><?php
                                            if ($getRow->r_status == 'pending') : ?>
                                                <span class="btn btn-warning"><?= $getRow->r_status ?></span>
                                            <?php elseif ($getRow->r_status == 'reserved') : ?>
                                                <span class="btn btn-info"><?= $getRow->r_status ?></span>
                                            <?php else : ?>
                                                <span class="btn btn-success"><?= $getRow->r_status ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><a href="#!" class="btn btn-secondary patient-id" data-id="<?= $getRow->patient_id ?>">Patient Info</a></td>
                                        <td><a href="#!" data-id="<?= $getRow->r_id ?>" class="btn btn-primary btn-sm update-info">Update</a></td>
                                    </tr>
                                <?php endwhile;
                                $getR_Q->close();
                                $db->next_result();
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Start Time</th>
                                    <th>Status</th>
                                    <th>Patient Info</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- RESERVATION TABLE COMPLETED END -->

                </div>
            </div>
        </section>
    </main>

    <!-- Modal Visitor Info -->
    <div class="modal fade" id="visitorInfoModal" tabindex="-1" aria-labelledby="visitorInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visitorInfoModalLabel">Patient Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row text-center">
                        <div class="col-12 col-md-4">
                            <div class="text">
                                <h5>Name</h5>
                                <h6 id="visitorName"></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="text">
                                <h5>Email</h5>
                                <h6 id="visitorEmail"></h6>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="text">
                                <h5>Phone</h5>
                                <h6 id="visitorPhone"></h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Update Reservation -->
    <div class="modal fade" id="updateReservationModal" tabindex="-1" aria-labelledby="updateReservationLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateReservationLabel">Patient Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="update-reservation-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 msg-show"></div>
                            <div class="col-12">
                                <label for="r_status">Status</label>
                                <select name="r_status" id="r_status" class="form-select" required>
                                    <option value="" selected hidden>Select Status</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancel">Cancel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="update_res_id" id="update_res_id" value="">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="toast-container position-absolute p-3 bottom-0 end-0">
        <div class="toast align-items-center text-white bg-danger border-0" data-bs-animation="true" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    User has been deleted.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <?php include './includes/js_links.php'; ?>

    <script>
        $(document).ready(function() {
            // Get Visitor Information
            $(document).on("click", ".patient-id", function(e) {
                e.preventDefault();
                $('#visitorInfoModal').modal('show');
                let patient_ID = $(this).data("id");
                $.ajax({
                    url: 'ajax/patient_info.php',
                    method: 'post',
                    data: {
                        patient_ID_modal: patient_ID
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $("#visitorName").html(res.visitorName);
                        $("#visitorEmail").html(res.visitorEmail);
                        $("#visitorPhone").html(res.visitorPhone);
                    }
                });
            });

            // On-Click open modal to update status
            $(document).on('click', '.update-info', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $("#update_res_id").val(id);
                $('#updateReservationModal').modal('show');
            });

            // Update Reservation Status ~ Form
            $(document).on('submit', '#update-reservation-form', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: 'ajax/update_appointment.php',
                    method: 'post',
                    data: formData,
                    success: function(response) {
                        $('.msg-show').append(response);
                        setTimeout(() => {
                            window.location.reload();
                        }, 1800);
                    }
                });
            });

            // Delete Product
            $(document).on('click', '.del-prod', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $.ajax({
                    url: 'ajax/prod_req.php',
                    method: 'post',
                    data: {
                        del_prod: id
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $('.toast-body').html(res.msg);
                        $(".toast").toast('show');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                })
            });
        });
    </script>
</body>

</html>