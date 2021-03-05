<?php
require_once 'models/DBConnection.php';

 /**
 * This function register a user in the database
 *
 * @param array The array that contain all user input from the Register form
 * @return void
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

  if (verifyEmailAddress($userEmailAddress)) {
    $registerQuery = "INSERT INTO users (userFirstname, userLastname, userEmail, userPasswordHash) VALUES (:userFirstname,:userLastname,:userEmail,:userPasswordHash)";
    $values = array(':userFirstname'=> $userFirstname,':userLastname'=> $userLastname,':userEmail'=>$userEmailAddress ,':userPasswordHash'=>$userPasswordHash);
    try {
      $statement = prepareQuery($registerQuery);
      $result = executeStatement($statement,$values);
    } catch (databaseError $e) {
      throw $e;
    }
  }else {
    throw new alreadyInUseEmail();
  }
}


/**
 * This function checks if an email address already exist in db
 *
 * @param string The Email address to verify
 * @return bool True = Email can be used, False = Email already in use
 * @author Alessandro Rossi
 */
function verifyEmailAddress($emailToVerify){
  $query = "SELECT userID FROM users WHERE userEmail = :email" ;
  $value = [':email' => $emailToVerify];
  try {
    $statement = prepareQuery($query);
    $result = executeStatement($statement,$values);
  } catch (databaseError $e) {
    throw $e;
  }
  if ($result === null) {
    return true;
  }
  return false;
}
 ?>
