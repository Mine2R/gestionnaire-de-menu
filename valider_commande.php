<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valider_commande'])) {
    // Verification de l'utilisateur
    $utilisateur_id = $_SESSION['id'] ?? 0;
    
    if ($utilisateur_id === 0) {
        echo " Erreur : Aucun utilisateur n'est défini dans la session. Utilisation d'un ID test.";
    }

    // Vérification des données envoyées
    if (!isset($_POST['articles']) || !isset($_POST['total'])) {
        echo " Erreur : Données de commande manquantes.";
        exit;
    }

    $details = json_encode($_POST['articles']);
    $total = floatval($_POST['total']);

    // Exécuter la requête SQL avec gestion des erreurs
    try {
        $stmt = $pdo->prepare("INSERT INTO commandes (utilisateur_id, details, total, statut) VALUES (?, ?, ?, 'Validée')");
        $stmt->execute([$utilisateur_id, $details, $total]);
        echo "<h2> Commande validée avec succès !</h2>";
    } catch (PDOException $e) {
        echo " Erreur SQL : " . $e->getMessage();
    }
    echo "<link rel='stylesheet' href='valider_commande.css'>";
    echo "<a href='menu.php' class='return-button'>Retour au menu</a> | <a href='index.php' class='return-button'>Retour à l'accueil</a>";
}
?>
