<?
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$dx = $_GET['dx'];
//$txt = "A415";


$data = array();
$sql ='select icd10,icd10name from icd101 where accpdx="T" and icd10 = "'.$dx.'"';
$result = mysql_query($sql,$con);

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $row_array['icd10'] = $row['icd10'];
    $row_array['icd10name'] = $row['icd10name'];

    array_push($data,$row_array);

}
echo json_encode($data);
exit;
?>