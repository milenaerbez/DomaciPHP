<?php

class Report
{
    public $izvestaj_id;
    public $datum_izvestaja;
    public $izvestaj;
    public $uneo;

    public function __construct($izvestaj_id = null, $datum_izvestaja = null, $izvestaj = null, $uneo = null)
    {
        $this->izvestaj_id = $izvestaj_id;
        $this->datum_izvestaja = $datum_izvestaja;
        $this->izvestaj = $izvestaj;
        $this->uneo = $uneo;
    }


    public static function getAll(mysqli $conn)
    {
        $query = "SELECT * FROM izvestaj";
        return $conn->query($query);
    }

    public static function add(Report $report, mysqli $conn)
    {
        $query = "INSERT INTO izvestaj(izvestaj_id,datum_izvestaja,izvestaj,uneo) 
        VALUES('NULL','$report->datum_izvestaja','$report->izvestaj','$report->uneo')";
        return $conn->query($query);
    }

    public function deleteById(mysqli $conn)
    {
        $query = "DELETE FROM izvestaj WHERE izvestaj_id=$this->izvestaj_id";
        return $conn->query($query);
    }

    public static function getById($id, mysqli $conn)
    {
        $query = "SELECT * FROM izvestaj WHERE izvestaj_id=$id";

        $myObj = array();
        if ($mysqlObj = $conn->query($query)) {
            while ($red = $mysqlObj->fetch_array(1)) {
                $myObj[] = $red;
            }
        }
        return $myObj;
    }
}

?>