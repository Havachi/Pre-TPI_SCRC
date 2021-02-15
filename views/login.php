<?php
ob_start();
$title = "Login";
?>

<div class="page-title">
  <h1>Se connecter</h1>
</div>

<div class="login-container">
  <form class="login-form" action="index.php?action=login" method="post">
    <div class="login-fieldGroup email">
      <label class="login-fieldGroup-label" for="inputUserEmail">Adresse E-Mail</label>
      <input class="login-fieldGroup-input" type="text" name="inputUserEmail" value="">
    </div>
    <div class="login-fieldGroup password">
      <label class="login-fieldGroup-label" for="inputUserPassword">Mot de passe</label>
      <input class="login-fieldGroup-input" type="password" name="inputUserPassword" value="">
    </div>

    <div class="login-fieldGroup submit">
      <button class="submitButton" type="submit">Connexion</button>
    </div>
    <div class="login-noaccount">
      <p>Pas de compte? Créer en un <a class="login-noaccount-link" href="index.php?action=register">ICI</a></p>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
