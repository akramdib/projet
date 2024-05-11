<?php
// Récupération de l'email depuis le formulaire
$email = $_POST['email'];

// Validation de l'email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Si l'email n'est pas valide, renvoyer un message d'erreur
    echo "Adresse email non valide";
    exit(); // Arrêter le script
}

// Génération d'un token pour la réinitialisation du mot de passe
$token = bin2hex(random_bytes(32)); // Génère une chaîne de 64 caractères hexadécimaux aléatoires

// Enregistrement du token dans la base de données ou dans un fichier selon votre méthode de stockage

// Envoi de l'email de récupération de mot de passe
$subject = "Récupération de mot de passe";
$message = "Bonjour,\n\nVous avez demandé une réinitialisation de votre mot de passe. Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : https://votresite.com/reset_password.php?token=$token\n\nSi vous n'avez pas demandé cette réinitialisation, veuillez ignorer ce message.\n\nCordialement,\nVotre site web";
$headers = "From: dibakram42@gmail.com";

// Envoyer l'email
if (mail($email, $subject, $message, $headers)) {
    // Si l'email est envoyé avec succès, afficher un message de succès
    echo "Un email de récupération de mot de passe a été envoyé à votre adresse email.";
} else {
    // Si l'email n'est pas envoyé, afficher un message d'erreur
    echo "Une erreur s'est produite lors de l'envoi de l'email. Veuillez réessayer plus tard.";
}
?>
