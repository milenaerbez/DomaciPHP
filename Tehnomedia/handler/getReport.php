<?php

require "../dbBroker.php";
require "../model/report.php";

if (isset($_POST['id'])) {
    $myArray = Report::getById($_POST['id'], $conn);
    echo json_encode($myArray);
}

?>