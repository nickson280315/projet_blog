<?php

    // Code pérmettant la connexion à notre base de données 'blog'.

    try{
        $connect = new PDO("mysql:host=localhost; dbname=blog; charset=utf8", "root", "", [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
    catch(\Exception $e){
        die("Erreur: " . $e->getMessage());
    }  

?>