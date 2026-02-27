<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_script.php">⬅ Retour au script</a>
</div>

<h2><!-- À REMPLIR : Titre du challenge --></h2>

<p>
    <!-- À REMPLIR : Description courte du challenge -->
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
        $correctAnswer = "A REMPLIR"; // <-- À REMPLIR : mettre la vraie réponse ici

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
<!-- À REMPLIR : commandes utiles pour résoudre le challenge -->
        </pre>
    </div>

    <!-- Colonne droite : Fichiers à télécharger -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Fichiers à télécharger</h3>
        <ul>
            <!-- À REMPLIR : liens vers les fichiers -->
            <li><a href="#">Fichier 1</a></li>
            <li><a href="#">Fichier 2</a></li>
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
            <!-- À REMPLIR : explication de la solution -->
        </p>

        <pre style="white-space: pre-wrap; width: 100%;">
<!-- À REMPLIR : commandes ou étapes de la solution -->
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

