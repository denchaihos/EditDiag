<?
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");
$vn =$_GET['vn'];
$sql_cc = 'select symptom from symptm where vn="'.$row['vn'].'"  ';
$data = array();
$result = mysql_query($sql,$con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['cc'] = $row['symptom'];
    array_push($data,$row_array);   
}
echo json_encode($data);
exit;
?>