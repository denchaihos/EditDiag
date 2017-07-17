<?
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$icd10 = $_GET['icd10'];
$cln = $_GET['cln'];
/*$icd10 = "K08.1";
$cln = "40100";*/


$data = array();
if($cln=='40100'){
    $sql ='select codeicdda as icd10,nameicdda as icd10name from icdda where codeicdda  = "'.$icd10.'"';
}else{
    $sql ='select icd10,icd10name from icd101 where accpdx="T" and icd10 = "'.$icd10.'"';
}
$result = mysql_query($sql,$con);
$numrow = mysql_num_rows($result);
if ($numrow>0){
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
        $row_array['icd10'] = $row['icd10'];
        $row_array['icd10name'] = $row['icd10name'];
        array_push($data,$row_array);
    }
}else{
    $row_array['icd10'] = 'ICD10 is not valid';
    $row_array['icd10name'] ='ICD10 is not valid';
    array_push($data,$row_array);
}
echo json_encode($data);

exit;
?>