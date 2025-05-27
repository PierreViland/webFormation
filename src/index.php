<?php
// 🔧 Dossier à explorer (défini en dur ici)
$baseDir = realpath("/docPdf"); // <- Modifie ici selon ton chemin réel
if (!$baseDir || !is_dir($baseDir)) {
    die("Dossier invalide ou introuvable.");
}

// Récupère le sous-chemin demandé via GET
$requestedPath = isset($_GET['path']) ? $_GET['path'] : '';
$currentPath = realpath($baseDir . DIRECTORY_SEPARATOR . $requestedPath);

// Sécurité : ne pas sortir du dossier de base
if (strpos($currentPath, $baseDir) !== 0 || !file_exists($currentPath)) {
    die("Accès non autorisé ou fichier introuvable.");
}

// Fonction récursive pour lister les fichiers et dossiers
function listDirectory($dir, $baseDir) {
    $items = scandir($dir);
    echo "<ul>";
    foreach ($items as $item) {
        if ($item === "." || $item === "..") continue;
        $path = $dir . DIRECTORY_SEPARATOR . $item;
        $relativePath = ltrim(str_replace($baseDir, '', $path), DIRECTORY_SEPARATOR);

        if (is_dir($path)) {
            echo "<li><strong>📁 $item</strong>";
            listDirectory($path, $baseDir);
            echo "</li>";
        } else {
            echo "<li>📄 <a href='?path=" . urlencode($relativePath) . "'>$item</a></li>";
        }
    }
    echo "</ul>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Explorateur de fichiers PHP</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        ul { list-style-type: none; padding-left: 20px; }
        a { text-decoration: none; color: #0077cc; }
        a:hover { text-decoration: underline; }
        pre { background: #f4f4f4; padding: 10px; border: 1px solid #ccc; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h2>📁 Explorateur de fichiers PHP</h2>
    <h3>Contenu de : <?= htmlspecialchars($requestedPath ?: '/') ?></h3>

    <?php listDirectory($baseDir, $baseDir); ?>

    <?php if (is_file($currentPath)): ?>
        <h3>📄 Contenu de : <?= htmlspecialchars(basename($currentPath)) ?></h3>
        <pre><?= htmlspecialchars(file_get_contents($currentPath)) ?></pre>
    <?php endif; ?>
</body>
</html>

