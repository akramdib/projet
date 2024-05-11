<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rdv_medicaux";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $email = $_POST['email_med'];
    $motDePasse = $_POST['pass_med'];
    // Requête SQL pour vérifier si l'email et le mot de passe correspondent à un médecin dans la base de données
    $sql = "SELECT * FROM medecin WHERE email_med='$email' AND pass_med='$motDePasse'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        echo "Connexion réussie. Redirection...";
        header("Location: accueildoc.html");
        exit(); // Arrêter le script après la redirection
    } else {
        echo "Identifiants incorrects.";
        $errorMessage = "Adresse email ou mot de passe incorrect.";
    }
    
}

// Fermer la connexion à la base de données
$conn->close();
?>



