<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_cracking.php">⬅ Retour au craking</a>
</div>

<h2>Craling super simple  </h2>

<p>
Un petit programme demande un mot de passe et vérifie si l’utilisateur peut accéder au flag. À vous d’analyser son fonctionnement pour comprendre ce qu’il attend.

Le binaire contient une logique de validation simple : votre objectif est de déterminer l’entrée correcte pour obtenir le flag.
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
        $correctAnswer = "mdp!super_Complique2026"; // <-- À REMPLIR : mettre la vraie réponse ici

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
	Fouiller dans l'executable pour trouver le mot de passe. 
	Ghidra peut être utile.
	</pre>
    </div>

    <!-- Colonne droite : Fichiers à télécharger -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Fichiers à télécharger</h3>
        <ul>
            <li><a href="t02-ch00-crackmeSimple">t02-ch00-crackmeSimple</a></li>
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
	juste utiliser la commande strings. Cette commande permet d'avoir les string des executables. 
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


<!-- BOUTON POUR AFFICHER LES CONTRE-MESURES -->
<div style="width: 100%; padding: 20px; border: 1px solid #aaa; border-radius: 8px; margin-top: 30px;">

    <button onclick="toggleCounter()"
	    style="padding: 10px 18px; font-size: 16px; cursor: pointer;">
	Afficher les contre‑mesures et le lien avec le BTS CIEL
    </button>

    <div id="counterContent" style="display: none; margin-top: 20px; background: #f8f8f8; padding: 15px; border-radius: 6px;">

	<p>Placer un mot de passe ou une clé directement dans un binaire est une erreur classique. Les outils comme <code>strings</code>, <code>objdump</code> ou <code>ghidra</code> permettent de les extraire facilement. Voici les protections couramment utilisées :</p>

	<ul>
	<li><strong>Ne jamais stocker de secrets en clair dans le code</strong> : mots de passe, clés API, tokens, identifiants… doivent être externalisés.</li>

	<li><strong>Utiliser des variables d’environnement</strong> : charger les secrets au runtime plutôt que les compiler dans le binaire.</li>

	<li><strong>Utiliser un coffre à secrets</strong> : Vault, AWS Secrets Manager, GCP Secret Manager, Azure Key Vault…</li>

	<li><strong>Chiffrer les secrets</strong> : si un secret doit être embarqué, le stocker chiffré et le déchiffrer en mémoire seulement.</li>

	<li><strong>Éviter les chaînes statiques</strong> : les constantes visibles dans la section .rodata sont triviales à extraire.</li>

	<li><strong>Obfuscation légère</strong> (en dernier recours) :
	- découper les chaînes
	- XOR simple
	- reconstruction dynamique

	<li><strong>Analyser le binaire avant déploiement</strong> :
	utiliser <code>strings</code>, <code>rabin2</code>, <code>ghidra</code> pour vérifier qu’aucun secret n’est présent.</li>

	<li><strong>Utiliser des mécanismes d’authentification robustes</strong> : éviter les mots de passe codés en dur, préférer des mécanismes externes (PAM, OAuth, certificats…).</li>

</ul>

	<hr>
	
	<h3>Lien avec le BTS</h3>

	<ul>
	<li> <strong>C05 CONCEVOIR UN SYSTEME INFORMATIQUE </strong></li>
	<li> Niveaux de sécurité attendus par la solution logicielle
	<li><strong>C10 CODER</strong></li>
	<li>Politiques internes et les référentiels externes liés à la sécurisation des applications...</li>
	</ul>


    </div>
</div>

<script> function toggleCounter() { 
const box = document.getElementById("counterContent"); box.style.display = box.style.display === "none" ? "block" : "none"; } 
</script>


<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php"; // footer universel
?>

