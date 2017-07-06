
<!DOCTYPE html>
<html>
<head>
    <title>Edit Diag</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    <!-- Bootstrap -->


    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="themes/blue/style.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/my.css" rel="stylesheet">
    <!-- <link href="css/tablesorter.css" rel="stylesheet">-->
    <!-- CSS -->
    <link rel="stylesheet" href="js/alertifyjs/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/bootstrap.min.css"/>

    <!--
        RTL version
    -->
    <link rel="stylesheet" href="js/alertifyjs/css/alertify.rtl.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/default.rtl.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/semantic.rtl.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/bootstrap.rtl.min.css"/>
    <link rel="stylesheet" href="js/jquery-ui/jquery-ui.min.css"/>


    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/alertifyjs/alertify.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.th.js" charset="UTF-8"></script>
    <script language="javascript" type="text/javascript" src="js/jquery-ui/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
    <script src="js/main.js" type="text/javascript"></script>

</head>
<style>
    .custom {
        width: 150px !important;
    }

    table.tablesorter tbody {
        font-family: tahoma, sans-serif;
        background-color: #CDCDCD;
        margin: 10px 0pt 15px;
        font-size: 14px !important;
        width: 100%;
        text-align: left;
        border-radius: 3px;
    }

    table.tablesorter thead tr th {
        font-family: tahoma, sans-serif;
        background-color: #e6EEEE;
        border: 1px solid #FFF;
        font-size: 15px !important;
        padding: 4px;
    }
</style>

<body>
<div id="loadingScreen"></div>

<nav class="navbar navbar-default navbar-inverse" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
                <span id="project_name" style="margin-right: 40px">
                                <i class="fa fa-users"></i>  ระบบจัดการการวินิจฉัยโรค
                            </span>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">ระบบ <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="index.php?vaccation_main">******</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">ตั้งค่าระบบ <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">ตั้งปีงบประมาณ</a></li>
                        <li><a href="index.php?officer">เพิ่มเจ้าหน้าที่</a></li>
                        <li><a href="index.php?vaccation_rule">****</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">รายงาน <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>


            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                $a = 1;
                if (!$a == 1) {
                    echo "<li><button class='btn btn-info'>ผู้ใช้งา</button></li>";
                    echo "<li><button class='btn btn-warning' onclick='logout()'><i class='fa fa-sign-out'></i>log off</button></li>";
                } else {
                    ?>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b>Login</b> <span
                                class="caret"></span></a>
                        <ul id="login-dp" class="dropdown-menu">
                            <li>
                                <div class="row">
                                    <div class="col-md-12">
                                        Login via
                                        <div class="social-buttons">
                                            <a href="#" class="btn btn-fb"><i class="fa fa-facebook"></i> Facebook</a>
                                            <a href="#" class="btn btn-tw"><i class="fa fa-twitter"></i> Twitter</a>
                                        </div>
                                        or
                                        <form class="form" role="form" method="post" action="login"
                                              accept-charset="UTF-8" id="login-nav">
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                                                <input type="email" class="form-control" id="exampleInputEmail2"
                                                       placeholder="Email address" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword2">Password</label>
                                                <input type="password" class="form-control" id="exampleInputPassword2"
                                                       placeholder="Password" required>

                                                <div class="help-block text-right"><a href="">Forget the password ?</a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox"> keep me logged-in
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="bottom text-center">
                                        New here ? <a href="#"><b>Join Us</b></a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <li>
                    <a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a>

                    <a href="#"><i class="fa fa-linkedin"></i></a>
                    <a href="#"><i class="fa fa-dribbble"></i></a>
                </li>
                <!--
                                <li>
                                    <div class="search">
                                        <form role="form">
                                            <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                            <i class="fa fa-search"></i>
                                        </form>
                                    </div>
                                </li>
                -->

            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>


<?php
include 'pt_visit.php';
?>

<script language="JavaScript">
    $(document).ready(function () {
            $("#myTable").tablesorter();
        }
    );
</script>
<script src="function/index.js"></script>
</body>
</html>