<?php include_once 'config.php'; ?>

<?php

    set_time_limit(1000);

    $filecsv = fopen('utilisateurs.csv', 'r+');   //permet d'ouvrir le fichier
    $tabfile = file('utilisateurs.csv');
    $length = count($tabfile);
    $id = 1;
    $line = 1;

    $db=new PDO("mysql:host=".config::SERVERNAME
            .";dbname=".config::DBNAME
            , config::USER, config::PASSWORD);

    while ($line <$length-1 && !feof($filecsv))  {      //while ($line <100) 
        $tab = fgetcsv($filecsv, 1024, ";");

        if ($line!=0) {
            $tab[5]= hash('sha256',$tab[5]);
            $civility = $tab[0];
            $name = $tab[1];
            $firstname = $tab[2];
            $mail = $tab[3];
            $login = $tab[4];
            $password = $tab[5];
            $activity = $tab[6];
            
            echo $civility. " " .$name. " ". $firstname." ". $mail." ". $login." ". $password." ". $activity."<br />";

            $req = $db->prepare("INSERT INTO users(id,Civilite,Nom,Prenom,Email,Identifiant,Mdp,Activite)"
            . "VALUES (:id,:Civilite,:Nom,:Prenom,:Email,:Identifiant,:Mdp,:Activite)");

            $req->bindParam(':id', $id);
            $req->bindParam(':civilite', $civility);
            $req->bindParam(':nom', $name);
            $req->bindParam(':prenom', $firstname);
            $req->bindParam(':email', $mail);
            $req->bindParam(':identifiant', $login);
            $req->bindParam(':mdp', $password);
            $req->bindParam(':actif', $activity);

            $req->execute(array(
                'id' => $id,
                'Civilite' => $civility,
                'Nom' => $name,
                'Prenom' => $firstname,
                'Email' => $mail,
                'Identifiant' => $login,
                'Mdp' => $password,
                'Activite' => $activity,
            ));

            $id++;
        }  
        
    }

    $db = null;
    fclose($filecsv);
    
?>