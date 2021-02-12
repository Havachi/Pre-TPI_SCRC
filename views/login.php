<?php
ob_start();
$title = "Login";
?>

<div class="page-title">
  <h1>Se connecter</h1>
</div>

<div class="login-container">
  <form class="login-form" action="index.php?action=login" method="post">
    <div class="form-fieldGroup email">
      <label class="form-field-label" for="inputUserEmail">Adresse E-Mail</label>
      <input class="form-field" type="text" name="inputUserEmail" value="">
    </div>
    <div class="form-fieldGroup password">
      <label class="form-field-label" for="inputUserPassword">Mot de passe</label>
      <input class="form-field" type="password" name="inputUserPassword" value="">
    </div>

    <div class="form-fieldGroup submit">
      <button class="form-btn" type="submit">Connexion</button>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
