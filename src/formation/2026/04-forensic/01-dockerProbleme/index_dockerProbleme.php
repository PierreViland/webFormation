<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_forensic.php">⬅ Retour au challenge forensic</a>
</div>

<h2>Docker – Secret caché dans une couche</h2>

<p>
Vous avez récupéré une image Docker nommée <strong>docker-problem</strong>. 
Le développeur affirme avoir supprimé un fichier sensible (<code>flag.txt</code>) pendant la construction de l’image.
<br><br>
Votre objectif : <strong>retrouver le flag</strong> en analysant les couches de l’image Docker.
</p>

<!-- Formulaire pour vérifier la réponse -->
<div style="margin-top: 30px; padding: 10px; border: 1px solid #ccc; border-radius: 8px; max-width: 500px;">
    <h3>Vérifier votre réponse</h3>
    <form method="post">
        <label for="answer">Entrez le flag :</label><br>
        <input type="text" name="answer" id="answer" style="width: 100%; padding: 5px; margin-top: 5px;" required><br><br>
        <input type="submit" value="Vérifier" style="padding: 5px 10px;">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userAnswer = trim($_POST['answer']);
        $correctAnswer = "ca craint la conf docker!!"; // <-- mettre la vraie réponse ici

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
# 1) Récupérer l'image Docker depuis Docker Hub
docker pull pviland/t04-ch01-dockerprobleme

# 2) Vérifier l'historique de construction
docker history pviland/t04-ch01-dockerprobleme

# 3) Exporter l'image au format tar
docker save -o dockerprobleme.tar pviland/t04-ch01-dockerprobleme

# 4) Extraire le contenu de l'image
tar -xf dockerprobleme.tar

# 5) Explorer les couches (format OCI)

</pre>

   </div>

    <!-- Colonne droite : Fichiers à télécharger -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
        <h3>Fichiers à télécharger</h3>
        <ul>
            <li>Rien n'est à télécharger. Juste pull d'une image docker</a></li>
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
        L’image Docker utilise le format OCI. Les couches se trouvent dans <code>blobs/sha256/</code>.
        <br><br>
        En lisant <code>manifest.json</code>, vous obtenez la liste des digests correspondant aux couches.
        <br><br>
        Chaque digest est un fichier tar.gz contenant une couche. Il suffit de les extraire un par un :
        </p>

<pre>
tar -xf blobs/sha256/<digest> -C /tmp/layer
find /tmp/layer | grep flag
</pre>

        <p>
        Le fichier <code>flag.txt</code> apparaît dans la couche correspondant à l’instruction :
        <br>
        <code>COPY flag.txt /opt/flag.txt</code>
        <br><br>
        Même si le fichier a été supprimé dans une couche suivante, il reste présent dans l’historique.
        </p>

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

        <h3>Contre‑mesures pour éviter les fuites de secrets dans Docker</h3>

        <ul>
            <li><strong>Ne jamais copier de secrets dans une image Docker</strong></li>
            <li>Utiliser <strong>.dockerignore</strong> pour exclure les fichiers sensibles</li>
            <li>Utiliser des <strong>multi‑stage builds</strong></li>
            <li>Utiliser des <strong>secrets runtime</strong> (BuildKit, Vault…)</li>
        </ul>

        <hr>

        <h3>Lien avec le BTS CIEL</h3>

        <ul>
            <li><strong>C09 – Installer un réseau informatique</strong> : Systèmes d’exploitations (Windows, UNIX, virtualisations) </li>
        </ul>

    </div>
</div>

<script>
function toggleCounter() {
    const box = document.getElementById("counterContent");
    box.style.display = box.style.display === "none" ? "block" : "none";
}
</script>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php"; // footer universel
?>

