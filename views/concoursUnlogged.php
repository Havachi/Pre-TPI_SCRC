<?php
ob_start();
$title = "Concours";
cacheControl($_SERVER['SCRIPT_FILENAME'], filemtime($_SERVER['SCRIPT_FILENAME']));
if (isset($error)) {
  $error[] = ['unlogged'=> "Vous devez vous connectez pour participer au concours"];
}else {
  $error = array('unlogged' => "Vous devez vous connectez pour participer au concours" );
}
?>
<div class="page-title">
  <h1>Concours</h1>
</div>


<div class="image-container">
<img src="content\images\<?= rand(1,10); ?>.jpg" alt="">
</div>

<?php
$content = ob_get_clean();
require "layout.php";
?>
