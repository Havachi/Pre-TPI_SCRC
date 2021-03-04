<?php
/**
 * This function will open a new connection with the database
 *
 * @return dbconnection The connection with the databases
 * @author Alessandro Rossi
 */
// TODO: remove Hardcoded database username and password (can't help you on how)
function openDBConnexion(){
    $TestConnectionData = array('hostname' => 'localhost' ,'username' => 'SCRCConnector', 'password' => 'Pa$$w0rd', 'dbname' => 'scrc' );
    $swisscenterConnectionData = array('hostname' => 'localhost' ,'username' => 'scrc21_Connector', 'password' => 'jQDarw2Csj!A2A^jytT+', 'dbname' => 'scrc21_SCRCDB' );

    if($GLOBALS['DEBUG_DB'] === true){
      $connectionData = $TestConnectionData;
    }else {
      $connectionData = $swisscenterConnectionData;
    }

    $hostname = $connectionData['hostname'];
    $userName = $connectionData['username'];
    $userPwd = $connectionData['password'];
    $dbname = $connectionData['dbname'];
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

/**
 * This function prepare a query, it is used only whenever userinput interact with DB
 *
 * @param string $query the query to prepare
 * @return PDO::Statement The statement used later in the process
 */
function prepareQuery($query){
  $db=openDBConnexion();
  $statement = $db->prepare($query);
  return $statement;
}
/**
 * This function execute the statement previously created, it is used only whenever userinput interact with DB
 *
 * @param PDO::Statement $query the statement to execute
 * @return mixed The results, can be anything really
 */
function executeStatement($statement,$values){
  $statement->execute($values);
  $result = $statement->fetchAll();
  return $result;
}
