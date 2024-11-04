<?php
require_once '../core/database.php';

if (isset($_POST['del_id'])):
    $del_id = $_POST['del_id'];
    echo delete('recipes', $del_id);
endif;
