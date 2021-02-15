<?php
ob_start();
$title = "Register";
?>

<div class="page-title">
  <h1>Créer un compte</h1>
</div>

<div class="register-container">
  <form class="register-form" action="index.php?action=register" method="post">
    <!--Last Name Field -->
    <div class="register-fieldGroup lastname">
      <label class="register-fieldGroup-label" for="inputUserLastName">Nom de famille</label>
      <input class="register-fieldGroup-input" type="text" name="inputUserLastName" value="">
    </div>
    <!--First Name Field -->
    <div class="register-fieldGroup firstname">
      <label class="register-fieldGroup-label" for="inputUserFirstName">Prénom</label>
      <input class="register-fieldGroup-input" type="text" name="inputUserFirstName" value="">
    </div>

    <!--Email Addresse Field -->
    <div class="register-fieldGroup email">
      <label class="register-fieldGroup-label" for="inputUserEmail">Adresse E-mail</label>
      <input class="register-fieldGroup-input" type="email" name="inputUserEmail" value="">
    </div>

    <!--Password Field -->
    <div class="register-fieldGroup psw">
      <label class="register-fieldGroup-label" for="inputUserPassword">Mot de passe</label>
      <input class="register-fieldGroup-input" type="password" name="inputUserPassword" value="">
    </div>
    <!--Password Confirmation Field -->
    <div class="register-fieldGroup pswConf">
      <label class="register-fieldGroup-label" for="inputUserPasswordConf">Confirmation</label>
      <input class="register-fieldGroup-input" type="password" name="inputUserPasswordConf" value="">
    </div>
    <!--Submit button -->
    <div class="register-fieldGroup submit">
      <button class="submitButton" type="submit">Valider</button>
    </div>
    <div class="register-hasaccount">
      <p>Déja un compte? Connectez-vous <a class="register-hasaccount-link" href="index.php?action=login">ICI</a></p>
    </div>

  </form>
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
