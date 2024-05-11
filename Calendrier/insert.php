<?php
    header('content-type: text/html; charset=utf-8');
    $nom_bdd = "rdv_medicaux";
    $server = "localhost";
    $user = "root";
    $password = "";
    
    try {
        $connexion = new PDO("mysql:host=$server;dbname=$nom_bdd", $user, $password);
    } catch(PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        exit;
    }

    if(isset($_POST['id_med']) && isset($_POST['id_pat'])  && isset($_POST['date'])){
        $rqt = $connexion -> prepare("INSERT INTO rendez_vous (id_med,id_patient,heure_rdv) VALUES(:id1,:id2,:dt)");
        $rqt->bindParam(":id1",$_POST['id_med']);
        $rqt->bindParam(":id2",$_POST['id_pat']);
        $rqt->bindParam(":dt",$_POST['date']);
        $rqt->execute();
    }

?>