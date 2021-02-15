<?php
ob_start();
$title = "Concours";
?>

<div class="page-title">
  <h1>Concours</h1>
</div>
<div class="concours-container">
  <div class="concours-currentLevel">
    <span><h3>Photo x/10</h3></span>
  </div>
  <div class="concours-imageContainer">
    <img class="concours-image"src="content\images\memes.jpeg" alt="">
  </div>
  <form class="concours-form" action="index.php?action=concours" method="post">
    <div class="concours-formGroup">
      <label class="concours-formLabel" for="userInputLongitude">Longitude</label>
      <input class="concours-formInput" type="text" name="userInputLongitude" value="">
    </div>
    <div class="concours-formGroup">
      <label class="concours-formLabel" for="userInputLatitude">Latitude</label>
      <input class="concours-formInput" type="text" name="userInputLatitude" value="">
    </div>
    <div class="concours-formGroup">
      <label class="concours-buttonLabel" for="btnTry">Tentative x/3</label>
      <button class="secondaryButton" type="button" name="btnTry">Vérifier</button>
    </div>
    <div class="concours-formGroup">
      <button class="submitButton" type="submit" >Valider</button>
    </div>
  </form>
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
