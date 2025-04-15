<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    header("location: 404.php");
    exit;
}

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=gestionnaire;charset=utf8", "root", "", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active le mode exception pour gérer les erreurs
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Récupération des données sous forme de tableau associatif
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour afficher les produits par catégorie
function afficherProduits($pdo, $categorie) {
    // Préparation de la requête SQL sécurisée
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE categorie = ?");
    $stmt->execute([$categorie]); // Exécution sécurisée de la requête

    // Récupération des résultats sous forme de tableau associatif
    $produits = $stmt->fetchAll();

    // Vérification s'il y a des produits à afficher
    if (count($produits) > 0) {
        echo "<section>";
        echo "<h2>$categorie</h2>";
        echo "<div class='category'>";

        // Parcours des produits récupérés
        foreach ($produits as $row) {
            echo "<label class='item'>";
            echo "<input type='checkbox' name='ingredients[]' value='".$row['nom']."' style='display: none;'>";
            echo "<img src='".$row['image']."' alt='".$row['nom']."'>";
            echo "<h3>".$row['nom']."</h3>";
            echo "<p>".$row['prix']."€</p>";
            echo "</label>";
        }

        echo "</div>";
        echo "</section>";
    } else {
        // Message si aucun produit n'est trouvé
        echo "<p>Aucun produit disponible dans cette catégorie.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compose ton burger</title>
    <link rel="stylesheet" href="menu.css">
</head>
<body>
    <header>
        <h1>Compose ton burger</h1>
    </header>

    <nav>
        <a href="index.php">Accueil</a>
        <a href="menu.php">Menu</a>
        <a href="connexion.php">Connexion</a>
        <a href="inscription.php">Inscription</a>
        <a href="deconnexion.php">Déconnexion</a>
    </nav>

    <form action="commande.php" method="post">
        <div class="menu-container">
            <?php
            afficherProduits($pdo, "Pain");
            afficherProduits($pdo, "Viande");
            afficherProduits($pdo, "Garniture");
            afficherProduits($pdo, "Sauce");
            afficherProduits($pdo, "Accompagnement");
            afficherProduits($pdo, "Boisson");
            ?>
            <button type="submit" class="validate-button">Valider le menu</button>
        </div>
    </form>

</body>
</html>
