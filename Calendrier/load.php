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



function jour_de_semaine($date) {

    switch ($date) {
        case 0:
            return 'Dimanche';
        case 1:
            return 'Lundi';
        case 2:
            return 'Mardi';
        case 3:
            return 'Mercredi';
        case 4:
            return 'Jeudi';
        case 5:
            return 'Vendredi';
        case 6:
            return 'Samedi';
    }
}


function dayToInt($day){
    if($day == "Samedi"){
        return 1;
    }   
    else if($day == "Dimanche"){
        return 2;
    }   
    else if($day == "Lundi"){
        return 3;
    }   
    else if($day == "Mardi"){
        return 4;
    }   
    else if($day == "Mercredi"){
        return 5;
    }
    else if($day == "Jeudi"){
        return 6;
    } 
    else if($day == "Vendredi"){
        return 7;
    }  
    
}


if(isset($_POST['id_med']) && isset($_POST['date'])){
    $req = $connexion->prepare("SELECT * FROM calendrier WHERE id_med = :id");
    $req->bindParam(":id",$_POST['id_med']);
    $req->execute();
    if($req->rowCount()>0){  
        $result = $req->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $timestamp_debut = strtotime($result['heure_d']);
            $timestamp_fin = strtotime($result['heure_f']);
            while ($timestamp_debut <= $timestamp_fin) {
                $heure_actuelle = date('H:i', $timestamp_debut);
                $timestamp = strtotime($_POST['date']);
                $jour_semaine = date('w', $timestamp);
                $jour_semaine =jour_de_semaine($jour_semaine);
                if(dayToInt($jour_semaine) >= dayToInt($result['jour_d'])   &&  dayToInt($jour_semaine) <= dayToInt($result['jour_f'])){
                    $req = $connexion->prepare("SELECT * FROM rendez_vous WHERE id_med = :id AND DATE(heure_rdv) = :dt AND TIME(heure_rdv) = :tm");
                    $req->bindParam(":id",$_POST['id_med']);
                    $req->bindParam(":dt",$_POST['date']);
                    $req->bindParam(":tm",$heure_actuelle);
                    $req->execute();
                    if($req->rowCount()==0){
                        echo '<div class="li_h" onclick="load(\''.$_POST['date'].' '.$heure_actuelle.':00\')">'.$heure_actuelle.'</div>' ; 
                    }
                }
                $timestamp_debut = strtotime('+30 minutes', $timestamp_debut);
            }
        } 
            
    
    }    
}

?>