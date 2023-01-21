<?php

require "../dbBroker.php";
require "../model/proizvod.php";

if (isset($_POST['proizvod_id'])) {
    $proizvod = new Proizvod($_POST['proizvod_id']);
    $status = $proizvod->deleteById($conn);
    if ($status) {
        echo "Success";
    } else {
        echo "Failed";
    }
}

?>