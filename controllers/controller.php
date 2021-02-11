<?php
require "models/login.php";

function displayHome()
{
  require "views/home.php";
}
function displayLogin(){
  require "views/login.php";
}
function displayRegister()
{
  require "views/register.php";
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

function register($userRegisterData)
{
  if(false){
    registerInDB($userRegisterData);
  }else {
    displayRegister();
  }
}
