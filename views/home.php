<?php 
ob_start(); 
$title = "Acceuil"; 
?> 
 
<div class=""> 
  <h1>Home Page</h1> 
</div> 
 
<?php 
$content = ob_get_clean(); 
require "layout.php"; 
?> 
