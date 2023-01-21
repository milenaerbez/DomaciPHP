<?php

require "../dbBroker.php";
require "../model/user.php";

session_start();

if (
    isset($_POST['id']) && isset($_POST['ime']) &&
    isset($_POST['prezime']) && isset($_POST['datum']) && isset($_POST['password']) && isset($_POST['username'])
) {

    $korisnik = new User($_POST['id'], $_POST['ime'], $_POST['prezime'], $_POST['datum'], $_POST['password'], $_POST['username']);

    $rezultat = User::getAll($conn);

    while ($red = $rezultat->fetch_array()):

        if ($red["zaposleni_id"] != $_POST['id']) {
            if (strtoupper($red["korisnicko_ime"]) == strtoupper($_POST['username'])) {
                echo 'Korisnicko ime zauzeto!';
                return;
            }
        }
    endwhile;

    $status = User::update($korisnik, $conn);

    if ($status) {
        echo 'Success';
    } else {
        echo $status;
        echo 'Failed';
    }
}

?>