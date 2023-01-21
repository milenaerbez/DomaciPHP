<?php

require "../dbBroker.php";
require "../model/user.php";
require "../model/proizvod.php";

if (isset($_POST['zaposleni_id'])) {

    $user = new User($_POST['zaposleni_id']);

    $status = $user->deleteById($conn);
    if ($status) {
        echo "Success";
    } else {
        echo "Failed";
    }
}

?>