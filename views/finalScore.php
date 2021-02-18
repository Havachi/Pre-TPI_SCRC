<?php
ob_start();
$title = "Score";
?>
<h1>Votre score final: <?php echo $_SESSION['totalScore'] ?></h1>
<h3>Score Détailé: </h3>
<?php foreach ($_SESSION['userScores'] as $lvl => $score): ?>
<span><?php echo $lvl . " : " . $score?></span><br/>
<?php endforeach; ?>
<br>
<a href="index.php?action=home">Retourner à l'accueil</a>
<?php
$content = ob_get_clean();
require "layout.php";
?>
