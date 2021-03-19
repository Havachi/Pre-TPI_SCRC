<?php
require_once "exceptions/inputException.php";

function inputVerifier($haysacks){
  $illegalChars = array('\\',';','<','>','--','##'); //Please Handle with care
  foreach ($haysacks as $haysack) {
    foreach ($illegalChars as $illegalChar) {
      if (str_contains($haysack,$illegalChar)) {
        

        exit();
      }
    }
  }
}
