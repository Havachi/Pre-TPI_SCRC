<?php
/**
 * This function will open a new connection with the database
 *
 * @return dbconnection The connection with the databases
 * @author Alessandro Rossi
 */
// TODO: remove Hardcoded database username and password (can't help you on how)
function openDBConnexion(){
    $localConnectionData = array('hostname' => 'localhost' ,'username' => 'SCRCConnector', 'password' => 'Pa$$w0rd', 'dbname' => 'scrc' );

    $hostname = $localConnectionData['hostname'];
    $userName = $localConnectionData['username'];
    $userPwd = $localConnectionData['password'];
    $dbname = $localConnectionData['dbname'];
    $dsn = "mysql:host=".$hostname.";dbname=".$dbname;

    $dbconnect = new PDO($dsn, $userName, $userPwd);

    return $dbconnect;
}

/**
 * Execute a simple query that doesn't return something (not select).
 * This function use transaction, for more safety, and rollback at any exceptions
 * @param     string $query The query to execute
 * @return    int   The number of affected lines
 * @author    Alessandro Rossi w/ https://zetcode.com/php/pdo/
 *
 */
function executeQuery($query)
{
    $db=openDBConnexion();
  try {
    $db->beginTransaction();
    $result = $db->exec($query);
    $db->commit();
    return $result;
  } catch (Exception $e) {
    $db->rollback();
    throw $e;
  }
}
/**
 * Execute a select query that return a single string
 * This function use transaction, for more safety, and rollback at any exceptions
 * @param     string $query The query to execute
 * @return    array The result of the query, as an associative array
 * @author    Alessandro Rossi w/ https://zetcode.com/php/pdo/ for the transaction part
 *
 */
function executeQuerySelectSingle($query){
  $db=openDBConnexion();
  try {
    $db->beginTransaction();
    $result = $db->query($query)->fetch();
    $db->commit();
    return $result;
  } catch (Exception $e) {
    $db->rollback();
    throw $e;
  }
}

/**
 * Execute a querry that return more than one value, in an assoc array
 * This function use transaction, for more safety, and rollback at any exceptions
 * @param     string $query The query to execute
 * @return    array The result of the query, as an associative array
 * @author    Alessandro Rossi w/ https://zetcode.com/php/pdo/ for the transaction part
 *
 */
function executeQuerySelectAssoc($query){
  $db=openDBConnexion();
  try {
    $db->beginTransaction();
    $data = $db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    $db->commit();
    return $data;
  } catch (Exception $e) {
    $db->rollback();
    throw $e;
  }
}
