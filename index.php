<?php
require 'models/globals.php';
require "controllers/controller.php";
require "models/general.php";
require "exceptions/handlers.php";
require "models/cachecontrol.php";

//set_exception_handler('exception_handler');
session_start();
if (isset($_POST)) {
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
      if (isset($_SESSION['isLogged'])) {
        if (isset($_POST['btnNext'])) {
          if (isset($_POST['userInputLatitude']) && isset($_POST['userInputLongitude'])) {
            if (!$_POST['userInputLatitude'] === "" && !$_POST['userInputLongitude'] === "") {
              coucoursValidate($_POST['userInputLatitude'],$_POST['userInputLongitude']);
            }elseif (isset($_SESSION['tryScores']['Try1']) || isset($_SESSION['tryScores']['Try2']) || isset($_SESSION['tryScores']['Try3'])) {
              $bestAttemptsCoordinates=calculateBestAttempt();
              coucoursValidate($bestAttemptsCoordinates['Lat'],$bestAttemptsCoordinates['Long']);
            }}
        }elseif (isset($_POST['btnTry'])) {
          coucoursAttempt();
        }elseif(isset($_GET['hint'])){
          if ($_GET['hint'] <= 3 || $_GET['hint'] >= 0) {
            useHint();
          }
        }else {
          if (isset($_SESSION['currentLevel'])) {
            displayConcours();
          }else {
            displayConcoursLevel('1');
          }
        }
      }else {
        displayConcoursNotLogged();
      }

      break;
    case 'leaderboard':
      prepareLeaderboard();
      break;
    case 'login':
      if (isset($_POST)) {
        login($_POST);
      }else {
        displayLogin();
      }
      break;
    case 'register':
      if (isset($_POST)) {
        register($_POST);
      }else {
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

    default:
      displayHome();
      break;
  }
}else {
  displayHome();
}
