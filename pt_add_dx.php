<?php
/**
 * Created by PhpStorm.980459
 * User: User
 * Date: 25/10/2557
 * Time: 20:46 น.
 */
include 'connect.php';
if($_POST['visit_type']=="O"){
    if($_POST['cln'] =='40100'){
        $dx_count = "select count(d.vn) as cc from dt d join dtdx dx on dx.dn=d.cn where d.vn='$_POST[vn]'";
    }else{
        $dx_count = "select count(vn) as cc from ovstdx where vn='$_POST[vn]'";
    }
    $result = mysql_query($dx_count,$con);
    $obj = mysql_fetch_object($result);
    $count_row = $obj->cc;
    //$num_post = count($_POST);
    $num_post = $_POST['numAdd'];
   // echo "numPost".$num_post;

    if($count_row > 0){
        for($j=0;$j<($num_post);$j++){
            if(isset($_POST['icd_'.$j.''])){
                $icd = $_POST['icd_'.$j.''];
            }
            if(isset($_POST['icdname_'.$j.''])){
                $icdname = $_POST['icdname_'.$j.''];
            }
            if($_POST['cln'] =='40100'){

            }else{
                $sql =  "INSERT INTO ovstdx (vn,icd10,icd10name,cnt) values ('$_POST[vn]','$icd','$icdname','0') ";
            }
            mysql_query($sql);

        }
        echo "SAVE COMPLETE OPD";
    }else{
        if(isset($_POST['icd_0'])){
            $icd = $_POST['icd_0'];
            $icdname = $_POST['icdname_0'];
        }
        $sql =  "INSERT INTO ovstdx (vn,icd10,icd10name,cnt) values ('$_POST[vn]','$icd','$icdname','1') ";
        mysql_query($sql);

        for($j=1;$j<=($num_post/2)-1;$j++){
            if(isset($_POST['icd_'.$j.''])){
                $icd = $_POST['icd_'.$j.''];
            }
            if(isset($_POST['icdname_'.$j.''])){
                $icdname = $_POST['icdname_'.$j.''];
            }

            $sql =  "INSERT INTO ovstdx (vn,icd10,icd10name,cnt) values ('$_POST[vn]','$icd','$icdname','0') ";
            mysql_query($sql);

        }
        echo "SAVE COMPLETE OPD";

    }
}else{
        //IPD///
    $dx_count = "SELECT i.an,ix.id,IFNULL(ix.itemno,'') as itemno,IFNULL(ix.dct,o.dct) as dct,ix.icd10,ix.icd10name from ipt i LEFT OUTER JOIN iptdx ix on ix.an=i.an JOIN ovst o on o.vn=i.vn where i.vn='$_POST[vn]'";
    $result = mysql_query($dx_count,$con);
    $count_row = mysql_num_rows($result);
    $obj = mysql_fetch_object($result);
    $an = $obj->an;
    $dct =$obj->dct;
    $itemno = $obj->itemno;
    //$num_post = count($_POST);
    $num_post = $_POST['numAdd'];
    // echo "numPost".$num_post;

    if($itemno == 1){
        for($j=0;$j<($num_post);$j++){
            if(isset($_POST['icd_'.$j.''])){
                $icd = $_POST['icd_'.$j.''];
            }
            if(isset($_POST['icdname_'.$j.''])){
                $icdname = $_POST['icdname_'.$j.''];
            }
            $sql =  "INSERT INTO iptdx (an,itemno,dct,icd10) values ('$an','0','$dct','$icd') ";
            mysql_query($sql);

        }
        echo "SAVE COMPLETE IPD";
    }else{
        if(isset($_POST['icd_0'])){
            $icd = $_POST['icd_0'];
            $icdname = $_POST['icdname_0'];
        }
        $sql =  "INSERT INTO iptdx (an,itemno,dct,icd10) values ('$an','1','$dct','$icd') ";
        mysql_query($sql);

        for($j=1;$j<=$num_post-1;$j++){
            if(isset($_POST['icd_'.$j.''])){
                $icd = $_POST['icd_'.$j.''];
            }
            if(isset($_POST['icdname_'.$j.''])){
                $icdname = $_POST['icdname_'.$j.''];
            }
            $sql =  "INSERT INTO iptdx (an,itemno,dct,icd10) values ('$an','2','$dct','$icd') ";
            mysql_query($sql);

        }
        echo "SAVE COMPLETE IPD";

    }



}



mysql_close($con);


?>