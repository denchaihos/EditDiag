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
           
            //height: 150px;
            background-color: #e0e0e0;
            padding: 5px;
            //margin: auto;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
             var newheight = $(window).height() - 100;
 var newHeightStr = newheight + 'px';
           document.getElementById('me').style.height=newHeightStr;
            //alert ('me');
        });
    </script>
</head>
<body>

    <div id="me" class="baackgroud_me col-lg-12">
    รหัสวินิจฉัย
    
</div>
</body>
</html>