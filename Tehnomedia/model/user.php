<?php

class User
{
    public $id;
    public $ime;
    public $prezime;
    public $datumRodjenja;
    public $username;
    public $password;

    public function __construct($id = null, $ime = null, $prezime = null, $datumRodjenja = null, $password = null, $username = null)
    {
        $this->id = $id;
        $this->ime = $ime;
        $this->prezime = $prezime;
        $this->datumRodjenja = $datumRodjenja;
        $this->username = $username;
        $this->password = $password;
    }

    public static function logInUser($usr, mysqli $conn)
    {
        $query = "SELECT * FROM zaposleni WHERE korisnicko_ime='$usr->username' and sifra='$usr->password'";
        //konekcija sa bazom
        return $conn->query($query);
    }

    public static function getAll(mysqli $conn)
    {
        $query = "SELECT * FROM zaposleni";
        return $conn->query($query);
    }

    public static function add(User $korisnik, mysqli $conn)
    {
        $query = "INSERT INTO zaposleni(zaposleni_id,ime,prezime,datum_rodjenja,sifra,korisnicko_ime) VALUES('$korisnik->id','$korisnik->ime','$korisnik->prezime','$korisnik->datumRodjenja','$korisnik->password','$korisnik->username')";
        return $conn->query($query);
    }

    public function deleteById(mysqli $conn)
    {
        $query = "DELETE FROM zaposleni WHERE zaposleni_id=$this->id";
        return $conn->query($query);
    }

    public static function getById($id, mysqli $conn)
    {
        $query = "SELECT * FROM zaposleni WHERE Radnik_ID=$id";

        $myObj = array();
        if ($mysqlObj = $conn->query($query)) {
            while ($red = $mysqlObj->fetch_array(1)) {
                $myObj[] = $red;
            }
        }
        return $myObj;
    }
    public static function getNameById($id, mysqli $conn)
    {
        $query = "SELECT ime FROM zaposleni WHERE zaposleni_id=$id";
        return $conn->query($query);
    }

    public static function update(User $korisnik, mysqli $conn)
    {
        $query = "UPDATE zaposleni SET `zaposleni_id` = '$korisnik->id', `ime` = '$korisnik->ime', `prezime` = '$korisnik->prezime', `datum_rodjenja` = '$korisnik->datumRodjenja', `sifra` = '$korisnik->password', `korisnicko_ime` = '$korisnik->username' WHERE `zaposleni`.`zaposleni_id` = '$korisnik->id'";
        return $conn->query($query);
    }
}

?>