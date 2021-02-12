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
  $query = "SELECT userPasswordHash FROM users WHERE userEmail =".$strSep.$email.$strSep;
  try {
    $userDBPSW = executeQuerySelectSingle($query);
  } catch (Exception $e) {
    throw $e;
  }
    if (password_verify($psw,$userDBPSW)) {
      return true;
    }else {
      return false;
    }
}

 ?>
