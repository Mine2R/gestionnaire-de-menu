<?php
session_start();

if (isset($_SESSION['id'])) {
}
else header("location: 404.php");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Menu Burger</title>
    <link rel="stylesheet" href="style.css">
    <style>
    .burger-image {
        width: 100vw;
        height: auto;
        display: block;
        margin: 0 auto;
    }
</style>

</head>
<body>
    <header class="main-header">
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">ACCUEIL</a></li>
                <li><a href="menu.php">MENU</a></li>
                <li><a href="connexion.php">CONNEXION</a></li>
                <li><a href="inscription.php">INSCRIPTION</a></li>
                <li><a href="deconnexion.php">DECONNEXION</a></li>
            </ul>
        </nav>
    </header>
    <main> 
    <img src="../Menu/Burgers.jpg" alt="Burger" class="burger-image">

    </main>
    <footer>
        <p>&copy; 2025 - Projet Menu Burger</p>
    </footer>
</body>
</html>
