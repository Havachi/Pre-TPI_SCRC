<?php
require "models/login.php";

function displayHome()
{
  require "views/home.php";
}
function displayLogin(){
  require "views/login.php";
}

/**
 *
 * @param type array inputUserEmail and inputUserPassword
 */
function login($userLoginData){
  if(isset($userLoginData['inputUserEmail']) && isset($userLoginData['inputUserPassword'])){
    isLoginCorrect($userLoginData);
  }else {
    displayLogin();
  }
}
