<?php

require "../dbBroker.php";
require "../model/report.php";

session_start();

if (isset($_POST['datum'])) {

    $rezultat = Report::getAll($conn);
    $unet = 1;


    while ($red = $rezultat->fetch_array()):

        if ($red["uneo"] == $_SESSION["username"]) {
            if ($red["datum_izvestaja"] == $_POST['datum']) {
                echo "UNET";
                $unet = 2;
                return;
            }

        }


    endwhile;

    if ($unet == 1) {
        echo 'NIJE';
    }
}
?>