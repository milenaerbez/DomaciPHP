<?php

class Proizvod
{
    public $proizvod_id;
    public $naziv;
    public $cena;
    public $datumUnosa;
    public $zaposleni_id;


    public function __construct($proizvod_id = null, $naziv = null, $cena = null, $datumUnosa = null, $zaposleni_id = null)
    {
        $this->proizvod_id = $proizvod_id;
        $this->naziv = $naziv;
        $this->cena = $cena;
        $this->zaposleni_id = $zaposleni_id;
        $this->datumUnosa = $datumUnosa;


    }
    public static function getAll(mysqli $conn)
    {
        $query = "SELECT * FROM proizvod";
        return $conn->query($query);
    }


    public static function add(Proizvod $proizvod, mysqli $conn)
    {
        $query = "INSERT INTO proizvod(proizvod_id, naziv, cena, datumUnosa, zaposleni_id) 
        VALUES('$proizvod->proizvod_id','$proizvod->naziv',
        '$proizvod->cena','$proizvod->datumUnosa','$proizvod->zaposleni_id')";
        return $conn->query($query);
    }

    public function deleteById(mysqli $conn)
    {
        $query = "DELETE FROM proizvod WHERE proizvod_id=$this->proizvod_id";
        return $conn->query($query);
    }

    public static function getByName($name, mysqli $conn)
    {
        $query = "SELECT * FROM proizvod WHERE naziv=$name";

        $myObj = array();
        if ($mysqlObj = $conn->query($query)) {
            while ($red = $mysqlObj->fetch_array(1)) {
                $myObj[] = $red;
            }
        }
        return $myObj;
    }

    public static function getById($id, mysqli $conn)
    {
        $query = "SELECT * FROM proizvod WHERE proizvod_id=$id";

        $myObj = array();
        if ($mysqlObj = $conn->query($query)) {
            while ($red = $mysqlObj->fetch_array(1)) {
                $myObj[] = $red;
            }
        }
        return $myObj;
    }

    public static function update(Proizvod $proizvod, mysqli $conn)
    {
        $query = "UPDATE proizvod SET `proizvod_id` = '$proizvod->proizvod_id', `naziv` = '$proizvod->naziv', `cena` = '$proizvod->cena', `datumUnosa` = '$proizvod->datumUnosa', 
        `zaposleni_id` = '$proizvod->zaposleni_id' 
        WHERE `proizvodi`.`proizvod_id` = '$proizvod->proizvod_id'";
        return $conn->query($query);
    }
}

?>