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
    $dbpsw = $db->query("SELECT userPasswordHash FROM users WHERE userEmail = :userEmail",array("userEmail"=>$email));
    $dbpsw = $dbpsw[0]['userPasswordHash'];
  }
  catch (PDOException $e) {
    throw $e;
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
      $userData = $db->query("SELECT * FROM users WHERE userEmail = :userEmail",array("userEmail"=>$userEmailAddress));
    }
    catch (PDOException $e) {
      throw $e;
    }
    $_SESSION['userID'] = $userData[0]['userID'];
    $_SESSION['userFirstName'] = $userData[0]['userFirstName'];
    $_SESSION['userLastName'] = $userData[0]['userLastName'];
    $_SESSION['userEmailAddress'] = $userEmailAddress;
    $_SESSION['userRole'] = $userData[0]['userRole'];
}
