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
    <link rel="stylesheet" href="css/jquery-ui.css"/>
    <script src="js/jquery-1.11.0.min.js"></script>

    <script type="text/javascript" src="js/jquery-blockUI.js"></script>

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

        // unblock when ajax activity stops
        $(document).ajaxStop($.unblockUI);

        function test() {
            $.ajax({ url: 'wait.php', cache: false });
        }

        $(document).ready(function() {
            $('#submit_date').click(function() {
                $.blockUI();
                test();
            });
            $('#pageDemo2').click(function() {
                $.blockUI({ message: '<h1><img src="busy.gif" /> Just a moment...</h1>' });
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

    </script>
</head>
<body>
<input type="button" class="btn btn-success custom" value="ค้นหา" name="submit" id="submit_date">
</body>
</html>