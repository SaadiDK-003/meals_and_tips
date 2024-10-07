<?php
require_once '../core/database.php';

if (isset($_POST['city']) && !isset($_POST['clinic_id']) && !isset($_POST['specialist'])):
    $city = $_POST['city'];
    $clinic_Q = $db->query("SELECT * FROM `clinic` WHERE `status`='1' AND `city`='$city'");
?>
    <?php
    while ($clinic_list = mysqli_fetch_object($clinic_Q)): ?>
        <option value="<?= $clinic_list->id ?>"><?= $clinic_list->clinic_name ?></option>
    <?php endwhile;
endif;


if (isset($_POST['clinic_id'])):
    $c_id = $_POST['clinic_id'];
    $C_List = $db->query("Call `get_doc_by_clinic_id`($c_id)");
    while ($list = mysqli_fetch_object($C_List)):
    ?>
        <div class="col-12 col-md-4 mb-3">
            <div class="box">
                <h5><?= $list->clinic_name ?></h5>
                <h6><?= $list->clinic_location ?></h6>
                <div class="doctor_info">
                    <div class="avatar">
                        <img src="img/doc.jpg" alt="">
                    </div>
                    <h5><?= $list->name ?></h5>
                    <div class="about_doctor d-flex flex-column">
                        <span><strong>Certificate:</strong> <?= $list->certificate ?></span>
                        <span><strong>Experience:</strong> <?= $list->experience ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endwhile;
    $C_List->close();
    $db->next_result();
endif;


if (isset($_POST['specialist']) && isset($_POST['city']) && !isset($_POST['clinic_id'])):
    $spe = $_POST['specialist'];
    $city = $_POST['city'];
    $C_List = $db->query("Call `get_doc_by_spe_city`('$spe','$city')");
    while ($list = mysqli_fetch_object($C_List)):
    ?>

        <div class="col-12 col-md-4 mb-3">
            <div class="box">
                <h5 class="d-none"><?= $list->clinic_name ?></h5>
                <h6 class="d-none"><?= $list->clinic_location ?></h6>
                <div class="doctor_info">
                    <div class="avatar mt-2 mb-4">
                        <img src="<?= $list->profile_pic ?? 'img/doc.jpg' ?>" alt="">
                    </div>
                    <h5><?= $list->name ?></h5>
                    <div class="about_doctor d-flex flex-column">
                        <span><strong>Certificate:</strong> <?= $list->certificate ?></span>
                        <span><strong>Experience:</strong> <?= $list->experience ?></span>
                    </div>
                </div>
            </div>
        </div>


<?php
    endwhile;
endif;
?>