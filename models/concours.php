<?php
function concoursInit($currentLevel){

  $_SESSION['pathToImage']="/content/images/".$currentLevel.".jpg";

  if (!isset($_SESSION['attempsNumber'])) {
    $attempsNumber=0;
    $_SESSION['attempsNumber']=0;
  }
  $_SESSION['currentLevel']=1;
}
function coucoursAttempt(){
  if (isset($_SESSION['attempsNumber'])) {

    $_SESSION['attempsNumber']=$_SESSION['attempsNumber']+1;
  }
  require "views\concoursLogged.php";
}
function coucoursValidate(){

}
