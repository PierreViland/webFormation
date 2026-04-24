<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_forensic.php">⬅ Retour au challenge forensic</a>
</div>

<h2>Dump mémoire</h2>

<p>
Vous avez récupéré un dump mémoire d'un esp32 (Processeur Xtensa 32 bits little indian). Vous savez qu'une personne s'est connectér au réseau Wifi "salleCIEL". Vous voulez retrouver le mot de passe (le flag) de ce réseau wifi. A vous de jouer. 
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
        $correctAnswer = "rockstar"; // <-- mettre la vraie réponse ici

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
# Télécharger le fichier docker-compose .bin et analyser le 
        </pre>
    </div>

    <!-- Colonne droite : Fichiers à télécharger -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Fichiers à télécharger</h3>
        <ul>
            <li><a href="/formation/2026/04-forensic/00-dumpEsp32/dumpEspEsp32.bin">dumpEspEsp32.bin</a></li>
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
	Il faut utiliser Ghidra (en sélectionnant comme processueur Xtensa 32 little). Il faut ensuite analyser le fichier. Ensuite, il faut affiher les chaines de caractères présents en mémoire. Le mot de passe est à coté (en mémoire) du nom du réseau Wifi
	</p>

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

        <h3>Contre‑mesures pour éviter la récupération des mots de passe dans les microcontroleur</h3>


        <ul>
            <li><strong>Éviter les mots de passe en claire </strong> </li>
	   <li> Utiliser des 'secure zone' </li> 	
	</ul>

        <hr>

        <h3>Lien avec le BTS</h3>

        <ul>
	 <li><strong>C06 - VALIDER UN SYSTEME INFORMATIQUE</strong></li>
                <li>Sécuriser les réseaux</li>
		
         <li><strong>C09 - INSTALLER UN RESEAU INFORMATIQUE </strong></li>
                <li> WLAN</li> 
	</ul>


    </div>
</div>

<script> function toggleCounter() { 
const box = document.getElementById("counterContent"); box.style.display = box.style.display === "none" ? "block" : "none"; } 
</script>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php"; // footer universel
?>

