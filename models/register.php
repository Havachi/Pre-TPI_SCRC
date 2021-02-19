<?php
require_once 'models/DBConnection.php';

/**
 * This function register a user in the database
 *
 * @param array The array that contain all user input from the Register form
 * @return    void
 * @author  Alessandro Rossi
 */
function registerInDB($registerData)
{
  // TODO: Make this function prepare a PDOStatement instead of a simple sql string (safer)
  $registerResult = null;
  $strSeparator = '\'';

  $userFirstname = $registerData['inputUserFirstName'];
  $userLastname = $registerData['inputUserLastName'];
  $userEmailAddress = $registerData['inputUserEmail'];
  $userPasswordHash = password_hash($registerData['inputUserPassword'], PASSWORD_ARGON2I);


  $registerQuery = 'INSERT INTO users (userFirstname, userLastname, userEmail, userPasswordHash) VALUES (' . $strSeparator . $userFirstname . $strSeparator . ',' . $strSeparator . $userLastname . $strSeparator . ',' . $strSeparator . $userEmailAddress . $strSeparator . ',' . $strSeparator . $userPasswordHash . $strSeparator . ')';
  executeQuery($registerQuery);
}
 ?>
