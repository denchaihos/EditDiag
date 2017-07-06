<?php
// Start the session
//session_start();
//$_SESSION["vaccation_year"] = "59";
function unset_n_reset(&$arr, $key){
    unset($arr[$key]);
    $arr = array_merge($arr);
}
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

$vn = $_GET['vn'];
//$vn = 863114;
$data = array();
$sql = "SELECT pd.nameprscdt,pd.qty,m.doseprn1,m.doseprn2 from prsc p
join prscdt pd on pd.prscno=p.prscno
join medusage m on m.dosecode=pd.medusage
where vn='$vn' GROUP BY pd.prscno,pd.meditem,pd.medusage  ";
$data = array();

$result = mysql_query($sql, $con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['nameprscdt'] = $row['nameprscdt'];
    $row_array['qty'] = $row['qty'];
    $row_array['doseprn1'] = $row['doseprn1'];
    $row_array['doseprn2'] = $row['doseprn2'];

    array_push($data,$row_array);
}
echo json_encode($data);

exit;

