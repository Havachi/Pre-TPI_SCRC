<?php
require_once 'models/DBConnection.php';

function registerInDB($registerData)
{
  // TODO: Make this function prepare a PDOStatement instead of a simple sql string (safer)
  $registerResult = null;
  $strSeparator = '\'';

  $userFirstname = $registerData['inputUserFirstName'];
  $userLastname = $registerData['inputUserLastName'];
  $userEmailAddress = $registerData['inputUserEmail'];
  $userPasswordHash = password_hash($registerData['inputUserPassword'], PASSWORD_DEFAULT);

  $registerQuery = 'INSERT INTO users (userFirstname, userLastname, userEmail, userPasswordHash) VALUES (' . $strSeparator . $userFirstname . $strSeparator . ',' . $strSeparator . $userLastname . $strSeparator . ',' . $strSeparator . $userEmailAddress . $strSeparator . ',' . $strSeparator . $userPasswordHash . $strSeparator . ')';
  executeQuery($registerQuery);
}

 ?>
