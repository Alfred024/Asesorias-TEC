<?php
    class Database{
        var $connection;
        var $server;
        var $user;
        var $password;
        var $database;
        var $registrersBlock;
        var $registersNum; 

        function __construct(){
            $this-> password='123';  
            $this-> user='admin_asesorias';
            $this-> database='asesorias';
            $this-> server='127.0.0.1';
        }
        
        function open(){
            try {
                $this-> connection = mysqli_connect($this->server,$this->user,$this->password,$this->database);
            } catch (Exception $e) {
                echo('Error connectiong to database');
            }
        }

        function close(){
            mysqli_close($this->connection);
        }

        function query($query_param){
            $this->open();
            try {
                $this->registrersBlock=mysqli_query($this->connection,$query_param);
                if(strpos('select', strtolower($query_param)) === true){
                    $this->registersNum=mysqli_num_rows($this->registrersBlock); // Creo que está sentencia no funciona
                };
                $this->close();
            } catch (Exception $e) {
                echo('Error doing the query');
            }
        }

        function getRecord($query_param){
            $this->open();
            $this->registrersBlock=mysqli_query($this->connection,$query_param);
            $this->registersNum=mysqli_num_rows($this->registrersBlock);
            $this->close();
            return mysqli_fetch_object($this->registrersBlock);
        }

        function getFields(&$campos){
            //$info = "";
            $campos=array();
            //for($campoN=0; $campoN<mysqli_num_fields($this->registersNum); $campoN++){
            for($campoN=0; $campoN<2; $campoN++){
                $campo=mysqli_fetch_field_direct($this->registrersBlock ,$campoN);
                $tabla=$campo->table;
                array_push($campos,$campo->name);
                //$info.=$campo->name;
            }
            // echo('INFO');
            // echo($info);
            return $campos;
        }
    }

    $database = new Database();
?>
