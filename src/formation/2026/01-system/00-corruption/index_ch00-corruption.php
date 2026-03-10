<?php
require $_SERVER['DOCUMENT_ROOT'] . "/core/auth.php"; // auth universel
include $_SERVER['DOCUMENT_ROOT'] . "/core/header.php"; // header universel
?>

<div class="menu">
    <a href="../index_systeme.php">⬅ Retour au system /corruption mémoire</a>
</div>

<h2>Corruption mémoire simple</h2>

<p>
	Vou avez à disposition un executable (complier sur kali et donc à exécuter sur Kali). Une partie du code source à fuité. A vous de passer outre le mot de passe pour trouver le flag.
</p>

<pre><code>
#include &lt;iostream&gt;
#include &lt;cstring&gt;
int main()
{
    int authentification = 0;
    char mdp[10];
    char monMdp[8];
    char flag[32];

    /*Définition du mot de passe */
    //__________________
    //
    std::cout &lt;&lt; "Mot de passe : ";
    std::cin &gt;&gt; mdp;

    std::cout &lt;&lt; "authentification AVANT : " &lt;&lt; authentification &lt;&lt; "\n";

    if (std::strcmp(mdp, monMdp) == 0)
    {
	std::cout &lt;&lt; "Verification OK\n";
	authentification = 1;
    }

    std::cout &lt;&lt; "authentification APRES : " &lt;&lt; authentification &lt;&lt; "\n";

    if (authentification)
    {
	std::cout &lt;&lt; "\nAcces autorise. Le flag est :\n";
	std::cout &lt;&lt; flag &lt;&lt; "\n";
    }
    else
    {
	std::cout &lt;&lt; "\nAcces non autorise\n";
    }

    return 0;
}
</code></pre>

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
	$correctAnswer = "trop_de_caracteres_ca_deborde"; // <-- À REMPLIR : mettre la vraie réponse ici

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
    Il suffit de lancer l'executable. Peux-être que Gdb est votre meilleur ami? 

    </div>

    <!-- Colonne droite : Fichiers à télécharger -->
    <div class="files" style="flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px;">
	<h3>Fichiers à télécharger</h3>
	<ul>
	    <!-- À REMPLIR : liens vers les fichiers -->
	    <li><a href="t00-ch00-corruption">t00-ch00-corruption</a></li>
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
	 Element rapide de correction avec gdb </p>

	<pre style="white-space: pre-wrap; width: 100%;">
Objectif est de comprendre la gestion mémoire. Il faut y aller pas à pas et regarder l'impact du mot de passe sur la pile. Ci-dessous les commande utiles qui peuvent permettrent de trouver le flag. Il faudrait détailler plus.
<pre><code>                                                                                                                                                                                                  
┌──(kali㉿kali)-[/media/sf_20-testCTF/ctf2026/t01-system/t01-ch00-corruption]
└─$ gdb t00-ch00-corruption

(gdb) break main 
Breakpoint 1 at 0x40115e

(gdb) run

(gdb) disassemble 
Dump of assembler code for function main:
   0x0000000000401156 <+0>:     push   %rbp
   0x0000000000401157 <+1>:     mov    %rsp,%rbp
   0x000000000040115a <+4>:     sub    $0x20,%rsp
....

(gdb) break *0x401200
Breakpoint 2 at 0x401200

(gdb) x/32x $sp
0x7fffffffdc70: 0xffffddb8      0x00007fff      0x74420b18      0x65496353
0x7fffffffdc80: 0x6161004c      0x61616161      0x61616161      0x00000000
0x7fffffffdc90: 0x00000001      0x00000000      0xf7829f68      0x00007fff
0x7fffffffdca0: 0x00012000      0x00000000      0x00401156      0x00000000
0x7fffffffdcb0: 0x00000001      0x00000001      0xffffdda8      0x00007fff
0x7fffffffdcc0: 0xffffdda8      0x00007fff      0x8c545ae8      0x263a9410
0x7fffffffdcd0: 0x00000000      0x00000000      0xffffddb8      0x00007fff
0x7fffffffdce0: 0xf7ffd000      0x00007fff      0x00403df0      0x00000000
(gdb) c
Continuing.
authentification APRES : 0

Acces non autorise

(gdb) run
Breakpoint 1, 0x000000000040115e in main ()
(gdb) c
Continuing.
Mot de passe : aaaaaaaaaaaa
authentification AVANT : 24929

(gdb) c
Continuing.
authentification APRES : 24929

Acces autorise. Le falg est :

</code></pre>	     

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

	<ul>
	<li><strong>Utiliser des fonctions sûres</strong> : éviter les fonctions dangereuses comme <code>gets()</code>, <code>strcpy()</code>, <code>sprintf()</code>, <code>scanf("%s")</code>.
Préférer <code>fgets()</code>, <code>strncpy()</code>, <code>snprintf()</code>, <code>scanf("%32s")</code>.</li>

	<li><strong>Activer les protections du compilateur</strong> :
		- <code>-fstack-protector</code>, <code>-fstack-protector-strong</code>
		- <code>-D_FORTIFY_SOURCE=2</code>
		- <code>-Wformat -Wformat-security</code></li>

	<li><strong>Activer l’ASLR</strong> (Address Space Layout Randomization) :
		rend les adresses mémoire imprévisibles, compliquant l’exploitation.</li>

	<li><strong>Compiler en PIE</strong> (Position Independent Executable) :
		permet une randomisation complète du binaire.</li>

	<li><strong>Vérifier les tailles de buffers</strong> :
		toujours contrôler la taille des entrées utilisateur avant de les copier.</li>

	<li><strong>Utiliser des analyseurs statiques</strong> :
		outils comme <code>clang-tidy</code>, <code>cppcheck</code>, <code>Coverity</code> pour détecter les débordements potentiels.</li>

	<li><strong>Limiter les permissions du processus</strong> :
		un overflow dans un programme root est catastrophique ; utiliser le principe du moindre privilège.</li>

	<li><strong>Isoler les composants sensibles</strong> :
		sandboxing, chroot, containers, seccomp pour limiter l’impact d’une exploitation.</li>

	<li><strong>Activer les protections du linker</strong> :
		- <code>-z noexecstack</code>
		- <code>-z relro</code>
		- <code>-z now</code></li>

	<li><strong>Auditer régulièrement les binaires</strong> :
		utiliser <code>checksec</code> pour vérifier les protections activées.</li>
	</ul>

	<hr>
	
	<h3>Lien avec le BTS</h3>

	<ul>
	 <li><strong>C10 CODER</strong></li>
	 <li>Langage de développement</li>
	</ul>


    </div>
</div>

<script> function toggleCounter() { 
const box = document.getElementById("counterContent"); box.style.display = box.style.display === "none" ? "block" : "none"; } 
</script>




<?php
include $_SERVER['DOCUMENT_ROOT'] . "/core/footer.php"; // footer universel
?>

