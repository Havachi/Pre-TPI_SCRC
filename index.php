<?php

require "controllers/controller.php";


session_start();
if (isset($_GET['action'])) {
  $action = $_GET['action'];
  switch ($action) {
    case 'home':
      displayHome();
      break;

    case 'concours':
      if (isset($_SESSION['isLogged'])) {
        if (isset($_SESSION['currentScore'])) {
          displayConcoursLevel($_SESSION['currentLevel']);
        }else {
          displayConcoursFirst();
        }
      }else {
        displayConcoursFirst();
      }

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
