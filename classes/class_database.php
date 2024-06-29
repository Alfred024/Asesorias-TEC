<?php
    include '../envs.php';
    // echo getenv('DB_PASSWORD'); 
    // echo getenv('DB_USER');
    // echo getenv('DB_NAME');
    // echo getenv('DB_HOST');

    class Class_Database{
        var $connection;
        var $server;
        var $user;
        var $password;
        var $database;
        var $registrersBlock;
        var $registersNum; 
        var $registerId;

        function __construct(){
            $this-> password=getenv('DB_PASSWORD');  
            $this-> user=getenv('DB_USER');
            $this-> database=getenv('DB_NAME');
            $this-> server=getenv('DB_HOST');
            // $this-> password='CLYGT2$eh';  
            // $this-> user='proyAsesorias';
            // $this-> database='proyAsesorias';
            // $this-> server='200.23.53.226';
        }
        
        function open(){
            try {
                $this-> connection = mysqli_connect($this->server,$this->user,$this->password,$this->database);
            } catch (Exception $e) {
                echo $e;
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
                }
            } catch (Exception $e) {
                echo('Error doing the query: ');
                var_dump($e);
            }
            $this->close();
        }

        function getRecord($query_param){
            $this->open();
            $this->registrersBlock=mysqli_query($this->connection,$query_param);
            $this->registersNum=mysqli_num_rows($this->registrersBlock);
            $this->close();
            return mysqli_fetch_object($this->registrersBlock);
        }

        function getIdOfQuery($query_param) {
            $this->open();
            try {
                $this->registrersBlock=mysqli_query($this->connection,$query_param);
                $this->registerId = mysqli_insert_id($this->connection);
            } catch (Exception $e) {
                echo('Error doing the query: ');
                var_dump($e);
            }
            $this->close();
        }

        function getFields(&$campos){
            $num_campos = mysqli_num_fields($this->registrersBlock);
            for($campoN=0; $campoN<$num_campos; $campoN++){
                $campo=mysqli_fetch_field_direct($this->registrersBlock ,$campoN);
                $tabla=$campo->table;
                array_push($campos,$campo->name);
            }
        }
    }

    $database = new Class_Database();
?>
