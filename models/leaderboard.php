<?php
require_once 'DBConnection.php';

function fetchLeaderboard(){
  $query = "SELECT userFirstName, userLastName, userPBScore FROM users ORDER BY userPBScore DESC";
  $leaderboard = executeQuerySelectAssoc($query);
  return $leaderboard;
}
function getUserPos(){
  $pos=1;
  $query = "SELECT userEmail, userPBScore FROM users ORDER BY userPBScore DESC";
  $leaderboard = executeQuerySelectAssoc($query);
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
