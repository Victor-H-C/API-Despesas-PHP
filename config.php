<?php

    header('Access-Control-Origin: *');
    header('Access-Control-Allow-Origin: *');
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('America/Sao_Paulo'); 

    $autoload = function($class){
        include('class/'.$class.'.php');
    };

    spl_autoload_register($autoload);

    define('PATH', 'http://localhost/api_rest');
    define('HOST', 'localhost');
    define('USER', 'root');
    define('PASSWORD', '');
    define('DATABASE', 'api_rest');

?>