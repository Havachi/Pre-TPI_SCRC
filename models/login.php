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

  $query = "SELECT userPasswordHash FROM users WHERE userEmail =\'".$email."\'";

  $DBpsw=executeQuerySelect($query);
  if ($psw === $DBpsw) {
    return true;
  }
  return false;
}

 ?>
