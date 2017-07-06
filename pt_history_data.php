<?
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");
//$vstdttm =$_GET['vstdttm'];
//$hn = $_GET['hn'];
$vn = $_GET['vn'];
 $sql ="select o.*,od.id as id_dx,time(o.vstdttm) as vstdttm,concat(od.icd10,':',i.icd10name) as pdx,od.cnt from ovst o "
         . " left outer join ovstdx od on od.vn=o.vn   "
         . " left outer join icd101 i on i.icd10=od.icd10   "
         . " where o.vn = '$vn'  and od.cnt=1 order by o.vstdttm desc ";
$data = array();
$result = mysql_query($sql,$con);
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['bw'] = $row['bw'];
    $row_array['height'] = $row['height'];
    $row_array['waist_cm'] = $row['waist_cm'];
    $row_array['bmi'] = $row['bmi'];
    $row_array['tt'] = $row['tt'];
    $row_array['pr'] = $row['pr'];
    $row_array['rr'] = $row['rr'];
    $row_array['sbp'] = $row['sbp'];
    $row_array['dbp'] = $row['dbp'];
    //cc////////
    $sql_cc = 'select symptom from symptm where vn="'.$row['vn'].'"  ';
    $result_cc = mysql_query($sql_cc);
    $row_array['cc'] = "-";
    while($row_cc = mysql_fetch_array($result_cc,MYSQL_ASSOC)){
             $row_array['cc'] = $row_array['cc'].$row_cc['symptom'];     
    };
    //  add illness history  table sing//////
    $sql_pi = 'select pillness from pillness where vn="'.$row['vn'].'"  ';
    $result_pi = mysql_query($sql_pi);
    $row_array['pi'] = "-";
    while($row_pi = mysql_fetch_array($result_pi,MYSQL_ASSOC)){
        $row_array['pi'] = $row_array['pi'].$row_pi['pillness'];
    };
     //  add PE  doctor//////
    $sql_pe = 'select sign from sign where vn="'.$row['vn'].'"  ';
    $result_pe = mysql_query($sql_pe);
    $row_array['pe'] = "-";
    while($row_pe = mysql_fetch_array($result_pe,MYSQL_ASSOC)){
        $row_array['pe'] = $row_array['pe'].':::>>'.$row_pe['sign'];
    };
    $row_array['pdx'] = $row['pdx'];
    // add other dx///
    $sql_subdx = "select o.id,concat(o.icd10,':'  ,i.icd10name) as subdx "
            . " from  ovstdx o left outer join icd101  i on i.icd10=o.icd10 "
            . " where o.vn=".$row['vn']." and o.cnt = 0 ";
    $result_subdx = mysql_query($sql_subdx);
    $numrow_subdx = mysql_num_rows($result_subdx);
    $j = 1;
    while($row_subdx = mysql_fetch_array($result_subdx, MYSQL_ASSOC)){
        //$row_array['id'.$j] = $row_subdx['id'];
        $row_array['dx'.$j] = $row_subdx['subdx'];
        $j++;

    };
    if($numrow_subdx < 5){
        for($k=$numrow_subdx+1; $k<=5; $k++) {
            $row_array['id'.$k] = '';
            $row_array['dx'.$k] = '';
        }
    }
    array_push($data,$row_array);   
}
echo json_encode($data);
exit;
?>