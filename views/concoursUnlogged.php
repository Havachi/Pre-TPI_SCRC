<?php
ob_start();
$title = "Concours";
?>
<div class="page-title">
  <h1>Concours</h1>
</div>
<div class="alert-text text-center">
  <span>Vous devez être connecté pour participer au concours</span>
</div>

<div class="image-container">
<img src="content\images\<?= rand(1,10); ?>.jpg" alt="">
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
