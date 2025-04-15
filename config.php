<?php
$host = 'localhost'; // Serveur de base de données
$dbname = 'gestionnaire'; // Remplace par le nom de ta base
$username = 'root'; // Ton utilisateur MySQL (par défaut 'root' sous WAMP)
$password = ''; // Ton mot de passe MySQL (par défaut vide sous WAMP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
