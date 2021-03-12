<?php
require "../models/BetterDBConnection.php";

$db = new DBConnection();

$query = "SELECT userID FROM users";


$test1 = $db->single($query);
?>

<?php
    function build_table($array){
    $html = '<table>';
    $html .= '<tr>';
    foreach($array[0] as $key=>$value){
            $html .= '<th>' . htmlspecialchars($key) . '</th>';
        }
    $html .= '</tr>';
    foreach( $array as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
}
var_dump($test1);
//echo build_table($test1);

?>
