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

// Vérifier si l'ID du médecin est présent dans la méthode POST
if (isset($_POST['id_med'])) {
    // Récupérer l'ID du médecin depuis la méthode POST
    $id_medecin = $_POST['id_med'];

    // Requête SQL pour récupérer les heures de travail du médecin avec cet ID
    $sql = "SELECT heure_d, heure_f FROM calendrier WHERE id_med = $id_medecin";

    // Exécution de la requête SQL
    $result = $conn->query($sql);

    // Affichage des résultats
    if ($result->num_rows > 0) {
        echo "<h2>Heures de travail du médecin :</h2>";
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>De " . $row["heure_d"] . " à " . $row["heure_f"] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "Aucune heure de travail trouvée pour ce médecin.";
    }
} else {
    // Si l'ID du médecin n'est pas présent dans la méthode POST, affichez un message d'erreur
    echo "ID du médecin non spécifié";
}

// Fermer la connexion à la base de données
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier de rendez-vous</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.8.0/main.min.css" integrity="sha512-3chpDfhCOp7/v8fEeV0jtUrFdKv9u5iA/cX0QpzujrE1HTG7ayQF1x3EDCBidrkzO8MOiDwjpNLk2azDfyMKLg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>

<div id='calendar'></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-F/vhuM+/rTE8a9KGy27v8M1/0j9q2Tl6vXhCvsqk5x5LgtL3pPnbNaDMFAsqoEnldQ6U+L88D1FdkUHqVPhM5A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.8.0/main.min.js" integrity="sha512-dfDpPx/WzG0GjJQ9qXe5rg/txyUBPoDWoP3g3Sz4ZkJwrAgN6xBMdo9MBzC2ebUC1A5TAmcfcy8i3WwQt0N6b5A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'timeGridWeek,timeGridDay'
            },
            slotDuration: '00:30:00', // Durée de chaque créneau (30 minutes)
            events: <?php echo json_encode($heures_travail); ?>
        });

        // Ajoutons un message de débogage pour vérifier les données récupérées
        console.log(<?php echo json_encode($heures_travail); ?>);

        calendar.render();
    });
</script>

</body>
</html>

