<?php

require "dbBroker.php";
require "model/proizvod.php";
require "model/user.php";
require "model/report.php";

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location:index.php');
    exit();
}

$rezultat = Proizvod::getAll($conn); //$conn se nalazi u dbBrokeru
$rezultat_1 = User::getAll($conn);
$rezultat_2 = Report::getAll($conn);

if (!$rezultat) {
    echo "Nastala je greska prilikom izvodjenja upita";
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="css/home.css">
    <title>Dobrodosli</title>
</head>
<?php
if ($_SESSION['username'] != "admin") {
    if (!$rezultat_1) {
        echo "Nastala je greska prilikom izvodjenja upita <br>";
        die();
    } else {

        ?>

        <body onload="proveriDatum()">
            <?php
    }
} else {
    ?>

        <body>
            <?php
}
?>

        <div class="container_float"
            style="width: 100%; background-color: #0077B6; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px; margin-bottom: 20px;  padding: 3px;">

            <div class="row">
                <div class="col-md-1" style="color: white;">
                    <?php
                    if ($rezultat->num_rows == 0) {
                        echo "Nema proizvoda";
                    }
                    ?>
                </div>
                <div class="col-md-4" id="Div_Username" style="color: white; margin-right: auto; margin-left: auto;">
                    <p
                        style="text-align: center; margin-top: auto; margin-bottom: auto; font-size: 18px; margin-right: 10px;">
                        Korisnik: <?php echo $_SESSION['username'] ?></p>
                </div>
                <div class="col-md-1" id="Div_Logout" style="color: white;">
                    <a href="logout.php" id="logout">
                        Logout</a>
                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-md-3">
            </div>
            <div class="col-md-3">
                <button id="btn-dodaj-proizvod" type="button" class="btn btn-block" style="margin-bottom: 27px;"
                    data-toggle="modal" data-target="#myModal1">Ubaci proizvod</button>
            </div>
            <div class="col-md-3">
                <button id="btn-pretraga-proizvoda" class="btn btn-block" data-toggle="modal" data-target="#myModal2">
                    Pretrazi proizvod</button>
                <input type="text" id="txt-pretraga-proizvoda" placeholder="Pretrazi proizvode po nazivu">
            </div>
            <div class="col-md-3">
            </div>

        </div>


        <div id="pregled" class="panel panel-success" style="margin-top: 1%;">

            <div class="panel-body">
                <table id="myTable1" class="table table-hover table-striped"
                    style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px;">
                    <thead class="thead">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Naziv</th>
                            <th scope="col">Cena</th>
                            <th scope="col">
                                <a onclick="sortTableAsc1();" class="sort-link">Asc</a>
                                Datum Unosa
                                <a onclick="sortTableDsc1();" class="sort-link">Dsc</a>
                            </th>
                            <?php
                            if ($_SESSION['username'] == "admin") {
                                ?>
                                <th scope="col">Uneo[zaposleni_id]</th>
                            <?php
                            }
                            ?>
                            <th scope="col">Selektuj</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($red = $rezultat->fetch_array()):
                            ?>
                            <tr>
                                <td><?php echo $red["proizvod_id"] ?></td>
                                <td>
                                    <?php echo $red["naziv"] ?>
                                </td>
                                <td><?php echo $red["cena"] ?></td>
                                <td style="text-align: center;">
                                    <?php echo $red["datumUnosa"] ?>
                                </td>
                                <?php
                                if ($_SESSION['username'] == "admin") {
                                    ?>
                                    <td>
                                        <?php echo $red["zadnik_id"] ?>
                                    </td>
                                <?php
                                }
                                ?>
                                <td>
                                    <label class="custom-radio-btn">
                                        <input type="radio" name="radio-proizvodi" id="radio-proizvodi" value=<?php echo $red["proizvod_id"] ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                </td>

                            </tr>
                            <?php
                        endwhile;

                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="btnsProizvodi" class="panel-body" style="margin-bottom: 20px; display: none;">

            <div class="row">
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-2">
                    <button id="btn-izmeni-proizvod" class="btn btn-block" data-toggle="modal"
                        data-target="#izmeniModal">Izmeni</button>
                </div>
                <div class="col-md-2">
                    <button id="btn-obrisi-proizvod" class="btn btn-block">Obrisi</button>
                </div>

            </div>

        </div>


        <div class="modal fade" id="myModal1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container unos-form">
                            <form action="#" method="post" id="dodajProizvodForm">
                                <h3 style="color: black; text-align: center">Unesi proizvod</h3>
                                <div class="row">
                                    <div class="col-md-11 ">
                                        <div class="form-group">
                                            <label for="">Proizvod ID</label>
                                            <input type="number" style="border: 1px solid black" name="id"
                                                class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Naziv</label>
                                            <input type="text" style="border: 1px solid black" name="naziv"
                                                class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="cena">Cena</label>
                                            <input type="number" step=".01" style="border: 1px solid black" name="cena"
                                                class="form-control" required />
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Datum Unosa</label>
                                                <input type="date" style="border: 1px solid black" name="datum"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button id="btnDodaj" type="submit" class="btn btn-success btn-block"
                                                style="background-color: #023E8A; border-radius: 10px;">Dodaj</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="izmeniModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container izmena-form">
                            <form action="#" method="post" id="izmeniProizvodForm">
                                <h3 style="color: black; text-align: center">Izmeni proizvod</h3>
                                <div class="row">
                                    <div class="col-md-11 ">
                                        <div class="form-group">
                                            <label for="">Proizvod ID</label>
                                            <input type="number" style="border: 1px solid black" name="id" id="unos-ID"
                                                class="form-control" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Naziv</label>
                                            <input type="text" style="border: 1px solid black" name="naziv" id="naziv"
                                                class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="cena">Cena</label>
                                            <input type="number" step=".01" style="border: 1px solid black" id="cena"
                                                name="cena" class="form-control" required />
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Datum Unosa</label>
                                                <input type="date" style="border: 1px solid black" name="datum"
                                                    id="datum_unosa" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button id="btnIzmeniProizvod" type="submit"
                                                class="btn btn-success btn-block"
                                                style="background-color: #023E8A; border-radius: 10px;">Potvrdi</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php

        if ($_SESSION['username'] == "admin") {
            if (!$rezultat_1) {
                echo "Nastala je greska prilikom izvodjenja upita <br>";
                die();
            } else {

                ?>
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-3">
                        <button id="btn-dodaj-zaposlenog" type="button" class="btn  btn-block" style="margin-bottom: 27px;"
                            data-toggle="modal" data-target="#myModal3"> Ubaci zaposlenog</button>
                    </div>
                    <div class="col-md-3">
                        <button id="btn-pretraga-zaposlenog" class="btn  btn-block"> Pretrazi zaposlenog</button>
                        <input type="text" id="txt-pretraga-zaposlenog" placeholder="Pretrazi zaposlene po imenu">
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
                <div id="pregled" class="panel panel-success" style="margin-top: 1%;">

                    <div class="panel-body">
                        <table id="myTable2" class="table table-hover table-striped"
                            style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px;">
                            <thead class="thead">
                                <tr>
                                    <th scope="col">
                                        <a onclick="sortTableAsc2();" class="sort-link">Asc</a>
                                        Radnik ID
                                        <a onclick="sortTableDsc2();" class="sort-link">Dsc</a>
                                    </th>
                                    <th scope="col">Ime</th>
                                    <th scope="col">Prezime</th>
                                    <th scope="col">Datum Rodjenja</th>
                                    <th scope="col">Korisnicko Ime</th>
                                    <th scope="col">Sifra</th>
                                    <th scope="col">Selektuj</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($red_1 = $rezultat_1->fetch_array()):
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $red_1["zaposleni_id"] ?>
                                        </td>
                                        <td><?php echo $red_1["ime"] ?></td>
                                        <td>
                                            <?php echo $red_1["prezime"] ?>
                                        </td>
                                        <td><?php echo $red_1["datum_rodjenja"] ?></td>
                                        <td>
                                            <?php echo $red_1["korisnicko_ime"] ?>
                                        </td>
                                        <td><?php echo $red_1["sifra"] ?></td>
                                        <td>
                                            <label class="custom-radio-btn">
                                                <input type="radio" name="radio-zaposleni" id="radio-zaposleni" value=<?php echo $red_1["Radnik_ID"] ?>>
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>

                                    </tr>
                                    <?php
                                endwhile;
            }
            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            </div>

            </div>

            <div id="btnsZaposleni" class="panel-body" style="margin-bottom: 20px; display: none;">

                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-2">
                        <button id="btn-izmeni-zaposlenog" class="btn btn-block" data-toggle="modal"
                            data-target="#izmeniModal2">Izmeni</button>
                    </div>
                    <div class="col-md-2">
                        <button id="btn-obrisi-zaposlenog" class="btn btn-block">Obrisi</button>
                    </div>

                </div>

            </div>
            <div id="pregled" class="panel panel-success" style="margin-top: 100px;">

                <div class="panel-body">
                    <table id="myTable3" class="table table-hover table-striped"
                        style="background-color: rgba(255, 255, 255, 0.9); border-radius: 10px;">
                        <thead class="thead">
                            <tr>
                                <th scope="col">Izvestaj ID</th>
                                <th scope="col">
                                    <a onclick="sortTableAsc3();" class="sort-link">Asc</a>
                                    Datum izvestaja
                                    <a onclick="sortTableDsc3();" class="sort-link">Dsc</a>
                                </th>
                                <th scope="col">Uneo</th>
                                <th scope="col">Selektuj</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($red_1 = $rezultat_2->fetch_array()):
                                ?>
                                <tr>
                                    <td><?php echo $red_1["izvestaj_id"] ?></td>
                                    <td>
                                        <?php echo $red_1["datum_izvestaja"] ?>
                                    </td>
                                    <td><?php echo $red_1["uneo"] ?></td>
                                    <td>
                                        <label class="custom-radio-btn">
                                            <input type="radio" name="radio-izvestaj" id="radio-izvestaj" value=<?php echo $red_1["izvestaj_id"] ?>>
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>

                                </tr>
                                <?php
                            endwhile;
                            ?>
                        </tbody>
                    </table>

                    <div id="btnsIzvestaj" class="panel-body" style="margin-bottom: 20px; display: none;">

                        <div class="row">
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-2">
                                <button id="btnPrikaziIzvestaj" class="btn btn-block" data-toggle="modal"
                                    data-target="#prikaziIzvestaj">Prikazi</button>
                            </div>
                            <div class="col-md-2">
                                <button id="btnObrisiIzvestaj" class="btn btn-block">Obrisi</button>
                            </div>

                        </div>

                    </div>

                    <!-- <button id="btnPrikaziIzvestaj" class="btn btn-block" data-toggle="modal" data-target="#prikaziIzvestaj" style="background-color:#023E8A; color: white;">Prikazi</button> -->

                </div>
            </div>

            </div>

            </div>

        <?php
        }
        ?>

        <div class="modal fade" id="prikaziIzvestaj" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="color: black;">Izvestaj</h3>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <textarea name="ispisIzvestaja" id="ispisIzvestaja" cols="50" rows="10"
                            style="resize: none; margin-right: auto !important; margin-left: auto !important; outline: none; border-style: none;"
                            readonly></textarea>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="myModal3" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container unos-form">
                            <form action="#" method="post" id="dodajZaposlenogForm">
                                <h3 style="color: black; text-align: center">Unos Zaposlenog</h3>
                                <div class="row">
                                    <div class="col-md-11 ">
                                        <div class="form-group">
                                            <label for="">Radnik ID</label>
                                            <input type="number" style="border: 1px solid black" name="id"
                                                class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ime</label>
                                            <input type="text" style="border: 1px solid black" name="ime"
                                                class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Prezime</label>
                                            <input type="text" style="border: 1px solid black" name="prezime"
                                                class="form-control" required />
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Datum Rodjenja</label>
                                                <input type="date" style="border: 1px solid black" name="datum"
                                                    class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Sifra</label>
                                            <input type="text" style="border: 1px solid black" name="password"
                                                class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Korisnicko Ime</label>
                                            <input type="text" style="border: 1px solid black" name="username"
                                                class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <button id="btnDodaj" type="submit" class="btn btn-success btn-block"
                                                style="background-color: #023E8A; border-radius: 10px;">Dodaj</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="izmeniModal2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="container izmena-form">
                            <form action="#" method="post" id="izmeniZaposlenogForm">
                                <h3 style="color: black; text-align: center">Izmeni zaposlenog</h3>
                                <div class="row">
                                    <div class="col-md-11 ">
                                        <div class="form-group">
                                            <label for="">Radnik ID</label>
                                            <input type="number" style="border: 1px solid black" name="id"
                                                id="radnik_id" class="form-control" readonly />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Ime</label>
                                            <input type="text" style="border: 1px solid black" name="ime"
                                                id="radnik_ime" class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="cena">Prezime</label>
                                            <input type="text" style="border: 1px solid black" name="prezime"
                                                id="radnik_prezime" class="form-control" required />
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="">Datum Rodjenja</label>
                                                <input type="date" style="border: 1px solid black" name="datum"
                                                    id="radnik_datum_rodjenja" class="form-control" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Sifra</label>
                                            <input type="text" style="border: 1px solid black" name="password"
                                                id="radnik_sifra" class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="">Koriscnicko ime</label>
                                            <input type="text" style="border: 1px solid black" name="username"
                                                id="radnik_korisnicko_ime" class="form-control" required />
                                        </div>
                                        <div class="form-group">
                                            <button id="btnIzmeniZaposlenog" type="submit" class="btn btn-block"
                                                style="background-color: #023E8A; color: white; border-radius: 10px;">Izmeni</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php

        if ($_SESSION['username'] != "admin") {
            if (!$rezultat_1) {
                echo "Nastala je greska prilikom izvodjenja upita <br>";
                die();
            } else {

                ?>
                <form action="#" method="post" id="dodajIzvestaj" style="text-align: center;">
                    <div id="dnevniIzvestaj" class="form-group" style="margin-right: auto; margin-left: auto;">
                        <label for=""
                            style="background-color: #023E8A; color: white !important; border-radius: 5px; padding: 5px;">
                            Unesite dnevni izvestaj: </label>

                        <textarea name="txt-izvestaj" id="txt-izvestaj" rows="15" class="form-control"
                            style="margin-right: auto; margin-left: auto; border-radius: 15px; width: 30%; resize: none;"></textarea>
                        <div class="form-group">
                            <button id="btnPosaljiIzvestaj" type="submit" class="btn btn-block"
                                style="background-color: #023E8A; border-radius: 10px; color: white; width: 30%; text-align: center; margin-right: auto; margin-left: auto; margin-top: 10px;">
                                Posalji
                            </button>

                        </div>
                    </div>
                </form>

                <?php
            }
        }
        ?>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
    </body>

</html>