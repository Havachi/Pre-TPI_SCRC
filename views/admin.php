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
    <form enctype="multipart/form-data" action="index.php?action=upload" method="post">
      <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
      <input class="admin-image-input" type="file" name="input-image" accept="image/*" value="">
      <input type="submit" name="submitType" value="upload" />
    </form>

  </div>
  <div class="admin-ban-container">
    <h3>Bannissement</h3>
    <p>Ici vous pouvez bannir des utilistateurs</p>
  </div>

</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
