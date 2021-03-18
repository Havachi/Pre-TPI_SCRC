<?php
require 'models/globals.php';
require "controllers/controller.php";
require "models/general.php";
require "exceptions/handlers.php";
require "models/cachecontrol.php";
require "models/validateForm.php";

//set_exception_handler('exception_handler');
if (!isset($_SESSION)) session_start();
if (!empty($_POST)) {
  try {
    inputVerifier($_POST);
  } catch (illegalCharDetected $e) {
    $error = array('illegalCharDetected' => $e->getMessage() );
    require "views/home.php";
    exit();
  }
}
if (isset($_GET['error'])) {
require "models/httperror.php";
displayErrorPage($_GET['error']);
}
if (isset($_GET['action'])) {
  $action = $_GET['action'];
  switch ($action) {
    case 'home':
      displayHome();
      break;

    case 'concours':
      if (!empty($_SESSION['isLogged'])) {
        concoursControle();
      }else {
        displayConcoursNotLogged();
      }
      break;
    case 'leaderboard':
      prepareLeaderboard();
      break;
    case 'login':
      if (isset($_SESSION['postdata'])) {
        login($_SESSION['postdata']);
        unset($_SESSION['postdata']);
      }else {
        unset($error);
        displayLogin();
      }
      break;
    case 'register':
      if (isset($_SESSION['postdata'])) {
        register($_SESSION['postdata']);
        unset($_SESSION['postdata']);
      }else {
        unset($error);
        displayRegister();
      }
      break;
    case 'profile':
      if (isset($_SESSION['isLogged'])) {
        displayProfile();
      }else {
        displayHome();
      }
      break;
    case 'logout':
      logout();
      break;

    case 'admin':
      displayAdminPage();
      break;
    case 'upload':
      if (isset($_SESSION['postdata']) && !empty($_SESSION['postdata'])) {
        upload();
      }else {
        //unset($_FILES);
      }
      break;
    default:
      displayHome();
      break;
  }
}else {
  displayHome();
}
