<?php

    $host="mysql:host=localhost;dbname=treinando_pdo;charset=utf8mb4;port=3306";
    $user="root";
    $pass="";

    try{
        $db = new PDO ($host, $user, $pass);
    } catch(PDOException $e){
        print "Erro: ".$e->getMessage()."</br>";
        die();
    }

?>