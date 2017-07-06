<?php
/**
 * Created by PhpStorm.980459
 * User: User
 * Date: 25/10/2557
 * Time: 20:46 น.
 */
include 'connect.php';
/*
if(isset($_POST[icd10_3])){
echo $_POST[icd10_1];
}else{
    echo "no";
}*/
//echo $_POST[id_dx_1];

echo "<br/>";
$count_post = $_POST[count_post]-1;
echo $count_post;

$sql = "select * from ovstdx where  vn = ".$_POST[vn]."";
$result = mysql_query($sql,$con);
while($obj = mysql_fetch_object($result)){
$sqlinsert = "insert into ovstdx_original_dx (id,vn,icd10,icd10name,cnt) values ('$obj->id','$obj->vn','$obj->icd10','$obj->icd10name','$obj->cnt')";
mysql_query($sqlinsert);
}

/////////////////

for($j=1;$j<=$count_post;$j++){
$sql =  "update ovstdx set icd10 = '".$_POST[icd10_.$j]."',icd10name = '".$_POST[icd10name_.$j]."' where id = ".$_POST[id_dx_.$j]."";
mysql_query($sql);
}


mysql_close($con);
echo "<br/>";
echo "SAVE COMPLETE";
?>