<?php
$db = new PDO("mysql:host=localhost;dbname=gestionnaire;charset=utf8", "root", "");

if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"])) {
    $email = htmlspecialchars($_POST["email"]);
    $username = htmlspecialchars($_POST["username"]);
    $password = ($_POST["password"]);

    $req = $db->prepare('INSERT INTO user(email, username, password) VALUES(:email, :username, :password)');
    $req->execute([
        'email' => $email,
        'username' => $username,
        'password' => $password,
    ]);

    header('Location: connexion.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inscription.css">
    <title>Inscription</title>
</head>
<body>
    <div class="container">
        <h2>Inscription</h2>
        <form action="inscription.php" method="POST">
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="input-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn">S'inscrire</button>
        </form>
    </div>
</body>
</html>
