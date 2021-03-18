<?php

if (!isset($_SESSION)) session_start();

if (isset($_SERVER['REQUEST_METHOD']) || isset($_SESSION['postdata']['submitType'])){
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
      $submitCode=$_POST['submit'];
    }elseif (isset($_POST['submitType'])) {
      $submitCode=$_POST['submitType'];
    }else {
      $submitCode="pass";
    }
  }


  if (isset($submitCode)) {
    $exit = true;
    switch ($submitCode) {
      case 'try':
        $_SESSION['postdata'] = $_POST;
        unset($_POST);
        header("Location: ".$_SERVER['REQUEST_URI'],true,303);
        break;
      case 'validate':
        $_SESSION['postdata'] = $_POST;
        unset($_POST);
        header("Location: ".$_SERVER['REQUEST_URI'],true,303);
        break;
      case 'login':
        $_SESSION['postdata'] = $_POST;
        unset($_POST);
        header("Location: ".$_SERVER['REQUEST_URI'],true,303);
        break;
      case 'register':
        $_SESSION['postdata'] = $_POST;
        unset($_POST);
        header("Location: ".$_SERVER['REQUEST_URI'],true,303);
        break;
      case 'upload':
        $exit = false;
        $_SESSION['postdata'] = $_POST;
        $_SESSION['files'] = $_FILES;
        unset($_POST);
        header("Location: /index.php?action=upload ",true,303);
        break;
      case 'delete':
        unset($_SESSION['postdata']);
        header("Location: ".$_SERVER['REQUEST_URI'],true,303);
        break;
      case 'pass':
      default:
        header("Location: ".$_SERVER['REQUEST_URI'],true,303);
        break;
    }
    if($exit){exit;}

  }

}
/**
 * mode 0: clear $_SESSION['postdata']
 * mode 1: clear $_POST
 * mode 2: clear both
 *
 * @author
 * @copyright
 */
function clearPostData($mode=0){
  switch ($mode) {
    case 0:
    unset($_SESSION['postdata']);
      break;
    case 1:
    unset($_POST);
      break;
    case 2:
    unset($_SESSION['postdata']);
    unset($_POST);
      break;

  }
}
?>
