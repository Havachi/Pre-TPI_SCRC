<?php
ob_start();
$title = "Concours";
?>

<div class="page-title">
  <h1>Concours</h1>
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
