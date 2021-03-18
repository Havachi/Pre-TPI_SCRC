<?php
ob_start();
$title = "Administration";
?>

<div class="page-title">
  <h1>Administation</h1>
</div>

<div class="admin-container">
  <div class="admin-image-container">
    <h3 class="admin-image-title">Ajout d'image</h3>
    <p class="admin-image-desc">Ici vous pouvez ajouter de nouvelle image au site</p>
    <form class="admin-imageupload-form" enctype="multipart/form-data" action="index.php?action=upload" method="post">
      <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
      <input class="admin-image-input" type="file" name="input-image" accept="image/*" required>

      <div class="admin-formGroup">
        <label class="admin-coor-label" for="inputLat">Latitude</label>
        <input class="admin-coor-input" type="text" name="inputLat" required>
      </div>
      <div class="admin-formGroup">
        <label class="admin-coor-label" for="inputlong">Longitude</label>
        <input class="admin-coor-input" type="text" name="inputLon" required>
      </div>
      <div class="admin-formGroup">
        <label class="admin-hint-label" for="inputHint1">Indice 1</label>
        <input class="admin-hint-input" type="text" name="inputHint1" required>
      </div>
      <div class="admin-formGroup">
        <label class="admin-hint-label" for="inputHint2">Indice 2</label>
        <input class="admin-hint-input" type="text" name="inputHint2" required>
      </div>
      <div class="admin-formGroup">
        <label class="admin-hint-label" for="inputHint3">Indice 3</label>
        <input class="admin-hint-input" type="text" name="inputHint3" required>
      </div>
      <br>
      <input class="admin-uploadbtn" type="submit" name="submitType" value="Upload" />
    </form>

  </div>
  <div class="admin-ban-container">
    <h3>Bannissement (WIP)</h3>

  </div>

</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
