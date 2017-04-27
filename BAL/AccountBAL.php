<?php

require_once("DAL/DBConnect.php");
require_once("BO/AccountBO.php");
require_once("/Models/LoginModel.php");
require_once("/Models/RegisterModel.php");
require_once("Helpers/PasswordHelper.php");

class AccountBAL
{
    private $dbConnect;
    

    public function __construct()
    {
        $this->dbConnect = new DBConnect();
    }


    public function Register($model){
        $namesurname = $model->getNameSurname();
        $email = $model->getEmail();
        $password = $model->getPassword();

        $ph = new PasswordHelper();
        $passwordHash = $ph->Decrypt($password);
        
        $response = $this->dbConnect->execute("INSERT INTO UserTable (NameSurname, Email, Password) VALUES ('$namesurname', '$email', '$passwordHash')");
        return $response;
    }

    public function Login($model){
        $email = $model->getEmail();
        $password = $model->getPassword();
 
        $response = $this->dbConnect->get("SELECT Id, NameSurname, Email FROM AirportTable WHERE Email=$email && Password=$password");
        $data = $response->fetch_assoc();
        $model = new AccountBO($data["Id"], $data["NameSurname"], $data["Email"]);

        return $model;
    }
}

?>