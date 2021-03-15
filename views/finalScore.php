<?php
ob_start();
$title = "Score";
cacheControl($_SERVER['SCRIPT_FILENAME'], filemtime($_SERVER['SCRIPT_FILENAME']));
?>
<h1>Votre score final: <?php echo $_SESSION['Settings']['Concours']['totalScore'] ?></h1>
<h3>Score Détailé: </h3>
<?php foreach ($_SESSION['Settings']['Concours']['userScores'] as $lvl => $score): ?>
<span><?php echo $lvl . " : " . $score?></span><br/>
<?php endforeach; ?>
<br>
<a href="index.php?action=home">Retourner à l'accueil</a>
<?php
$content = ob_get_clean();
require "layout.php";
?>
