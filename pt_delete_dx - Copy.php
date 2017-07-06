<?php
/**
 * Created by PhpStorm.980459
 * User: User
 * Date: 25/10/2557
 * Time: 20:46 น.
 */
include 'connect.php';
echo $_POST[id_dx];
echo "<br/>";
echo $_POST[icd10];
echo "<br/>";

$sql = "select * from ovstdx where  id = ".$_POST[id_dx]."";
$result = mysql_query($sql,$con);
$obj = mysql_fetch_object($result);


$sqlinsert = "insert into ovstdx_original_dx (id,vn,icd10,icd10name,cnt,date_update,flag_status) values ('$obj->id','$obj->vn','$obj->icd10','$obj->icd10name','$obj->cnt',now(),'de')";
mysql_query($sqlinsert);

/////////////////

$sql =  "delete from ovstdx  where id = ".$_POST[id_dx]."";
mysql_query($sql);

////////////////////////
$len_id = strlen($_POST[id_dx]);
//echo $_POST[id_dx];
//echo "<br/>";
//echo $_POST[icd10];
$id_dx = substr($_POST[id_dx],2,$len_id);
$id_type =  substr($_POST[id_dx],0,2);
$vn = $_POST[id_dx];
$icd10 = $_POST[icd10];
$icd10name = $_POST[icd10name];
//echo $icd10_old;
//echo "<br/>";
if($_POST[visit_type]=="O"){
    if($_POST[icd10_old]=="null"){
        $sqlinsert = "insert into ovstdx(vn,icd10,icd10name,cnt) values ('$vn','$icd10','$icd10name','1')";
        mysql_query($sqlinsert);

    }else{
        if($id_type != "vn"){
            $sql = "select * from ovstdx where  id = ".$_POST[id_dx]."";
            $result = mysql_query($sql,$con);
            $obj = mysql_fetch_object($result);
            $sqlinsert = "insert into ovstdx_original_dx (id,vn,icd10,icd10name,cnt,date_update,flag_status) values ('$obj->id','$obj->vn','$obj->icd10','$obj->icd10name','$obj->cnt',now(),'up')";
            mysql_query($sqlinsert);
            $sql =  "update ovstdx set icd10 = '".$_POST[icd10]."',icd10name = '".$_POST[icd10name]."' where id = ".$_POST[id_dx]."";
            mysql_query($sql);

        }else{

            $sql =  "update ovstdx set icd10 = '".$_POST[icd10]."',icd10name = '".$_POST[icd10name]."' where vn = ".$_POST[id_dx]." and icd10  = '".$_POST[icd10]."' ";
            mysql_query($sqlinsert);
        }
    }

}else{
    $sql = "select * from iptdx where  id = ".$_POST[id_dx]."";
    $result = mysql_query($sql,$con);
    $obj = mysql_fetch_object($result);
    $sqlinsert = "insert into iptdx_original_dx (id,an,itemno,dct,icd10,icd10name,spclty,date_update,flag_status) values ('$obj->id','$obj->an','$obj->itemno','$obj->dct','$obj->icd10','$obj->icd10name','$obj->spclty',now(),'up')";
    mysql_query($sqlinsert);
    $sql =  "update iptdx set icd10 = '".$_POST[icd10]."',icd10name = '".$_POST[icd10name]."' where id = ".$_POST[id_dx]."";
    mysql_query($sql);
}

mysql_close($con);
echo "<br/>";
echo "SAVE COMPLETE";
?>