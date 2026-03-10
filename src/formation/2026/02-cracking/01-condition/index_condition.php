<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php";
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php";
?>

<div class="menu">
    <a href="../index_cracking.php">⬅ Retour au cracking</a>
</div>

<h2>Cracking – Condition cassée</h2>

<p>
Ce programme demande un mot de passe… mais ne le vérifie jamais réellement.

Votre objectif : analyser le binaire pour comprendre pourquoi la condition ne peut jamais être vraie
et comment contourner cette logique pour afficher le message secret.
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
        $correctAnswer = "youhhou, c est reussi!!"; // <-- À REMPLIR : mettre la vraie réponse ici

        if ($userAnswer === $correctAnswer) {
            echo '<p style="color: green; font-weight: bold;">OK ! Bravo ✅</p>';
        } else {
            echo '<p style="color: red; font-weight: bold;">NOK ! Dommage ❌</p>';
        }
    }
    ?>
</div>

<div class="challenge-container" style="display: flex; gap: 20px; margin-top: 20px;">

    <!-- Étapes -->
    <div class="commands" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Étapes à suivre</h3>
        <pre>
Analyser le binaire :
- Pourquoi x vaut toujours 0 ?
- Comment forcer x à 1 ?
- Ghidra ? Patch?
        </pre>
    </div>

    <!-- Fichiers -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Fichiers à télécharger</h3>
        <ul>
            <li><a href="t02-ch01-condition">t02-ch01-condition</a></li>
        </ul>
    </div>

</div>

<!-- Solution -->
<div style="width: 100%; padding: 20px; border: 1px solid #aaa; border-radius: 8px; margin-top: 30px;">
    <button onclick="toggleBox()" style="padding: 10px 18px; font-size: 16px; cursor: pointer;">
        Afficher des éléments de correction
    </button>

    <div id="boxContent" style="display: none; margin-top: 20px; background: #f8f8f8; padding: 15px; border-radius: 6px;">
        <p>Dans le programme C :</p>
        <pre>
volatile int x;
x = 0;

if (x) { ... }
        </pre>

        <p>
La condition est <strong>toujours fausse</strong>.  
Pour afficher le message secret, il faut :
        </p>

        <ul>
            <li>modifier le binaire (patch : remplacer <code>je</code> par <code>jne</code> ou encore plus simple remplacer la valeur d'initialisation de x)</li>
	</ul>

	Pour cela, on peut utiliser Ghidra et voir la condition pour afficher le FLAG. Elle est basée sur la valeur de la variable x. Regader l'opcode correspondant à l'initialisation de la variable x. Alors, utiliser un editeur hexa pour modifier son initialisation 
	<img src="correction_Condition.jpg" alt="Image kali">   

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

	<p>
	Une condition de sécurité peut être contournée si un attaquant parvient à modifier le binaire (patch, NOP, inversion de saut, injection…).
	En entreprise, plusieurs mécanismes existent pour empêcher ou détecter ces modifications.
	</p>

	<ul>
	<li><strong>Signer les exécutables</strong> :
	l’utilisation de signatures numériques (Authenticode, GPG, certificats internes) permet de vérifier qu’un binaire n’a pas été altéré avant son exécution.</li>

	<li><strong>Activer l’intégrité du système</strong> :
	des mécanismes comme <code>dm-verity</code>, <code>IMA/EVM</code> (Linux) ou Windows Defender Application Control empêchent l’exécution de binaires modifiés.</li>

	<li><strong>Utiliser des politiques d’exécution strictes</strong> :
	AppArmor, SELinux ou WDAC limitent quels binaires peuvent être lancés et sous quelles conditions.</li>

	<li><strong>Déployer des protections anti‑tampering</strong> :
	certains environnements ajoutent des contrôles internes (hash, checksum, vérification de sections) pour détecter toute modification du fichier.</li>

	<li><strong>Restreindre les permissions sur les fichiers</strong> :
	un binaire sensible ne doit jamais être modifiable par un utilisateur non privilégié (droits en lecture seule, répertoires protégés).</li>

	<li><strong>Utiliser des systèmes de fichiers en lecture seule</strong> :
	sur des environnements embarqués ou critiques, placer les exécutables dans une partition montée en <code>ro</code> empêche toute altération.</li>

	<li><strong>Surveiller l’intégrité avec des outils dédiés</strong> :
	AIDE, Tripwire ou OSSEC comparent régulièrement les hash des exécutables pour détecter toute modification.</li>

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
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php";
?>

