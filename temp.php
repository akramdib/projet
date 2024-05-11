<?php
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

// Récupération de la dernière valeur de id_med dans la table medecin
$sql_last_id = "SELECT MAX(id_med) AS last_id FROM medecin";
$result_last_id = $conn->query($sql_last_id);
if ($result_last_id->num_rows > 0) {
    $row_last_id = $result_last_id->fetch_assoc();
    $last_id = $row_last_id["last_id"];
    // Incrémenter la dernière valeur de id_med pour l'utiliser dans le nouvel enregistrement
    $id_med = $last_id + 1;
} else {
    // Si la table medecin est vide, définir id_med à 1
    $id_med = 1;
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $jourDebut = $_POST['jourDebut'];
    $heureDebut = $_POST['heureDebut'];
    $jourFin = $_POST['jourFin'];
    $heureFin = $_POST['heureFin'];

    // Requête SQL pour insérer les données dans la table calendrier
    $sql = "INSERT INTO calendrier (id_med, jour_d, heure_d, jour_f, heure_f) VALUES ('$id_med', '$jourDebut', '$heureDebut', '$jourFin', '$heureFin')";

    if ($conn->query($sql) === TRUE) {
        // Redirection vers la page d'accueil des médecins
        header("Location: accueildoc.html");
        exit(); // Arrêter le script après la redirection
    } else {
        echo "Erreur lors de l'insertion des données: " . $conn->error;
    }
}

// Fermer la connexion à la base de données
$conn->close();
?>
