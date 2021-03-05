<?php
require 'models/DBConnection.php';
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
  $query = "SELECT userPasswordHash FROM users WHERE userEmail = ".$strSep.$email.$strSep;
  try {
  $result = executeQuerySelectSingle($query);
  } catch (databaseError $e) {
    throw $e;
  }
  if (!empty($result)) {
    if (password_verify($psw,$result[0])) {
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
    $strSep = '\'';
    $query = "SELECT * FROM users WHERE userEmail =".$strSep.$userEmailAddress.$strSep;
    $userData=executeQuerySelectAssoc($query);
    $_SESSION['userID'] = $userData[0]['userID'];
    $_SESSION['userFirstName'] = $userData[0]['userFirstName'];
    $_SESSION['userLastName'] = $userData[0]['userLastName'];
    $_SESSION['userEmailAddress'] = $userEmailAddress;
    $_SESSION['userRole'] = $userData[0]['userRole'];
}
