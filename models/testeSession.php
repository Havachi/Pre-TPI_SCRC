<?php
function setSession()
{
  $userData = array();
  $userData['userID'] = 999;
  $userData['userFirstName'] = "Alessandro";
  $userData['userLastName'] = "Rossi";
  $userData['userEmailAddress'] = "alessandro.rossi7610@gmail.com";
  $userData['userRole'] = "1";
  $_SESSION['userdata'] = $userData;
}
