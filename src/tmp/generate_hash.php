<?php
// Ton mot de passe en clair
$mot_de_passe = 'choupette';

// Générer le hash sécurisé avec bcrypt
$hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

echo "Hash généré : <br>";
echo $hash;
?>
