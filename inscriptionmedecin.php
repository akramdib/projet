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

// Récupération des données du formulaire
$nom_med = $_POST['nom_med'];
$prenom_med = $_POST['prenom_med'];
$pass_med = $_POST['pass_med'];
$num_tel_med = $_POST['num_tel_med'];
$email_med = $_POST['email_med'];
$date_naissance_med = $_POST['date_naissance_med'];
$sexe_med = $_POST['sexe_med'];
$ville = $_POST['ville']; // Nouvel attribut pour la ville
$adresse_med = $_POST['adresse_med'];
$agrement = $_POST['agrement'];
$nom_spe = $_POST['nom_spe'];
$valide_med = 0; // Par défaut, le médecin n'est pas validé jusqu'à ce que l'administrateur le valide
$valide = 0; // Par défaut, la spécialité n'est pas validée

// Requête SQL pour vérifier si la spécialité saisie existe dans la table 'specialite'
$sql_specialite = "SELECT id_spe FROM specialite WHERE nom_spe = '$nom_spe'";
$result = $conn->query($sql_specialite);

if ($result->num_rows > 0) {
    // Si une correspondance est trouvée, récupérer l'ID de la spécialité
    $row = $result->fetch_assoc();
    $id_spe = $row['id_spe'];

    // Requête SQL pour insérer les données du médecin dans la table 'medecin'
    $sql_medecin = "INSERT INTO medecin (nom_med, prenom_med, pass_med, num_tel_med, email_med, date_naissance_med, sexe_med, ville, adresse_med, valide_med)
                    VALUES ('$nom_med', '$prenom_med', '$pass_med', '$num_tel_med', '$email_med', '$date_naissance_med', '$sexe_med', '$ville', '$adresse_med', '$valide_med')";

    // Exécution de la requête SQL pour insérer le médecin
    if ($conn->query($sql_medecin) === TRUE) {
        // Récupération de l'identifiant du médecin nouvellement inséré
        $id_med = $conn->insert_id;

        // Requête SQL pour insérer les données du médecin dans la table 'medecin_specialite'
        $sql_medecin_specialite = "INSERT INTO medecin_specialite (id_med, agrement, id_spe, valide)
                                    VALUES ('$id_med', '$agrement', '$id_spe', '$valide')";

        // Exécution de la requête SQL pour insérer la relation entre le médecin et la spécialité
        if ($conn->query($sql_medecin_specialite) === TRUE) {
            echo "Enregistrement réussi";
            header("Location: temp.html");
        } else {
            echo "Erreur lors de l'insertion des données dans la table 'medecin_specialite': " . $conn->error;
        }
    } else {
        echo "Erreur lors de l'insertion du médecin: " . $conn->error;
    }
} else {
    // Si aucune correspondance n'est trouvée, gérer l'erreur
    echo "Aucune spécialité correspondante trouvée pour : " . $nom_spe;
}

// Fermer la connexion à la base de données
$conn->close();
?>
