<?php
// Authentification basique en dur i Moche mais c'est comme ca....
$valid_username = 'formationCyber';   
$valid_password = 'acRennes!!2025';  
if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
    || $_SERVER['PHP_AUTH_USER'] !== $valid_username
    || $_SERVER['PHP_AUTH_PW'] !== $valid_password) {
    
    header('WWW-Authenticate: Basic realm="Accès restreint"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Authentification requise.';
    exit;
}


// Dossier à explorer (défini en dur ici)
$baseDir = realpath("/var/www/php/docpdf");
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

// 📄 Gérer l'affichage ou téléchargement d'un fichier
if (is_file($currentPath)) {
    $action = $_GET['action'] ?? 'view';
    $mime = mime_content_type($currentPath);

    if ($action === 'view') {
        header('Content-Type: ' . $mime);
        readfile($currentPath);
        exit;
    } elseif ($action === 'download') {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($currentPath) . '"');
        header('Content-Length: ' . filesize($currentPath));
        readfile($currentPath);
        exit;
    }
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
            echo "<li><strong> $item</strong>";
            listDirectory($path, $baseDir);
            echo "</li>";
        } else {
            echo "<li> 
                <a href='?path=" . urlencode($relativePath) . "&action=view'>$item</a> | 
                <a href='?path=" . urlencode($relativePath) . "&action=download'> ou Télécharger</a>
            </li>";
        }
    }
    echo "-----------------------------------------------------------------------------------";
    echo "</ul>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Explorateur de fichiers PDF</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        ul { list-style-type: none; padding-left: 20px; }
        a { text-decoration: none; color: #0077cc; }
        a:hover { text-decoration: underline; }
        li { margin-bottom: 5px; }
    </style>
</head>
<body>
    <h2>Enoncés des activités </h2>
    <h3>Contenu des dossiers avec pdf </h3>

    <?php listDirectory($baseDir, $baseDir); ?>
</body>
</html>

