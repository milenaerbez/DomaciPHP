<?php

require "../dbBroker.php";
require "../model/user.php";

if (isset($_POST['id'])) {
    $myArray = User::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}

?>