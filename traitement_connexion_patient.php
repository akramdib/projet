<?php
// Démarrez la session PHP
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root"; // Votre nom d'utilisateur MySQL
$password = ""; // Votre mot de passe MySQL
$dbname = "rdv_medicaux"; // Le nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Récupération des données du formulaire
$email = $_POST['email_patient'];
$motdepasse = $_POST['pass_patient'];

// Requête SQL pour vérifier les informations de connexion du patient
$sql = "SELECT * FROM patient WHERE email_patient='$email' AND pass_patient='$motdepasse'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // L'utilisateur est authentifié, vous pouvez rediriger vers une page de profil ou effectuer d'autres actions nécessaires.
    $row = $result->fetch_assoc();
    $id_patient = $row['id_patient'];
    
    // Stocker l'id_patient dans une variable de session
    $_SESSION['id_patient'] = $id_patient;
    echo "Connexion réussie. Redirection vers la page de profil...";
    header("Location: accueilpatient.html");
    // Ajoutez ici votre code de redirection
} else {
    // L'utilisateur n'est pas authentifié
    echo "Identifiants incorrects. Veuillez réessayer.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
