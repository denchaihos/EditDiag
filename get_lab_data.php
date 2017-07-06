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
//$vn = 740778;

$sql = "SELECT lb.labcode,lb.ln,l.dbf,CONCAT(l.dbf,l.dbfs) as tableResult FROM lbbk lb JOIN lab l on l.labcode=lb.labcode WHERE vn ='$vn' ";
$data = array();

$result = mysql_query($sql, $con);
$x = 0;
while ($row = mysql_fetch_row($result)) {
    $tables =  "".$row[3]."";
    $tables_array = (explode(",",$tables));
    foreach($tables_array as $tablesLab){

        // $row_array[] = $tablesLab;
        $query = "select * from ".strtolower($tablesLab)." where ln=".$row[1];
        $result2 = mysql_query($query);
        $row2 = mysql_fetch_row($result2);
        //array_shift($row2);
        //$row2 = array_merge($row2);
        $i = 1;
        while ($i < mysql_num_fields($result2)){
            $fld = mysql_fetch_field($result2, $i);
            array_push($row,$fld->name." = ".$row2[$i]);

            $i = $i + 1;


        }

        //array_push($row,$i);

        //echo "table :".$tablesLab."<br>";
    }

    array_push($data, $row);


    $x++;


}
//for($m = 0;$m<$x;$m++){
//unset_n_reset($data[$m],4);
//}

//$data=array_merge($data);
echo json_encode($data);

exit;

