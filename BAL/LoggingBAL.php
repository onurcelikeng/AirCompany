<?php

require_once("Core/DBConnect.php");
require_once("Models/LoggingBO.php");

class LoggingBAL
{
    private $dbConnect;
    

    public function __construct()
    {
        $this->dbConnect = new DBConnect();
    }


    public function GetLogs(){
        $response = $this->dbConnect->get("SELECT Id, Entity, Operation, CreateDate FROM LoggingTable");
        $logs = array();

        while($data = $response->fetch_assoc()) {
            $model = new LoggingBO($data["Id"], $data["Entity"], $data["Operation"], $data["CreateDate"]);
            array_push($logs, $model);
        }

        return $logs;
    }

    public function AddLog($model){
        $entity = $model->getEntity();
        $operation = $model->getOperation();
        $createdate = $model->getCreateDate();

        $response = $this->dbConnect->execute("INSERT INTO LoggingTable (Entity, Operation, CreateDate) VALUES ('$entity', '$operation', '$createdate')");
        return $response;
    }
}

?>