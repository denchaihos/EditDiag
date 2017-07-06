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
    <script type="text/javascript" src="js/jquery-blockUI.js"></script>

    <title>Patient Visit</title>
    <style type="text/css">
        p{
            text-align: center;
        }
        .dx,.dx_all{
            cursor: pointer;
            text-align: center;
        }
        table { border-collapse: separate; }
        td.dx:hover,td.dx_all:hover{
            background-color:rgb(214,214,214) !important;
            /* border-radius:4px;*/
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
            border:1px solid red;
            overflow:auto;
            color:red;
        }
        .mythead{
            text-align: center;
        }
    </style>
    <script type="text/javascript">

        // unblock when ajax activity stops
        $(document).ajaxStop($.unblockUI);

        function test() {
            $.ajax({ url: 'wait.php', cache: false });
        }

        $(document).ready(function() {
            $('#submit_date1').click(function() {
                $.blockUI();
                test();
            });
            $('#submit_date').click(function() {
                alert('me');
                $.blockUI({ message: '<h1><img src="img/busy.gif" /> Just a moment...</h1>' });
                test();
            });
            $('.dem2').click(function() {
                $.blockUI({ message: '<h1><img src="img/busy.gif" /> Just a moment...</h1>' });
                test();
            });
            $('#pageDemo3').click(function() {
                $.blockUI({ css: { backgroundColor: '#f00', color: '#fff' } });
                test();
            });

            $('#pageDemo4').click(function() {
                $.blockUI({ message: $('#domMessage') });
                test();
            });
        });
        //--------------Cancel-------------
        function btnCancel(){
            $.fancybox.close();
            //$("#flex1").flexReload();
        }
        ///////////set icd10 name  to  input//////////

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
<div class="col-lg-12" >

    <div class="col-md-12 table-curved" style="height: 420px;">
        <table class="table  col-md-10 table-hover table-striped" id="mytable">
            <?php
            echo '<thead class="mythead">';
            echo '<tr>';
            echo '<th class="mythead">ลำดับ</th>';
            echo '<th >ชื่อสกุล</th>';
            echo '<th >HN</th>';
            echo '<th>วันที่รับบริการ</th>';
            echo '<th class="mythead">pdx</th>';
            echo '<th class="mythead">dx2</th>';
            echo '<th class="mythead">dx3</th>';
            echo '<th class="mythead">dx4</th>';
            echo '<th class="mythead">dx5</th>';
            echo '<th class="mythead">dx6</th>';
            echo '<th style="text-align: center;cursor:zoom-out"><span></span></th>';
            echo '<th style="text-align: center;cursor:zoom-out"></th>';
            echo '</tr>';
            echo '</thead>';
            ?>
            <tbody id="my_news">

            </tbody>
        </table>
        <div id="img_progress" style="margin: auto"></div>
    </div>
</div>
<div class="col-md-12" >
    <p class="dem dem2" style="text-align: center"></p>
    <p class="content2"  style="text-align: center">หน้าที่ 1</p>
    <input type="hidden" name="curpage" id="curpage" value=""/>
</div>


</body>
</html>