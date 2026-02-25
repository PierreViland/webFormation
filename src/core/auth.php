<?php
session_start();

/* Utilisateur autorisé */

$valid_username = 'formationCyber';

$valid_password_hash = '$2y$10$7R2rzGf3I2pm/50DGdrkze./S58FfE9.bkvwyb9gXgcXbIRUgCTIi';


/* Si connecté → continuer la page */

if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    return;
}


$error = '';

/* Traitement login */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (
        $username === $valid_username &&
        password_verify($password,$valid_password_hash)
    ) {
        $_SESSION['logged'] = true;

        header("Location: ".$_SERVER['REQUEST_URI']);
        exit;
    }

    $error = "Identifiant incorrect";
}


/* Affichage login avec le thème du site */

include $_SERVER['DOCUMENT_ROOT']."/core/header.php";
?>

<h2>Connexion</h2>

<div class="login-box">

<?php if($error) echo "<p style='color:red'>$error</p>"; ?>

<form method="post">

<p>
Utilisateur<br>
<input type="text" name="username" required>
</p>

<p>
Mot de passe<br>
<input type="password" name="password" required>
</p>

<p>
<button type="submit">Connexion</button>
</p>

</form>

</div>

<?php

include $_SERVER['DOCUMENT_ROOT']."/core/footer.php";

exit;
?>
