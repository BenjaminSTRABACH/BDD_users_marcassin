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
            $db = new PDO("mysql:host=" . config::SERVERNAME . ";dbname="
                                 . config::DBNAME, config::USER, config::PASSWORD);
            $req=$db->prepare("INSERT INTO `users`(`civilite`, `nom`, `prenom`, `email`, `identifiant`, `mdp`, `actif`)".
                    "VALUES (:civilite,:nom,:prenom,:email,:identidiant,:mdp,:actif)");
            $filecsv = fopen('utilisateurs.csv', 'r+');   //permet d'ouvrir le fichier
            $line=0;
            $tabfile = file('utilisateurs.csv');
            $length = count($tabfile);
            while ($line <$length-1) {      //!feof($filecsv)
                $tab = fgetcsv($filecsv, 1024, ";");
                if ($line!=0) {
                    $civility = $tab[0];
                    $name = $tab[1];
                    $firstname = $tab[2];
                    $mail = $tab[3];
                    $login = $tab[4];
                    $password = hash('sha256',$tab[5]);
                    $active = $tab[6];
                    
                    echo $civility. " " .$name. " ". $firstname." ". $mail." ". $login." ". $password." ". $active."<br />";
                    $req->bindParam(":civilite", $civility);
                    $req->bindParam(":nom", $name);
                    $req->bindParam(":prenom", $firstname);
                    $req->bindParam(":email", $mail);
                    $req->bindParam(":identifiant", $login);
                    $req->bindParam(":mdp", $password);
                    $req->bindParam(":actif", $active);
                }
                $line++;
            }
        ?>
    </body>
</html>
