<?php
/**
 * Created by PhpStorm.
 * User: IT3
 * Date: 12/6/2557
 * Time: 13:36 น.
 */
?>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/jquery-migrate-1.0.0.js"></script>
    <!--<script type="text/javascript" src="js/jquery.min.js"></script>-->
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="fonts/font-awesome-4.1.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/datepicker.css">
    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.th.js" charset="UTF-8"></script>

    <link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

    <title>Patient Visit</title>
    <style type="text/css">
        p{
            text-align: center;
        }
        .dx{
            cursor: pointer;
        }
    </style>
    <script type="text/javascript">
        /*var ajaxSubmit = function(formEl) {

         if ($("#icd10").val() == '' ){
         $('#icd10').focus();
         alert("กรุณากรอกข้อมูลให้ครบ");
         } else {
         var url = $(formEl).attr('action');
         var data = $(formEl).serialize();
         $.ajax({
         type: "post",
         url: url,
         data: data,
         datatype: 'html',
         success: function(data){
         alert(data);
         //$.fancybox.close();
         //$("#flex1").flexReload();
         }
         })
         }
         return false;*/

        $(document).ready(function(){

        });
        //--------------SAVE-------------
        function btnSave_edit(){
            /*$.fancybox({'href'	: 'distribute_save.php',
             'transitionIn'  :   'elastic',
             'transitionOut' :   'elastic',
             'speedIn'    :  600,
             'speedOut'   :  200,
             'overlayShow'   :   false,
             onComplete : function() {
             $.fancybox.close();
             $("#flex1").focus();
             $("#flex1").flexReload();
             //$.flexigrid.flexReload();
             }
             });*/
        }
        //--------------Cancel-------------
        function btnCancel(){
            $.fancybox.close();
            $("#flex1").flexReload();
        }
        ///////////set icd10 name  to  input//////////
        function set_icd10name(){
            //alert('me');
            var icd10t = $('#icd10').val();
            var icd10 = icd10t.toUpperCase();
            $('#icd10').val(icd10);
            var len_icd10 = icd10.length;
            if(len_icd10>1){
                $.getJSON('pt_edit_dx_data.php',{icd10:icd10}, function(data) {
                    $.each(data, function(key,value){
                        //alert(value.icd10name);
                        $('#icd10name').val(value.icd10name);
                    });
                });
            };
        }
    </script>
</head>
<body>
<div style="background-color: #777">
    <div class="panel-heading" style="height: 50px" >
        <div class="col-lg-6">
            <form class="form-inline" role="form">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">วันที่รับบริการ</div>
                        <input type="text" class="datepicker form-control" name="visit_date"  id="visit_date" value="<?php if(isset($_POST['visit_date'])) echo $_POST['visit_date']; ?>" placeholder="visit_date"/>
                        <script language="JavaScript" >
                            $(document).ready(function() {
                                $('.datepicker').datepicker({
                                    format: 'dd-mm-yyyy',
                                    language: 'th',
                                    autoclose: true
                                })
                            })
                        </script>
                        <div class="input-group-addon"><i class="fa fa-calendar fa-1x"></i></div>
                    </div>

                </div>
                <div class="form-group">
                    <input type="button" class="btn btn-success custom" value="ค้นหา" name="submit" id="submit_date" onclick="search_by_date()" onsubmit="return false;">
                    <input type="button" class="btn btn-warning" value="ยกเลิก"/>
                </div>
            </form>
        </div>
        <div class="col-lg-4">
            <div class="input-group-addon"><p class="total"></p></div>
        </div>
        <div class="col-lg-2" style="text-align: right">
            <form class="form-inline" role="form">

                <div class="form-group">
                    <div class="input-group">

                        <input type="text" class="form-control" placeholder="ค้นหาจาก HN" name="hn" id="hn" value="" />
                        <div class="input-group-addon" onclick="search_by_hn()"><i class="fa fa-search fa-1x"></i></div>

                    </div>

                </div>


            </form>
        </div>
    </div>
</div>
<input type="hidden" name="change_dx" value="" id="change_dx"/>

<div class="col-md-12" >
    <p class="dem dem2" style="text-align: center"></p>
    <p class="content2"  style="text-align: center">หน้าที่ 1</p>
    <input type="hidden" name="curpage" id="curpage" value=""/>
    <div id="tes">

    </div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    $('#visit_date').focus();
    $(function(){
        var keyStop = {
            8: ":not(input:text, textarea, input:file, input:password)", // stop backspace = back
            13: "input:text, input:password", // stop enter = submit

            end: null
        };
        $(document).bind("keydown", function(event){
            var selector = keyStop[event.which];

            if(selector !== undefined && $(event.target).is(selector)) {
                event.preventDefault(); //stop event
            }
            return true;
        });
    });


    //function search_by_date() {
    $("input#submit_date").click(function(event){
        /* var dx = document.getElementsByName('te');
         var len_dx = dx.length;
         alert(len_dx);*/
        var row_per_page = 10;
        var visit_date = $('#visit_date').val();
        var total_row = new Array();
        $(".content2").html("หน้าที่ 1");
        $("#curpage").val(1);


        $.getJSON('tes_data.php',{visit_date:visit_date,limit:0}, function(data) {

            var i = 1;
            $.each(data, function(key,value) {
                $("#tes").append(""+value.hn+"<br/>");
                i++;
            });
            /////////////click dx  to  edit/////////////////////////////////
            var dx = $('td.dx');
            var len_dx = dx.length;
            //alert('me'+len_dx);
            $("td.dx").click(function(event){
                var id_dx =  this.id;
                var pdx = this.innerText;
                var this_td = this;
                //alert(pdx);
                $.fancybox({'href'	: 'pt_edit_dx_form.php?id_dx='+id_dx+'&&pdx='+pdx,
                    'width' : '70%',
                    'height' : '50%',
                    'transitionIn'  :   'elastic',
                    'transitionOut' :   'elastic',
                    'speedIn'    :  600,
                    'speedOut'   :  200,
                    'overlayShow'   :   false,
                    'closeBtn': true,
                    onComplete : function() {
                        //$('.dx').focus();
                        $("input#icd10").focus().select();

                    },
                    onClosed : function(){
                        //var change_dx = $("input#icd10").val();
                        //sessionStorage.setItem("change_dx", change_dx);
                        //alert(change_dx);
                        this_td.innerText = $('#change_dx').val();
                    }
                });
                ////  use ajax to sent  $_get  to  other page///////////////
                $.ajax({
                    type: "POST",
                    dataType: "html",
                    url: "pt_edit_dx_form.php",
                    data: id_dx

                });
            });
            /////////////// enc of  edit  dx/////////////////

        });


    });

});
/////////////end of ready function///////////////////////////////////////////
//----------------------Search  patient-----------------------------------
$(document).keyup(function (e) {
    if ($("#hn").is(":focus") && (e.keyCode == 13)) {
        search_by_hn();
    }
});




//////////////////////////


</script>
</body>
</html>