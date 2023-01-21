<?php

require "../dbBroker.php";
require "../model/proizvod.php";

if (isset($_POST['id'])) {
    $myArray = Proizvod::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}

?>