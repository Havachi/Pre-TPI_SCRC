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
      displayLogin();
      break;

    default:
      displayHome();
      break;
  }
}else {
  displayHome();
}
