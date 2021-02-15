<?php
require "models/login.php";
require "models/register.php";

/*Display only part*/
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
function displayConcoursFirst()
{
  require "views/concoursLogged.php";
}

/*End of Display only part*/


/*Model access functions*/

/**
 * This function firstly check if every fields of the form was set,
 * then send data to the model or redirect the user
 * @param array $userLoginData is the post data received from the login page
 * @return void
 * @author Alessandro Rossi
 */
function login($userLoginData){
  if(isset($userLoginData['inputUserEmail']) && isset($userLoginData['inputUserPassword'])){
    if (isLoginCorrect($userLoginData)) {
      createSession($userLoginData['inputUserEmail']);
      $_GET['action'] = "home";
      require "views/Home.php";
    }else {
      $_GET['error'] = "err:invlog";
    }
  }else {
    displayLogin();
  }
}
/**
 * This function firstly check if every fields of the form was set,
 * then verify if the confirmation of the password is equal to the password,
 * And finally send data to the model or redirect the user
 *
 * @param array $userRegisterData is the post data received from the register page
 * @return void
 * @author Alessandro Rossi
 */
function register($userRegisterData)
{
  if(isset($userRegisterData['inputUserLastName']) && isset($userRegisterData['inputUserFirstName']) && isset($userRegisterData['inputUserEmail']) && isset($userRegisterData['inputUserPassword']) && isset($userRegisterData['inputUserPasswordConf'])){
    if ($userRegisterData['inputUserPassword'] === $userRegisterData['inputUserPasswordConf']) {
      registerInDB($userRegisterData);
      $_GET['action'] = "home";
      require "views/Home.php";
    }else {
      $_GET['error'] = "err:invdb";
      displayRegister();
    }
  }else {
    displayRegister();
  }
}
function displayConcoursLevel(){
  $imageToShow="";

}


/*End of Model access functions*/
/* Other */
function logout(){
  session_destroy();
  $_GET['action'] = 'home';
  require 'views/home.php';
}
/*End of Other*/
