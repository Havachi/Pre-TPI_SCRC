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
    $values = array('userFirstname'=> $userFirstname,'userLastname'=> $userLastname,'userEmail'=>$userEmailAddress ,'userPasswordHash'=>$userPasswordHash);
    try {
      $db = new DBConnection;
      $results = $db->query($registerQuery,$values);
      if ($results===0) {
        throw new databaseError();
      }
    }
    catch (PDOException $e) {
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
  $values = array('email' => $emailToVerify);
  try {
    $db = new DBConnection;
    $userData = $db->query($query,$values);
  }
  catch (PDOException $e) {
    throw $e;
  }
  if ($userData === null || $userData === "" || empty($userData)) {
    return true;
  }
  return false;
}
 ?>
