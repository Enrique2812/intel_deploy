<?php

function conectarDB() : PDO{
    $db=new PDO("sqlsrv:Server=".$_ENV['BD_HOST'].";Database=".$_ENV['BD_DATABASE'], $_ENV['BD_USER'], $_ENV['BD_PASSWORD']);
    
    if(!$db){
        echo "Error no se pudo conectar";
    }
    return $db;
}

conectarDB();