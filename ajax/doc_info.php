<?php
require_once '../core/database.php';
if (isset($_POST['docID'])) :
    $docID = $_POST['docID'];

    $cafe_Q = $db->query("CALL `get_doctor_info`($docID)");

    $doc_data = mysqli_fetch_object($cafe_Q); ?>

    <div class="grid-box">
        <div class="item">
            <div class="text"><span class="d-block fw-bold">Doctor Name</span><?= $doc_data->name ?></div>
            <div class="text"><span class="d-block fw-bold">Doctor Phone</span><?= $doc_data->phone ?></div>
            <div class="text">
                <a class="btn btn-primary btn-sm" href="./cafe_review.php?cafe_id=<?= $docID ?>&cafe_name=<?= $doc_data->clinic_name ?>" target="_blank">Reviews</a>
            </div>
        </div>
        <div class="item">
            <div class="text"><span class="d-block fw-bold">Certificate</span><?= $doc_data->certificate ?></div>
            <div class="text"><span class="d-block fw-bold">Experience</span><?= $doc_data->experience ?></div>
        </div>
        <div class="item">
            <div class="text"><span class="d-block fw-bold">Doctor Timing</span>
                <?= date('h:i A', strtotime($doc_data->checkin_time)) ?> -
                <?= date('h:i A', strtotime($doc_data->checkout_time)) ?>
            </div>
            <div class="text"><span class="d-block fw-bold">Weekend (Fri & Sat)</span>
                <?= ($doc_data->weekend_available == 'yes') ? 'Available' : 'Holiday' ?>
            </div>
            <input type="hidden" id="store_open_time" value="<?= $doc_data->checkin_time ?>">
            <input type="hidden" id="store_close_time" value="<?= $doc_data->checkout_time ?>">
            <input type="hidden" name="clinic_id" id="clinic_id" value="<?= $doc_data->c_id ?>">
        </div>
        <?php if ($doc_data->c_status != 0): ?>
            <div class="item">
                <div class="text"><span class="d-block fw-bold">Clinic Name</span><?= $doc_data->clinic_name ?></div>
                <div class="text"><span class="d-block fw-bold">Clinic Location</span><?= $doc_data->clinic_location ?></div>
                <div class="text d-none">
                    <a class="btn btn-primary btn-sm" href="./doctor_info.php?doc_id=<?= $docID ?>&doc_name=<?= $doc_data->clinic_name ?>" target="_blank">Clinic</a>
                </div>
            </div>
        <?php endif; ?>
    </div>

<?php
    $cafe_Q->close();
    $db->next_result();
endif;


if (isset($_POST['doctorID_modal'])) :
    $docID = $_POST['doctorID_modal'];

    $cafe_Q = $db->query("CALL `get_doc_info`($docID)");
    $response = array();
    $doc_data = mysqli_fetch_object($cafe_Q);
    $store_open = date('h:i A', strtotime($doc_data->checkin_time));
    $store_close = date('h:i A', strtotime($doc_data->checkout_time));
    $response = ["cafeName" => $doc_data->clinic_name, "ownerName" => $doc_data->name, "ownerPhone" => $doc_data->phone, "shopLocation" => $doc_data->clinic_location, "shopOpen" => $store_open, "shopClose" => $store_close];
    echo json_encode($response);
    $cafe_Q->close();
    $db->next_result();
endif;
?>