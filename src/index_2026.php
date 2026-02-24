<?php
// Authentification basique en dur
$valid_username = 'formationCyber';   
$valid_password = 'acRennes!!2025';  

if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
    || $_SERVER['PHP_AUTH_USER'] !== $valid_username
    || $_SERVER['PHP_AUTH_PW'] !== $valid_password) {
    
    header('WWW-Authenticate: Basic realm="Accès restreint"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentification requise.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>Formation 2026</title>

<style>

body {
    font-family: Arial;
    padding: 40px;
}

.menu {
    margin-bottom: 20px;
    font-size: 18px;
}

.message {
    margin-top: 40px;
    font-size: 20px;
}

a {
    color: #0077cc;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

</style>

</head>

<body>

<div class="menu">
<a href="index.php">⬅ Retour au menu principal</a>
</div>


<h2>Formation 2026</h2>

<div class="message">
La formation 2026 sera disponible prochainement.
</div>


<br><br>

<div class="menu">
<a href="index.php">⬅ Retour au menu principal</a>
</div>

</body>
</html>
