<?php
require 'models/DBConnection.php';
require 'models/BetterDBConnection.php';
/**
 * This function check if the user inputed values for login are correct and correspond to an account
 *
 * @param array $userLoginData
 * @author Alessandro Rossi
 * @return bool True = login ok False = error in login
 */
function isLoginCorrect($userLoginData)
{
  $email=$userLoginData['inputUserEmail'];
  $psw=$userLoginData['inputUserPassword'];
  $strSep = '\'';
  $query = "";
  try {
    $db = new DBConnection;
    $dbpsw = $db->single("SELECT userPasswordHash FROM users WHERE userEmail = :userEmail",array("userEmail"=>$email));
    if (empty($dbpsw)) {
      throw new loginError;
    }
  }
  catch (PDOException $e) {
    throw new loginError;
  }
  if (!empty($dbpsw)) {
    if (password_verify($psw,$dbpsw)) {
      return true;
    }else {
      return false;
    }
  }else {
    throw new loginError;
  }
}
/**
 * This function create the user Session and add some value to it
 *
 * @param string $userEmailAddress The user E-mail Address
 * @return void
 * @author Alessandro Rossi
 */
function createSession($userEmailAddress){
    $_SESSION['isLogged'] = true;
    try {
      $db = new DBConnection;
      $dbData = $db->query("SELECT * FROM users WHERE userEmail = :userEmail",array("userEmail"=>$userEmailAddress));
      $dbData = $dbData[0];
    }
    catch (PDOException $e) {
      throw new loginError;
    }
    $userData = array();
    $userData['userID'] = $dbData['userID'];
    $userData['userFirstName'] = $dbData['userFirstName'];
    $userData['userLastName'] = $dbData['userLastName'];
    $userData['userEmailAddress'] = $dbData['userEmail'];
    $userData['userRole'] = $dbData['userRole'];
    $_SESSION['userdata'] = $userData;
}
