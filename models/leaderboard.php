<?php
require_once 'DBConnection.php';

function fetchLeaderboard(){
  $query = "SELECT userFirstName, userLastName, userPBScore FROM users ORDER BY userPBScore DESC";
  $leaderboard = executeQuerySelectAssoc($query);
  return $leaderboard;
}
