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
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.bootpag.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>
    <script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
    <script src="js/wow.min.js" type="text/javascript"></script>

    <!-- <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="fonts/font-awesome-4.1.0/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="css/datepicker.css">
    <link href="js/fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css"  media="screen" />

    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.th.js" charset="UTF-8"></script>
    <script  src="js/fancybox/jquery.mousewheel-3.0.4.pack.js" type="text/javascript"></script>
    <script src="js/fancybox/jquery.fancybox-1.3.4.pack.js" type="text/javascript" ></script>
    <script src="js/jquery-blockUI.js" type="text/javascript" ></script>

    <title>Patient Visit</title>
    <style type="text/css">
        p{
            text-align: center;
        }
        .dx,.dx_all{
            cursor: pointer;
            text-align: center;
        }
        .show_pointer{
            cursor: pointer;
        }
        table { border-collapse: separate;
            font-size: 14px;
        }
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
        #cc{
            width: 30%;
            overflow: visible;
            font-size: 12px;
        }
        #pi{
            display: none;
            overflow: visible;
            font-size: 12px;
            color: blue;
        }
        #show_pi{
            color: red;
            text-align: right;
            font-size: 12px;
            cursor: pointer;
        }
        .show_hn_an{
            display: none;
        }
        #department{
            overflow: visible;
            font-size: 12px;
        }



    </style>
    <script type="text/javascript">


    </script>
</head>
<body>
    <div style="background-color: #777;margin-top: -25px">
        <div class="panel-heading has-success" style="height: 50px" >

            <div class="col-lg-8">
                <form class="form-inline" role="form" onsubmit="return false;">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">วันที่รับบริการ/DC</div>
                            <input type="text" class="datepicker form-control show_pointer" name="visit_date"  id="visit_date" value="<?php if(isset($_POST['visit_date'])) echo $_POST['visit_date']; ?>" placeholder="visit_date"/>
                            <script language="JavaScript" >
                                $(document).ready(function() {
                                    $('.datepicker').datepicker({
                                        format: 'dd-mm-yyyy',
                                        language: 'th',
                                        autoclose: true

                                    })
                                })
                            </script>
                            <div class="input-group-addon show_pointer" id="calendar" onclick="calendar();"><i class="fa fa-calendar fa-1x"></i></div>

                        </div>

                    </div>
                    <div class="input-group">
                        <span class="input-group-addon ">
                            <input type="radio" name="visit_type" id="visit_type" class="show_pointer" value="O"  checked>
                        </span>
                        <div class="input-group-addon">ผู้ป่วยนอก</div>
                        <span class="input-group-addon ">
                            <input type="radio" name="visit_type" id="visit_type"  class="show_pointer" value="I">
                        </span>
                        <div class="input-group-addon">ผู้ป่วยใน</div>
                    </div><!-- /input-group -->
                    <div class="form-group has-success">
                        <input type="button" class="btn btn-success custom" value="ค้นหา" name="submit" id="submit_date" onclick="search_by_date()" onsubmit="return false;">
                        <input type="button" class="btn btn-warning" value="ยกเลิก"/>
                    </div>
                </form>
            </div>

            <div class="col-lg-4" style="text-align: right">
                <form class="form-inline" role="form">

                    <div class="form-group">
                        <div class="input-group">

                            <input type="text" class="form-control show_pointer" placeholder="ค้นหาด้วย HN" name="hn" id="hn" value="" />
                            <div class="input-group-addon show_pointer" onclick="search_by_hn()"><i class="fa fa-search fa-1x"></i></div>


                        </div>

                    </div>
                    <div class="input-group">
                        <span class="input-group-addon ">
                        <label>
                            <input type="checkbox" value="" id="assign_date" onclick="notAssign_date()">
                        ไม่ระบุวันที่
                        </label>
                            </span>
                    </div>



                </form>
            </div>
        </div>
    </div>
    <input type="hidden" name="change_dx" value="" id="change_dx"/>
    <div class="col-lg-12" >
        <div class="col-md-12 table-curved">
            <table class="table  col-md-10 table-hover table-striped" id="mytable">
                <?php
                echo '<thead class="mythead">';
                echo '<tr>';
                echo '<th class="mythead">ลำดับ</th>';
                echo '<th >ชื่อสกุล</th>';
                echo '<th>HN</th>';
                echo '<th>AN</th>';
                echo '<th>เวลารับบริการ</th>';
                echo '<th>แผนก</th>';
                echo '<th>CC</th>';
                echo '<th></th>';
                echo '<th class="mythead">pdx</th>';
                echo '<th class="mythead">dx2</th>';
                echo '<th class="mythead">dx3</th>';
                echo '<th class="mythead">dx4</th>';
                echo '<th class="mythead">dx5</th>';
                echo '<th class="mythead">dx6</th>';
                //echo '<th style="text-align: center;cursor:zoom-out"><span></span></th>';
                echo '<th style="text-align: center;cursor:zoom-out"></th>';
                echo '<th style="text-align: center;cursor:zoom-out"></th>';
                echo '</tr>';
                echo '</thead>';
                ?>
                <tbody id="my_news">

                </tbody>
            </table>

        </div>
    </div>
    <div class="col-md-12" >
        <div id="dem" class="dem dem2" style="text-align: center"></div>
        <div class="content2"  style="text-align: center"></div>
        <div class="input-group-addon"><p class="total"></p></div>
        <input type="hidden" name="curpage" id="curpage" value=""/>
    </div>

    <script type="text/javascript" src="function/pt_visit.js"></script>
    <script src="function/pt_history_form.js"></script>

</body>
</html>