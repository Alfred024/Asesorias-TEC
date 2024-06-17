<?php
    include '../envs.php';

    class Class_Database{
        var $connection;
        var $server;
        var $user;
        var $password;
        var $database;
        var $registrersBlock;
        var $registersNum;

        function __construct(){
            $this->password = getenv('DB_PASSWORD');  
            $this->user = getenv('DB_USER');
            $this->database = getenv('DB_NAME');
            $this->server = getenv('DB_HOST');
        }
        
        function open(){
            $conn_string = "host=$this->server dbname=$this->database user=$this->user password=$this->password";
            try {
                $this->connection = pg_connect($conn_string);
                if(!$this->connection) {
                    throw new Exception('Error connecting to database');
                }
            } catch (Exception $e) {
                echo 'Error connecting to database: ', $e->getMessage();
            }
        }

        function close(){
            pg_close($this->connection);
        }

        function query($query_param){
            $this->open();
            try {
                $this->registrersBlock = pg_query($this->connection, $query_param);
                if (pg_last_error($this->connection)) {
                    throw new Exception(pg_last_error($this->connection));
                }
                if(stripos($query_param, 'select') === 0){
                    $this->registersNum = pg_num_rows($this->registrersBlock);
                }
            } catch (Exception $e) {
                echo 'Error doing the query: ', $e->getMessage();
            }
            $this->close();
        }

        function getRecord($query_param){
            $this->open();
            $this->registrersBlock = pg_query($this->connection, $query_param);
            $this->registersNum = pg_num_rows($this->registrersBlock);
            $this->close();
            return pg_fetch_object($this->registrersBlock);
        }

        function getFields(&$campos){
            $num_campos = pg_num_fields($this->registrersBlock);
            for($campoN = 0; $campoN < $num_campos; $campoN++){
                $campo = pg_field_name($this->registrersBlock, $campoN);
                array_push($campos, $campo);
            }
        }
    }

    $database = new Class_Database();
?>
