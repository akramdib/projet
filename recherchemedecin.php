<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Résultats de la recherche</title>
<style>
     body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-image: url('rendesvs.jpeg');
        background-size: cover; /* Ajuste la taille de l'image pour remplir l'écran */
        background-position: center; /* Centre l'image sur l'écran */
    }
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: rgba(255, 255, 255, 0.8); /* Fond semi-transparent */
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center; /* Centrer le titre */
    }
    .result {
        margin-bottom: 20px;
        border: 2px solid #007bff; /* Bordure bleue */
        border-radius: 8px;
        padding: 20px;
    }
    .btn-container {
        text-align: center;
    }
    .btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
        margin-top: 10px;
    }
    .btn:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Résultats de la recherche</h1>
    <?php
// Démarrez la session
session_start();

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

// Récupération des données du formulaire
$ville = isset($_GET['ville']) ? $_GET['ville'] : '';
$searchType = isset($_GET['searchType']) ? $_GET['searchType'] : '';
$nom_med = isset($_GET['nom_med']) ? $_GET['nom_med'] : '';
$nom_spe = isset($_GET['nom_spe']) ? $_GET['nom_spe'] : '';

// Initialisation de la requête SQL
$sql = "SELECT medecin.* FROM medecin";

// Construire la clause WHERE
$whereConditions = array();

// Condition sur la ville
if (!empty($ville)) {
    $whereConditions[] = "ville LIKE '%$ville%'";
}

// Condition sur la spécialité
if (!empty($nom_spe)) {
    $sql .= " INNER JOIN medecin_specialite ON medecin.id_med = medecin_specialite.id_med";
    $sql .= " INNER JOIN specialite ON medecin_specialite.id_spe = specialite.id_spe";
    $whereConditions[] = "specialite.nom_spe LIKE '%$nom_spe%'";
}

// Condition sur le nom
if (!empty($nom_med)) {
    $whereConditions[] = "nom_med LIKE '%$nom_med%'";
}

// Ajouter la clause WHERE si des conditions sont spécifiées
if (!empty($whereConditions)) {
    $sql .= " WHERE " . implode(" AND ", $whereConditions);
}

// Exécution de la requête SQL
$result = $conn->query($sql);

// Affichage des résultats
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo '<div class="result">';
        echo '<ul>';
        echo '<li>Nom: ' . $row["nom_med"] . '</li>';
        echo '<li>Prénom: ' . $row["prenom_med"] . '</li>';
        echo '<li>Numéro de téléphone: ' . $row["num_tel_med"] . '</li>'; // Ajout du numéro de téléphone
        
        echo '<li>Adresse: ' . $row["adresse_med"] . '</li>';
        echo '</ul>';
        echo '<div class="btn-container">';
        echo '<form action="http://localhost/mini_projet/Calendrier/';
        if(isset($_GET['id_med']) && isset($_SESSION['id_pat'])) {
            echo '?id_med=' . $_GET['id_med'] . '&id_pat=' . $_SESSION['id_pat'];
        }
        echo '" method="post">';
        echo '<input type="hidden" name="id_med" value="' . $row["id_med"] . '">'; // Ajout d'un champ caché pour l'ID du médecin
        echo '<button type="submit" class="btn">Consulter</button>'; // Texte modifié
        echo '</form>'; // Modification ici
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div class="result">Aucun médecin trouvé</div>';
}

// Fermer la connexion à la base de données
$conn->close();
?>

</div>
</body>
</html>
