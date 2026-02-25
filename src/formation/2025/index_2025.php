<?php
require $_SERVER['DOCUMENT_ROOT']."/core/auth.php";

// Dossier à explorer
$baseDir = realpath("/var/www/php/downloads/docpdf");
if (!$baseDir || !is_dir($baseDir)) {
    die("Dossier invalide ou introuvable.");
}

// Sous-chemin demandé
$requestedPath = $_GET['path'] ?? '';
$currentPath = realpath($baseDir . DIRECTORY_SEPARATOR . $requestedPath);

// Sécurité
if ($currentPath && strpos($currentPath, $baseDir) === 0 && file_exists($currentPath)) {

    // Gestion fichiers AVANT header.php
    if (is_file($currentPath)) {

        $action = $_GET['action'] ?? 'view';
        $mime = mime_content_type($currentPath);

        if ($action === 'view') {
            header('Content-Type: ' . $mime);
            readfile($currentPath);
            exit;
        }

        if ($action === 'download') {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($currentPath) . '"');
            header('Content-Length: ' . filesize($currentPath));
            readfile($currentPath);
            exit;
        }
    }

} else {
    die("Accès non autorisé ou fichier introuvable.");
}

/* SEULEMENT MAINTENANT */
include $_SERVER['DOCUMENT_ROOT']."/core/header.php";
?>

<?php


// Dossier à explorer
$baseDir = realpath("/var/www/php/downloads/docpdf");
if (!$baseDir || !is_dir($baseDir)) {
    die("Dossier invalide ou introuvable.");
}

// Sous-chemin demandé
$requestedPath = isset($_GET['path']) ? $_GET['path'] : '';
$currentPath = realpath($baseDir . DIRECTORY_SEPARATOR . $requestedPath);

// Sécurité
if (strpos($currentPath, $baseDir) !== 0 || !file_exists($currentPath)) {
    die("Accès non autorisé ou fichier introuvable.");
}


// Gestion fichiers
if (is_file($currentPath)) {

    $action = $_GET['action'] ?? 'view';
    $mime = mime_content_type($currentPath);

    if ($action === 'view') {
        header('Content-Type: ' . $mime);
        readfile($currentPath);
        exit;
    }

    if ($action === 'download') {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($currentPath) . '"');
        header('Content-Length: ' . filesize($currentPath));
        readfile($currentPath);
        exit;
    }
}


// Liste dossiers
function listDirectory($dir, $baseDir) {

    $items = scandir($dir);

    echo "<ul>";

    foreach ($items as $item) {

        if ($item === "." || $item === "..")
            continue;

        $path = $dir . DIRECTORY_SEPARATOR . $item;

        $relativePath = ltrim(
            str_replace($baseDir, '', $path),
            DIRECTORY_SEPARATOR
        );

        if (is_dir($path)) {

            echo "<li><strong>$item</strong>";

            listDirectory($path, $baseDir);

            echo "</li>";

        } else {

            echo "<li>

            <a href='?path="
            . urlencode($relativePath)
            . "&action=view'>$item</a>

            |

            <a href='?path="
            . urlencode($relativePath)
            . "&action=download'>Télécharger</a>

            </li>";
        }
    }

    echo "</ul>";
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>

<meta charset="UTF-8">

<title>Explorateur PDF 2025</title>

<style>

body {
    font-family: Arial;
    padding: 20px;
}

ul {
    list-style-type: none;
    padding-left: 20px;
}

a {
    text-decoration: none;
    color: #0077cc;
}

a:hover {
    text-decoration: underline;
}

li {
    margin-bottom: 5px;
}

.menu {
    margin-bottom:20px;
    font-size:18px;
}

</style>

</head>

<body>

<div class="menu">
<a href="../../index.php">⬅ Retour au menu principal</a>
</div>

<h2>Enoncés des activités 2025</h2>

<h3>Contenu des dossiers PDF</h3>

<?php listDirectory($baseDir,$baseDir); ?>

<br><br>

<div class="menu">
<a href="../../index.php">⬅ Retour au menu principal</a>
</div>

</body>
</html>
