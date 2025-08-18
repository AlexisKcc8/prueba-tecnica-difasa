<?php
    class Database{
        //definicion de las variables de conexion
        private $host = 'localhost';
        private $user = 'root';
        private $password = '';
        private $database = 'route_management';

        //creacion del metodo de conexion
        public function getConnection(){
            $hostDB = "mysql:host=".$this->host.";dbname=".$this->database.";";

            try{
                $connection = new PDO($hostDB,$this->user,$this->password);
                $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $connection;
            } catch(PDOException $e){
                die("ERROR: ".$e->getMessage());
            }

        }
    }


?>