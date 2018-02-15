<?php include_once 'config.php'; ?>

<?php

    set_time_limit(1000);

    $filecsv = fopen('utilisateurs.csv', 'r+');   //permet d'ouvrir le fichier
    $tabfile = file('utilisateurs.csv');
    $length = count($tabfile)-1;
    $id = 0;
    $line = 1;

    $db=new PDO("mysql:host=".config::SERVERNAME
            .";dbname=".config::DBNAME
            , config::USER, config::PASSWORD);

    while ($line < $length+1 && !feof($filecsv)){
        $tab = fgetcsv($filecsv, 1024, ";");
        $double=0;
        if ($line!=0) {           
            $civility = $tab[0];
            $name = $tab[1];
            $firstname = $tab[2];
            $mail = $tab[3];
            $login = $tab[4];
            $password = hash('sha256',$tab[5]);
            $activity = $tab[6];
            
            // BOUCLE VERIFICATION DOUBLONS
//            $maxid=$db->query('SELECT MAX(id) FROM users');
//            echo $maxid . "<br />";
//            for($i=1; $i<10;$i++){
//                
//            }
            $checkdouble = $db->prepare('SELECT * FROM users WHERE Identifiant = :login');    //
            $checkdouble->bindParam(':login', $login);
            $checkdouble->execute();
            $double = $checkdouble->fetchall();
            var_dump($double);
            
            if ($double==NULL) {
                // echo $civility. " " .$name. " ". $firstname." ". $mail." ". $login." ". $password." ". $activity."<br />";

                $req = $db->prepare("INSERT INTO users(id,Civilite,Nom,Prenom,Email,Identifiant,Mdp,Activite)"
                . "VALUES (:id,:Civilite,:Nom,:Prenom,:Email,:Identifiant,:Mdp,:Activite)");

                $req->bindParam(':id', $id);
                $req->bindParam(':Civilite', $civility);
                $req->bindParam(':Nom', $name);
                $req->bindParam(':Prenom', $firstname);
                $req->bindParam(':Email', $mail);
                $req->bindParam(':Identifiant', $login);
                $req->bindParam(':Mdp', $password);
                $req->bindParam(':Activite', $activity);

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
        $line++;
    }
    $db = null;
    fclose($filecsv);  
?>