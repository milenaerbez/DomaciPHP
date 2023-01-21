<?php

require "dbBroker.php";
require "model/user.php";


session_start();
if (isset($_POST['username']) && isset($_POST['password'])) {
    $uname = $_POST['username'];
    $upass = $_POST['password'];

    $korisnik = new User(1, null, null, null, $upass, $uname);
    $odg = User::logInUser($korisnik, $conn);

    $rezultat = User::getAll($conn);

    while ($red = $rezultat->fetch_array()):

        if ($red["korisnicko_ime"] == $uname) {
            $_SESSION['user_id'] = $red["zaposleni_id"];
        }

    endwhile;
    if ($odg->num_rows == 1) {
        echo `
        <script>
        console.log( "Uspesno ste se prijavli" );
        </script>`;
        $_SESSION['username'] = $korisnik->username;
        header('Location:home.php');
        exit();
    } else {
        echo '<script>
            console.log("Neuspesna Prijava");
            </script>';
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
    <title>Login Stranica</title>
</head>

<body>

    <div style="max-width: 1200px; margin: 0 auto; padding: 10px; height: 100vh;">

        <div class="container">

            <div class="row" style="margin-top: 40vh;margin-right: 50vh;">

                <div class="col-md-6" id="logInDiv">
                    <h3 style="margin-bottom: 30px; margin-top: 15px;">Login</h3>
                    <form action="#" method="POST">
                        <div class="container">
                            <label class="username">Korisnicko ime: </label>
                            <input type="text" name="username" class="form-control" required>
                            <br>
                            <label for="password">Lozinka</label>
                            <input type="password" name="password" class="form-control" required>
                            <button type="submit" class="btnSubmit btn-primary" name="submit">Login
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>

</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</html>