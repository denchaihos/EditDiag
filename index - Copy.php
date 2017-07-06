<!DOCTYPE html>
<html>
<head>
    <title>Edit Diag</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="themes/blue/style.css" rel="stylesheet">
   <!-- <link href="css/tablesorter.css" rel="stylesheet">-->

    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.th.js"></script>

    <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
</head>
<style>
    .custom {
        width: 150px !important;
    }
    table.tablesorter tbody {
        font-family:tahoma, sans-serif;
        background-color: #CDCDCD;
        margin:10px 0pt 15px;
        font-size: 14px !important;
        width: 100%;
        text-align: left;
        border-radius:3px;
    }
    table.tablesorter thead tr th {
        font-family:tahoma, sans-serif;
        background-color: #e6EEEE;
        border: 1px solid #FFF;
        font-size: 15px !important;
        padding: 4px;
    }
</style>

<body>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#">ปรับปรุงรหัสวินิจฉัยโรค</a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="nav-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form pull-right">
                    <input class="span2" type="text" placeholder="Username">
                    <input class="span2" type="password" placeholder="Password">
                    <button type="submit" class="btn">Sign in</button>
                </form>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>
</br>
</br>
</br>

<div class="container">
    <form method="post" name="visit">
    <div class="row">
        <div class="form-group span8">
            <div class="span2 btn btn-success custom">วันที่รับบริการ</div>
                    <input type="text" class="datepicker form-control" name="visit_date" id="visit_date" value="<?php if(isset($_POST['visit_date'])) echo $_POST['visit_date']; ?>" placeholder="visit_date"/>
            <script language="JavaScript" >
                $('.datepicker').datepicker({
                    format: 'dd-mm-yyyy',
                    language: 'th'
                })
            </script>
        </div>
        <div class="span2"><input type="submit" class="btn btn-success custom" value="ค้นหา" name="submit"></div>
        <div class="span2"><a href="index.php" target="_self"><input type="button" class="btn btn-warning" value="ยกเลิก"/></a></div>
    </div>
    <div class="row">
        รายชื่อผู้มารับบริการในช่วงเวลาที่เลือก
        <br/>
        <?php
        //echo $_POST['visit_date'];
        //echo '<br/>';
        $visit_date = substr($_POST['visit_date'],-4)."-".substr($_POST['visit_date'],3,2)."-".substr($_POST['visit_date'],0,2);
        //echo $visit_date;
            if( isset($_POST['visit_date']) ){

                include 'connect.php';
                echo '<table id="myTable" class="table table-hover table-striped tablesorter" >';
                  echo '<thead class="mysize">';
                    echo '<tr>';
                        echo '<th style="text-align: center">ลำดับ</th>';
                        echo '<th >ชื่อสกุล</th>';
                        echo '<th>HN</th>';
                        echo '<th>วันที่รับบริการ</th>';
                        echo '<th>pdx</th>';
                        echo '<th>dx2</th>';
                        echo '<th>dx3</th>';
                        echo '<th>dx4</th>';
                        echo '<th>dx5</th>';
                        echo '<th>dx6</th>';
                    echo '</tr>';
                  echo '</thead>';

                    //loop show hosmain
                  echo '<tbody>';
                    $sql = 'select concat(p.fname," ",p.lname) as ptname,o.hn,o.vstdttm,od.icd10,od.cnt,o.vn from ovst o left outer join ovstdx od on od.vn=o.vn
                left outer join pt p on p.hn=o.hn
                where date( o.vstdttm) ="'.$visit_date.'" and od.cnt="1" order by o.vstdttm limit 10 ';
                    $result = mysql_query($sql);
                    $i = 1;
                    while($obj = mysql_fetch_object($result)){
                        echo '<tr>';
                            echo '<td style="text-align: center">'.$i.'</td>';
                            echo '<td>'.$obj->ptname.'</td>';
                            echo '<td>'.$obj->hn.'</td>';
                            echo '<td>'.$obj->vstdttm.'</td>';
                            echo '<td>'.$obj->icd10.'</td>';
                            $sql_subdx = 'select id,icd10 as subdx from ovstdx where vn="'.$obj->vn.'" and cnt = 0 limit 5';
                            $result_subdx = mysql_query($sql_subdx);
                            $numrow_subdx = mysql_num_rows($result_subdx);
                            while($obj = mysql_fetch_object($result_subdx)){
                                    echo '<td>'.$obj->subdx.'</td>';
                                }
                            if($numrow_subdx < 5){
                                for($k=1; $k<=5-$numrow_subdx; $k++) {
                                    echo '<td></td>';
                                }
                            }
                        echo '</tr>';
                        $i++;
                    }
                  echo '</tbody>';
                echo '</table>';
            }
        ?>
    </div>
    </form>
</div>
<script language="JavaScript" >
    $(document).ready(function()
        {
            $("#myTable").tablesorter();
        }
    );
</script>
</body>
</html>