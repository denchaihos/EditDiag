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
    <script src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.bootpag.min.js"></script>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>BootPag - boostrap dynamic pagination jQuery plugin</title>
    <style type="text/css">
        p{
            text-align: center;
        }
    </style>

</head>
<body>
<div class="col-md-12" >

    <div class="col-md-12 table-curved" style="height: 420px;">
        <table class="table  col-md-10 table-hover" id="mytable">
            <?php
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
            ?>
            <tbody id="my_news">

            </tbody>

        </table>
    </div>
    <div class="col-md-2 ">

        <input type="text" class="form-control" placeholder="ค้นหาข่าว" name="Search" id="Search" value="" onkeyup="search_news()"  style="height: 25px;width:150px;font-size: 12px;margin-top: 15px">
    </div>


    <div class="col-md-10" >

        <p class="dem dem2"></p>
        <p class="content2">หน้าที่ 1</p>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        var row_per_page = 10;
        var total_row = new Array();
        $.getJSON('news_missive_data.php',{limit:0}, function(data) {
            $.each(data, function(key,value) {
                total_row.push(value.total_rows);
            });
            var numrow = (total_row[1]);
            $('.dem2').bootpag({
                total: Math.ceil(numrow/row_per_page),
                page: 1,
                maxVisible: 10
            })
            $.each(data, function(key,value) {
                $("tbody#my_news").append("<tr><td>"+value.numrecord+"</td><td><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.name_act+"</a></td><td></td><td><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.date_act+"</a></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>");

            });

            $('.dem2').on('page', function(event, num){
                var search = $('#Search').val();
                // alert(search);
                if(search == ''){
                    $(".content2").html("หน้าที่ " + num); // or some ajax content loading...
                    var limit = (num-1) * row_per_page;
                    $('tbody#my_news tr').remove();

                    $.getJSON('news_missive_data.php',{limit:limit}, function(data) {
                        $.each(data, function(key,value) {

                            $("tbody#my_news").append("<tr><td>"+value.numrecord+"</td><td class='col-md-10'><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.name_act+"</a></td><td class='col-md-2'><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.date_act+"</a></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
                        });
                    });

                };
                if(search != ''){
                    var limit = (num-1) * row_per_page;
                    $('tbody#my_news tr').remove();

                    $.getJSON('search_news.php',{search:search,limit:limit}, function(data) {
                        $.each(data, function(key,value) {

                            $("tbody#my_news").append("<tr><td>"+value.numrecord+"</td><td class='col-md-10'><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.name_act+"</a></td><td class='col-md-2'><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.date_act+"</a></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
                        });
                    });

                };

            });
        });

    });

    function search_news(){
        var search = $('#Search').val();
        if(search != ''){
            var  row_per_page = 5;
            var total_row = new Array();
            $.getJSON('search_news.php',{search:search,limit:0}, function(data) {
                $.each(data, function(key,value) {
                    total_row.push(value.total_rows);
                });
                var numrow = (total_row[1]);

                $('.dem2').bootpag({
                    total: Math.ceil(numrow/row_per_page),
                    page: 1,
                    maxVisible: 10
                })
                $('tbody#my_news tr').remove();
                $.each(data, function(key,value) {
                    $("tbody#my_news").append("<tr><td>"+value.numrecord+"</td><td class='col-md-10'><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.name_act+"</a></td><td class='col-md-2'><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.date_act+"</a></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
                });
            });
        }else{
            $('tbody#my_news tr').remove();
            $.getJSON('news_missive_data.php',{limit:0}, function(data) {
                $.each(data, function(key,value) {
                    $("tbody#my_news").append("<tr><td>"+value.numrecord+"</td><td class='col-md-10'><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.name_act+"</a></td><td class='col-md-2'><a class='cate2' href='news/news_detail.php?id_act="+value.id_act+"' target='_blank'>"+value.date_act+"</a></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>");
                });
            });
            var  row_per_page = 5;
            var total_row = new Array();
            $.getJSON('news_missive_data.php',{limit:0}, function(data) {
                $.each(data, function(key,value) {
                    total_row.push(value.total_rows);
                });
                var numrow = (total_row[1]);
                $('.dem2').bootpag({
                    total: Math.ceil(numrow/row_per_page),
                    page: 1,
                    maxVisible: 10
                })
            });
        }
    };


</script>
</body>
</html>