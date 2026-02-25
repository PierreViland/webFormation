<?php
// Le mot de passe à tester
$mot_de_passe = 'acRennes!!2025';

// Le hash stocké sur le serveur
$hash = '$2y$10$YcS1Nn2o0Rz9JYw2H7z0FeVYhZgMdW6uV6XByJxK3pGmFv4t8JZ6S';

// Vérification
if (password_verify($mot_de_passe, $hash)) {
    echo "✅ Le mot de passe correspond au hash !";
} else {
    echo "❌ Le mot de passe ne correspond pas au hash";
}
?>
