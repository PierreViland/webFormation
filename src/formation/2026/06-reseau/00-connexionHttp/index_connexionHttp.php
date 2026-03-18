<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_reseau.php">⬅ Retour au challenge réseau</a>
</div>

<h2>Connexion HTTP – Sniffer un mot de passe</h2>

<p>
Dans ce challenge, un utilisateur s’est connecté à un petit serveur web via une page d’authentification HTTP non sécurisée.  
Votre objectif est de <strong>sniffer le mot de passe en clair</strong> dans le trafic réseau, puis de l’utiliser pour obtenir le flag.
</p>

<p>
Le service tourne dans un conteneur Docker et transmet les identifiants en clair via une requête HTTP POST.  
À vous d’analyser le trafic réseau pour retrouver le mot de passe !
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
	$correctAnswer = "Http ca craint!!"; // <-- À REMPLIR : mettre la vraie réponse ici

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
    # Télécharger la capture
    # Analyser la capture 

    </div>

    <!-- Colonne droite : Fichiers à télécharger -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
	<h3>Fichiers à télécharger</h3>
	<ul>
	    <!-- À REMPLIR : liens vers les fichiers -->
	    <li><a href="t02-ch00-connexionHttp.pcapng">t02-ch00-connexionHttp.pcapng</a></li>
	</ul>
    </div>

</div>


<!-- BOUTON : Correction -->
<div class="box" style="margin-top: 30px;">
    <button onclick="toggleBox()">Afficher des éléments de correction (tricheur)</button>

    <div id="boxContent" style="display: none; margin-top: 20px; background: #f8f8f8; padding: 15px; border-radius: 6px;">
        <p>
        Le mot de passe circule en clair dans la requête HTTP POST.  
        Il suffit d’ouvrir la capture réseau dans Wireshark et de filtrer :
        </p>

        <pre>http</pre>

        <p>
	Dans le corps de la requête, vous verrez le login et le mot de passe. Regarder la réponse du serveur. Si le mot de passe est bon, vous aurez le flag.
	</p>

    </div>
</div>

<!-- BOUTON : Contre-mesures -->
<div class="box" style="margin-top: 30px;">
    <button onclick="toggleCounter()">Afficher les contre‑mesures et le lien avec le BTS CIEL</button>

    <div id="counterContent" style="display: none; margin-top: 20px; background: #f8f8f8; padding: 15px; border-radius: 6px;">
        <h3>Contre‑mesures</h3>
        <ul>
            <li>Ne jamais transmettre de mots de passe en clair</li>
            <li>Utiliser HTTPS systématiquement</li>
            <li>Utiliser des tokens ou des mécanismes d’authentification modernes</li>
        </ul>

        <hr>

        <h3>Lien avec le BTS CIEL</h3>
        <ul>
            <li><strong>C06 – Valider un système informatique</strong> : sécurisation réseau</li>
            <li><strong>C09 – Installer un réseau informatique</strong> : configuration WLAN et sécurité</li>
        </ul>
    </div>
</div>

<script>
function toggleBox() {
    const box = document.getElementById("boxContent");
    box.style.display = box.style.display === "none" ? "block" : "none";
}
function toggleCounter() {
    const box = document.getElementById("counterContent");
    box.style.display = box.style.display === "none" ? "block" : "none";
}
</script>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php"; // footer universel
?>
