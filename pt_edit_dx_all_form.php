<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21/10/2557
 * Time: 10:33 น.
 */
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Diag</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap -->
    <!--<link rel="stylesheet" href="css/bootstrap.min.css">-->
    <style type="text/css">
        .baackgroud_me{
            width: 1000px;
            height: 300px;
            background-color: #e0e0e0;
            padding: 5px;
            margin: auto;
        }
        #dx_box{
            height: 220px;
        }
        #del_dx{
            cursor: pointer;
        }
    </style>
    <script type="text/javascript">

        function save_dx(){
            document.getElementById("edit_dx").action="pt_edit_all_dx.php";
        }
        function delete_dx(){
            document.getElementById("edit_dx").action="pt_delete_dx.php";
            $("#icd10").val('');
        }
        var ajaxSubmit = function(formEl) {
            if ($("#icd10name").val() == 'ICD10 is not valid' ){
                $('#icd10').focus();
                alert("รหัส ICD10 ไม่ถูกต้อง");
            } else {
                //document.getElementById("edit_dx").action="pt_delete_dx.php";
                var url = $(formEl).attr('action');
                var data = $(formEl).serialize();
                $.ajax({
                    type: "post",
                    url: url,
                    data: data,
                    datatype: 'html',
                    success: function(data){
                        //alert(data);
                        alert('save  complete');
                        var change_dx = $("#icd10").val();
                        $('#change_dx').val(change_dx);//send value  to  mother page
                        $.fancybox.close();
                        //$("#flex1").flexReload();
                    }
                })
            }
            return false;
        }
    </script>
</head>
<body>
<?
$id_dx = $_GET['id_dx'];
$dx = $_GET['pdx'];
//echo $id_dx;
include 'connect.php';
$sql ='select o.*,i.icd10name from ovstdx o left outer join icd101 i on i.icd10=o.icd10 where o.vn="'.$id_dx.'" order by o.cnt desc';
$result = mysql_query($sql,$con);
?>
<div class="baackgroud_me col-lg-12">
    รหัสวินิจฉัยdkfj;akdfjdkf
    <br/>
    <form name="edit_dx" id="edit_dx"  method="post"  onsubmit="return ajaxSubmit(this)">
        <div id="dx_box">
        <?
        $i_icd = 1;
        while($obj = mysql_fetch_object($result)){
        ?>

                <input type="text" name="vn" value="<? echo $id_dx; ?>"/>
                <input type="text" name="id_dx_<? echo $i_icd; ?>" value="<? echo $obj->id; ?>"/>
                <input type="text"  id="icd10"  name="icd10_<? echo $i_icd; ?>" size="5" value="<? echo $obj->icd10; ?>" onkeyup="set_icd10name()"/>
                <input type="text" name="icd10name_<? echo $i_icd; ?>" id="icd10name"  size="100" value="<?  echo $obj->icd10name; ?>"/>

            <?
            if($obj->cnt == 0){
            ?>
                <i class="fa fa-cut fa-lg" id="del_dx"></i>
            <?

            }
            ?>

                <br/>

        <?
            $i_icd++;
        }
        ?>
            <input type="text" name="count_post" value="<? echo $i_icd ?>"/>
        </div>
            <div class="form-group">
                <input type="submit" id="submit_save" class="btn btn-success custom" value="บันทึก" name="submit_save" onclick="save_dx()"/>
                <input type="submit" id="submit_delete" class="btn btn-primary" value="ลบ DX"  name="submit_delete" onclick="delete_dx()" <? if($cnt==1) echo 'disabled'; ?> />
                <input type="button" class="btn btn-warning" value="ยกเลิก" onclick="btnCancel()"/>
            </div>

    </form>
</div>
</body>
</html>