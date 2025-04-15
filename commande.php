<?php
print_r($_POST);


session_start();
require 'config.php'; // Fichier contenant la connexion à la BDD

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['valider_commande'])) {

    $utilisateur_id = $_SESSION['user_id'];
    $details = json_encode($_POST['articles']); // Stocker les articles commandés sous forme de JSON
    $total = $_POST['total'];

    $stmt = $pdo->prepare("INSERT INTO commandes (utilisateur_id, details, total, statut) VALUES (?, ?, ?, 'commandes')");
    $stmt->execute([$utilisateur_id, $details, $total]);

    echo "Commande validée avec succès!";
}

// Vérifier si des ingrédients ont été sélectionnés
if (!isset($_POST['ingredients'])) {
    echo "<p>Aucun ingrédient sélectionné. <a href='menu.php'>Retour au menu</a></p>";
    exit;
}

// Connexion à la base de données
$conn = new mysqli("localhost", "root", "", "gestionnaire");

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$ingredients = $_POST['ingredients'];

$placeholders = implode(',', array_fill(0, count($ingredients), '?'));
$sql = "SELECT nom, prix, image FROM produits WHERE nom IN ($placeholders)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(str_repeat('s', count($ingredients)), ...$ingredients);
$stmt->execute();
$result = $stmt->get_result();

$produits_selectionnes = [];
$total = 0;

while ($row = $result->fetch_assoc()) {
    $produits_selectionnes[] = $row;
    $total += $row['prix'];
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
    <link rel="stylesheet" href="commande.css">
</head>
<body>

<h1>Récapitulatif de votre commande</h1>

<table>
    <tr>
        <th>Image</th>
        <th>Ingrédient</th>
        <th>Prix</th>
    </tr>
    <?php foreach ($produits_selectionnes as $produit): ?>
        <tr>
            <td><img src="<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" width="50"></td>
            <td><?= htmlspecialchars($produit['nom']) ?></td>
            <td><?= number_format($produit['prix'], 2) ?>€</td>
        </tr>
    <?php endforeach; ?>

    <!-- Ligne du Total -->
    <tr>
        <td colspan="2" style="font-weight: bold; text-align: right;">Total :</td>
        <td style="font-weight: bold;"><?= number_format($total, 2) ?>€</td>
    </tr>
</table>
<div class="button-container">
    <a href="menu.php">Retour au menu</a>

    <!-- Formulaire pour valider la commande -->
    <form action="valider_commande.php" method="post">
        <?php foreach ($ingredients as $ingredient) : ?>
            <input type="hidden" name="articles[]" value="<?= htmlspecialchars($ingredient) ?>">
        <?php endforeach; ?>
        <input type="hidden" name="total" value="<?= $total ?>">
        <button type="submit" name="valider_commande">Valider la commande</button>
    </form>
</div>


</body>
</html>
