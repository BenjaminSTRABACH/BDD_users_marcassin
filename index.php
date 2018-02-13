<?php include_once "bootstrap.php" ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php include_once 'config.php'; ?>
    </head>
    <body>
        <?php
            $filecsv = fopen('utilisateurs.csv', 'r+');   //permet d'ouvrir le fichier
            $line=0;
            $tabfile = file('utilisateurs.csv');
            $length = count($tabfile);
            while ($line <100) {      //while ($line <$length-1) 
                $tab = fgetcsv($filecsv, 1024, ";");
                if ($line!=0) {
                    $civility = $tab[0];
                    $name = $tab[1];
                    $firstname = $tab[2];
                    $mail = $tab[3];
                    $login = $tab[4];
                    $password = hash('sha256',$tab[5]);
                    $active = $tab[6];
                    
//                    echo $civility. " " .$name. " ". $firstname." ". $mail." ". $login." ". $password." ". $active."<br />";
                    $db = new PDO("mysql:host=" . config::SERVERNAME . ";dbname=". config::DBNAME, config::USER, config::PASSWORD);
//                    $req=$db->prepare("INSERT INTO `users`(`civilite`, `nom`, `prenom`, `email`, `identifiant`, `mdp`, `actif`)".
//                    "VALUES (:civilite,:nom,:prenom,:email,:identidiant,:mdp,:actif)");
//                    $req->bindParam(":civilite", $civility);
//                    $req->bindParam(":nom", $name);
//                    $req->bindParam(":prenom", $firstname);
//                    $req->bindParam(":email", $mail);
//                    $req->bindParam(":identifiant", $login);
//                    $req->bindParam(":mdp", $password);
//                    $req->bindParam(":actif", $active);
//                    $req=$db->prepare("INSERT INTO `users`(civilite, nom, prenom, email, identifiant, mdp, actif) VALUES ($civility,$name,$firstname,$mail,$login,$password,$active)");
//                    INSERT INTO `users` (`id`, `civilite`, `nom`, `prenom`, `email`, `identifiant`, `mdp`, `actif`) VALUES (NULL, 'MR', 'Partick', 'JeanMichel', 'frf@lepd', 'michou', '123456789', '1');
                    $req=$db->prepare("SELECT * FROM `users`");
                   
                    
                    $req->execute();
                    
                    $db = null;
                    $result=$req->fetchAll();
                  
                }
                $line++;
                
            }
        ?>
        <?php var_dump($result); 
          echo $result[0]['identifiant'];
        ?>
        
    </body>
</html>
<!--/*
$req=$db->prepare("INSERT INTO `users`(`civilite`, `nom`, `prenom`, `email`, `identifiant`, `mdp`, `actif`)".
                    "VALUES (:civilite,:nom,:prenom,:email,:identidiant,:mdp,:actif)");
                    */-->