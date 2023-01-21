<?php

require "../dbBroker.php";
require "../model/proizvod.php";

session_start();

if (
    isset($_POST['id']) && isset($_POST['naziv']) &&
    isset($_POST['cena']) && isset($_POST['datum'])
) {

    $proizvod = new Proizvod($_POST['id'], $_POST['naziv'], $_POST['cena'], $_POST['datum'], $_SESSION['user_id']);

    $rezultat = Proizvod::getAll($conn);

    while ($red = $rezultat->fetch_array()):

        if ($red["proizvod_id"] != $_POST['id']) {
            if (strtoupper($red["naziv"]) == strtoupper($_POST['naziv'])) {
                echo 'Proizvod sa unetim nazivom vec postoji!';
                return;
            }
        }
    endwhile;

    $status = Proizvod::update($proizvod, $conn);

    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}

?>