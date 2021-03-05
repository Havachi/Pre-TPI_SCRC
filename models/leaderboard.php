<?php
require_once 'DBConnection.php';

function fetchLeaderboard(){
  $query = "SELECT userFirstName, userLastName, userPBScore FROM users ORDER BY userPBScore DESC";
  try {
    $leaderboard = executeQuerySelectAssoc($query);
  } catch (databaseError $e) {
    throw $e;
  }
  return $leaderboard;
}
function getUserPos(){
  $pos=1;
  $query = "SELECT userEmail, userPBScore FROM users ORDER BY userPBScore DESC";
  try {
    $leaderboard = executeQuerySelectAssoc($query);
  } catch (databaseError $e) {
    throw $e;
  }
  foreach ($leaderboard as $user) {
    foreach ($user as $key => $value) {
      if ($key == "userEmail") {
        if ($value == $_SESSION['userEmailAddress']) {
          return $pos;
        }
      }
    }
    $pos++;
  }
}
