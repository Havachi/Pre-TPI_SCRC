<?php

require "controllers/controller.php";


session_start();
if (isset($_GET['action'])) {
  $action = $_GET['action'];
  switch ($action) {
    case 'home':
      displayHome();
      break;
    case 'login':
    if (isset($_POST)) {
      login($_POST);
    }else {
      displayLogin();
    }

      break;
    default:
      displayHome();
      break;
  }
}else {
  displayHome();
}
