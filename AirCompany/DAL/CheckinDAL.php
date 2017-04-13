<?php

require_once("../BO/CheckinBO.php");
require_once("Core/DBConnect.php");

class CheckinDAL
{
    private $dbConnect;


    public function CheckinDAL()
    {
        $this->dbConnect = new DBConnect();
    }


    public function GetCheckins(){
        $response = $this->dbConnect->get("SELECT CheckId, FlightId, PNR, Seat, IsChecked FROM CheckinTable");
        $checkins = array();

        while($data = $response->fetch_assoc()){
            $model = new CheckinBO($data["CheckId"], $data["FlightId"], $data["PNR"], $data["Seat"], $data["IsChecked"]);
            array_push($checkins, $model);
        }
        
        return $checkins;
    }

    public function GetCheckinsCount(){
        $response = $this->dbConnect->get("SELECT COUNT(CheckId) AS size FROM CheckinTable");
        $data = $response->fetch_assoc();
        return $data["size"];
    }

    public function AddCheckin(){
        $response = $this->dbConnect->execute("INSERT INTO CheckinTable (FlightId, PNR, Seat, IsChecked) VALUES (6, 'L2PBSQ', '17F', 1)");
        return $response;
    }

    public function UpdateCheckin(){
        $response = $this->dbConnect->execute("UPDATE CheckinTable SET Seat='21A'");
        return $response;
    }

    public function DeleteCheckin($CheckId){
        $response = $this->dbConnect->execute("DELETE FROM CheckinTable WHERE CheckId=$CheckId");
        return $response;
    }
}

?>