<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_caesar.php">⬅ Retour au challenge crypto</a>
</div>

<h2>Jules et la crypto</h2>

<p>
Un administrateur a laissé un message chiffré sur un serveur.
On sait seulement qu’il a utilisé un chiffrement de César, mais on ignore le décalage exact.
</p>


<p>
Le message est <strong>SL MSHN LZA: MSHN{JOPMMYLTLUA ZPTWSL HCLJ JLZHY}</strong>
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
        $correctAnswer = "chiffrement simple avec cesar"; // <-- mettre la vraie réponse ici

        if ($userAnswer === $correctAnswer) {
            echo '<p style="color: green; font-weight: bold;">OK ! Bravo ✅</p>';
        } else {
            echo '<p style="color: red; font-weight: bold;">NOK ! Dommage ❌</p>';
        }
    }
    ?>
</div>


<!-- BOUTON POUR AFFICHER LA SOLUTION -->
<div style="width: 100%; padding: 20px; border: 1px solid #aaa; border-radius: 8px; margin-top: 30px;">

    <button onclick="toggleBox()" 
            style="padding: 10px 18px; font-size: 16px; cursor: pointer;">
        Afficher des éléments de correction (tricheur)
    </button>

    <div id="boxContent" style="display: none; margin-top: 20px; background: #f8f8f8; padding: 15px; border-radius: 6px;">

        <p>
	Très simple, il suffit de décaler les lettres de -6 pour obtenir le bon flag
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
        Lien avec le BTS CIEL
    </button>

    <div id="counterContent" style="display: none; margin-top: 20px; background: #f8f8f8; padding: 15px; border-radius: 6px;">


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

