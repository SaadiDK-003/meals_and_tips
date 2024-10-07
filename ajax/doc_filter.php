<?php
require_once '../core/database.php';

if (isset($_POST['specialist']) && empty($_POST['rating'])):

    $specialist = $_POST['specialist'];

    $spe_q = $db->query("CALL `doctor_by_specialist`('$specialist')");
    while ($spe_list = mysqli_fetch_object($spe_q)):
?>

        <div class="doctor-card">
            <img src="./img/doc.jpg" alt="Doctor Photo">
            <h3><?= $spe_list->name ?></h3>
            <p><?= $spe_list->certificate ?> | <?= $spe_list->city ?></p>

            <a class="btn btn-primary" target="_blank" href="callus.php?doc_id=<?= $spe_list->u_id ?>">View Profile</a>
        </div>

    <?php endwhile;
    $spe_q->close();
    $db->next_result();
endif;


// With Both Filters
if (isset($_POST['specialist']) && $_POST['rating'] != ''):

    $specialist = $_POST['specialist'];
    $rating = $_POST['rating'];

    $spe_q_ = $db->query("CALL `doctor_by_specialist_and_rating`('$specialist',$rating)");
    while ($spe_list_ = mysqli_fetch_object($spe_q_)):
    ?>

        <div class="doctor-card">
            <img src="./img/doc.jpg" alt="Doctor Photo">
            <h3><?= $spe_list_->name ?></h3>
            <p><?= $spe_list_->certificate ?> | <?= $spe_list_->city ?></p>
            <p><?= $spe_list_->comments ?></p>
            <div class="ratings mb-2 <?= 'rate-' . $spe_list_->rating ?>">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>

            <a class="btn btn-primary" target="_blank" href="callus.php?doc_id=<?= $spe_list_->u_id ?>">View Profile</a>
        </div>

<?php
    endwhile;
    $spe_q_->close();
    $db->next_result();
endif;
?>