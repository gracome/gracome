<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=formation_users;charset=UTF8", 'root', '');
   
    
   
        // echo "Connexion réussie";
    }
    catch(PDOException $e){
       echo "Erreur : " . $e->getMessage();
     }
?>