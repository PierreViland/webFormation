<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_script.php">⬅ Retour au script</a>
</div>

<h2>SetUID</h2>

<p>
Ce challenge vous permet de vous familiariser avec les fichiers SetUID sur Linux. 
Vous allez analyser un binaire avec des permissions spéciales, comprendre son comportement,
et utiliser les outils Docker fournis pour le tester en toute sécurité.
</p>
<!-- Formulaire pour vérifier la réponse -->
<div style="margin-top: 30px; padding: 10px; border: 1px solid #ccc; border-radius: 8px; max-width: 500px;">
    <h3>Vérifier votre réponse</h3>
    <form method="post">
        <label for="answer">Entrez la réponse :</label><br>
        <input type="text" name="answer" id="answer" style="width: 100%; padding: 5px; margin-top: 5px;" required><br><br>
        <input type="submit" value="Vérifier" style="padding: 5px 10px;">
    </form>

    <?php
    // Vérification de la réponse
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userAnswer = trim($_POST['answer']);
        $correctAnswer = "L’ignorance, c’est la force."; // <-- mettre la vraie réponse ici

        if ($userAnswer === $correctAnswer) {
            echo '<p style="color: green; font-weight: bold;">OK ! Bravo ✅</p>';
        } else {
            echo '<p style="color: red; font-weight: bold;">NOK ! Dommage ❌</p>';
        }
    }
    ?>
</div>

<div class="challenge-container" style="display: flex; gap: 20px; margin-top: 20px;">

    <!-- Colonne gauche : Commandes utiles -->
    <div class="commands" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Etapes à suivre</h3>
        <pre>
# Charger l'image téléchargée
docker load -i  t00-ch00-setuid.tar

# lancer le container
docker compose up -d

# Se connecter en ssh au container mdp : toor
ssh user@localhost -p 2222

# A LA FIN DU CHALLENGE : ARRTER ET SUPPRIMER LE CONTAINER 
docker compose down
#Effacer la connexion ssh
ssh-keygen -f '~/.ssh/known_hosts' -R '[localhost]:2222'
        </pre>
    </div>

    <!-- Colonne droite : Fichiers à télécharger -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Fichiers à télécharger</h3>
        <ul>
            <li><a href="/formation/2026/00-script/00-setuid/t00-ch00-setuid.tar">Image Docker (.tar)</a></li>
            <li><a href="/formation/2026/00-setuid/00-script/00-setuid/docker-compose.yml">docker-compose.yml</a></li>
        </ul>
    </div>

</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php"; // footer universel
?>
