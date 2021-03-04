<?php
ob_start();
$title = "Profile";
?>
<div class="page-title">
  <h1>Profile</h1>
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
