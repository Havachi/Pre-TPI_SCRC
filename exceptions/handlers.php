<?php
function exception_handler(){
  static $error = array("Une erreur est survenu, veuillez réessayer plus tard");
  require "views/home.php";
}
