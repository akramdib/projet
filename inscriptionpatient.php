<?php
// Connexion à la base de donnees
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "rdv_medicaux"; 

// Creation de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Verification de la connexion
if ($conn->connect_error) {
    die("Connexion echoue: " . $conn->connect_error);
}

// Recuperation des donnees du formulaire
$email = $_POST['email_patient'];
$motdepasse = $_POST['pass_patient'];
$nom = $_POST['nom_patient'];
$prenom = $_POST['prenom_patient'];
$date_naissance = $_POST['date_naissance_pat'];
$num_tel = $_POST['num_tel_patient'];
$sexe = $_POST['sexe_patient'];

// Requete SQL pour inserer les donnees du formulaire dans la base de donnees
$sql = "INSERT INTO patient (email_patient, pass_patient, nom_patient, prenom_patient, date_naissance_pat, num_tel_patient, sexe_patient)
VALUES ('$email', '$motdepasse', '$nom', '$prenom', '$date_naissance', '$num_tel', '$sexe')";

if ($conn->query($sql) === TRUE) {
    echo "Enregistrement reussi";
} else {
    echo "Erreur: " . $sql . "<br>" . $conn->error;
}

// Fermer la connexion a la base de donnees
$conn->close();
?>
