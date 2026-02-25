<?php
include $_SERVER['DOCUMENT_ROOT'] . "/header.php"; // même thème et style
?>

<div class="menu" style="text-align:center; margin-top:50px;">
    <h2>Connexion à Formation 2026</h2>
</div>

<div style="max-width:400px; margin:30px auto; background:#fff; padding:30px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.1);">
    <?php if(!empty($error)): ?>
        <div style="color:red; margin-bottom:15px; text-align:center;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" action="">
        <div style="margin-bottom:15px;">
            <label>Nom d'utilisateur</label>
            <input type="text" name="username" style="width:100%; padding:10px; border-radius:5px; border:1px solid #ccc;">
        </div>
        <div style="margin-bottom:20px;">
            <label>Mot de passe</label>
            <input type="password" name="password" style="width:100%; padding:10px; border-radius:5px; border:1px solid #ccc;">
        </div>
        <button type="submit" style="width:100%; padding:10px; background:#0077cc; color:#fff; font-weight:500; border:none; border-radius:5px; cursor:pointer;">Se connecter</button>
    </form>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . "/footer.php"; // footer commun
?>
