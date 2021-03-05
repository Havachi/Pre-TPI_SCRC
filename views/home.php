<?php
ob_start();
$title = "Accueil";
?>

<div class="page-title">
  <h1>Bienvenue sur SCRC</h1>
</div>
<div class="home-textContainer">
  <p>Un grand concours est lancé, le principe 10 photos de lieux, votre but les localisés et indiqué les coordonnées de longitude et latitude au plus proche de la solution. Plus votre réponse est proche plus vous gagnerez de point.</p>
  <p>Pour gagner le concours il faut avoir le plus de point et être classé premier.
Si vous souhaité savoir l'avancement du classement vous pourvez y accèder directement grace au bouton Classement.</p>
  <p>Pour participer au concours, il vous suffit de vous créer un compte, puis de vous connecter, et finalement vous aurez la possiblité de réponde au différente questions du concours.</p>
  <p>Partager des solutions ou des informations par rapport au concours est interdit et peut vous faire bannir totalement du site.</p>
</div>
<h2 class="home-goodLuck">Bonne chance !</h2>
<?php
$content = ob_get_clean();
require "layout.php";
?>
