<?php

class DbConnect{
    
    private static $pdo;
    public static function Connect(){
        if(self::$pdo == null){
            try{
                self::$pdo = new PDO('mysql:host='.HOST.';dbname='.DATABASE,USER,PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return self::$pdo;
            }catch(Exception $e){
                echo '<div>Erro ao conectar com banco de dados</div>';
            }
        }else{
            return self::$pdo;
        }
    }

}

?>