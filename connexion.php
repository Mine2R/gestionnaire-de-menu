<?php
session_start();

try {
    $db = new PDO("mysql:host=localhost;dbname=gestionnaire;charset=utf8", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

if (isset($_POST["username"]) && isset($_POST["password"])) {

    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT id, username, password FROM user WHERE username = :username";
    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':username' => $username
    ]);

    $user = $stmt->fetch();
    

    if ($user && $password === $user['password']) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['id'] = $user['id'];

        header('Location: index.php');

        exit();
    } else {
        echo "Le nom d'utilisateur ou le mot de passe est incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="conn.css">
    <title>Connexion</title>
</head>
<body>
    <header>
        <h1>Connexion</h1>
        <form action="connexion.php" method="post">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="submit" name="submit" value="Se connecter">
        </form>
    </header>
</body>
</html>
