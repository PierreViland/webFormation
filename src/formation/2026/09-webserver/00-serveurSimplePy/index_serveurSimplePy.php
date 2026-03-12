<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_webserveur.php">⬅ Retouri au challenge serveur </a>
</div>

<h2>Simple serveur python</h2>

<p>
Vous devez vous connectez pour trouver le flag. Le mot de passe est presque sous votre nez.
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
        $correctAnswer = "unTienVautMieuxQueDeuxTuLAuras"; 

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

# Sur un navigateur web connecté vous à : 
http://localhost:8080

#Chercher alors le flag..

# A LA FIN DU CHALLENGE : ARRÊTER ET SUPPRIMER LE CONTAINER 
docker compose down

        </pre>
    </div>

    <!-- Colonne droite : Fichiers à télécharger -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Fichiers à télécharger</h3>
        <ul>
            <li><a href="/formation/2026/09-webserver/00-serveurSimplePy/docker-compose.yml">docker-compose.yml</a></li>
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
	Le concepteur du site a bien fait son travail. Il a utilisé un outil de versionning : Github. Il a même partagé son code mais attention dans son code il y a le mot de passe 
	</p>

	<p>
	Erreur, courante, dans les sources du fichier app.py, le mot de passe apparaît en clair. 
	</p>


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

        <h3>Contre‑mesures pour éviter les mots de passe dans les dépots</h3>

        <ul>
	    <li><strong>Ne jamais mettre de mot de passe dans des sources</strong> </li>
	    <li> Utiser des varaibles d'environnement </li>
	    <li> Utiliser des variables ou fichiers non versionnées (avec les var d'environnement </li>
	    <li> Utiliser des outils de détection de secrets : Git-secrets ou des outils avant commit Git hooks, 
        </ul>

        <hr>

        <h3>Lien avec le BTS</h3>

        <ul>
	 <li><strong>C08 - CODER</strong></li>
                <li>Le code est verionné</li>
		<li>Chaine d'intégraton et de déploimen</li>
		
                <li><strong>C03 - GERER UN PROJET </strong></li>
                <li> Outils de gestion de projet</li> 
	</ul>


    </div>
</div>

<script> function toggleCounter() { 
const box = document.getElementById("counterContent"); box.style.display = box.style.display === "none" ? "block" : "none"; } 
</script>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php"; // footer universel
?>

