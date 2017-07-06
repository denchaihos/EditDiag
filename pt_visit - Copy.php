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
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
    <script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
    <script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>

    <title>BootPag - boostrap dynamic pagination jQuery plugin</title>
    <style type="text/css">
        p{
            text-align: center;
        }
    </style>
    <script type="text/javascript">
        function edit_dx(){
            $.fancybox({'href'	: 'pt_edit_dx_form.php',
            'transitionIn'  :   'elastic',
            'transitionOut' :   'elastic',
            'speedIn'    :  600,
            'speedOut'   :  200,
            'overlayShow'   :   false,
                closeBtn: 'true',
            onComplete : function() {
            $('#txtwasadu_name').focus();
            },
            onClosed : function(){
               // $('#flex1').focus();
               // $("#flex1").flexReload();
                parent.location.reload();
            }
            });
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "distribute_detail_form.php",
                data: distribute_id

            });

        }
        //--------------SAVE-------------
        function btnSave(){
            $.fancybox({'href'	: 'distribute_save.php',
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
            });

        }
        //--------------Cancel-------------
        function btnCancel(){
            $.fancybox({'href'	: 'distribute_cancel.php',
                'transitionIn'  :   'elastic',
                'transitionOut' :   'elastic',
                'speedIn'    :  600,
                'speedOut'   :  200,
                'overlayShow'   :   false,
                onComplete : function() {
                    $.fancybox.close();
                    $("#flex1").flexReload();

                }

            });

        }
    </script>
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

        <input type="text" class="form-control" placeholder="ค้นหาข่าว" name="Search" id="Search" value=""  style="height: 25px;width:150px;font-size: 12px;margin-top: 15px"/>
        <input type="text" class="form-control" placeholder="date_dx" name="date_dx" id="date_dx" value=""  style="height: 25px;width:150px;font-size: 12px;margin-top: 15px"/>
        <input type="button" value="ok"/>

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
        $.getJSON('pt_visit_data.php',{limit:0}, function(data) {
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
                $("tbody#my_news").append("<tr><td>"+value.numrecord+"</td>" +
                    "<td>"+value.ptname+"</td>" +
                    "<td>"+value.hn+"</td>" +
                    "<td>"+value.vstdttm+"</td>" +
                    "<td onclick='edit_dx()'>"+value.pdx+"</td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "<td></td>" +
                    "</tr>"
				);
            });

            $('.dem2').on('page', function(event, num){
                var search = $('#Search').val();
                // alert(search);
                if(search == ''){
                    $(".content2").html("หน้าที่ " + num); // or some ajax content loading...
                    var limit = (num-1) * row_per_page;
                    $('tbody#my_news tr').remove();

                    $.getJSON('pt_visit_data.php',{limit:limit}, function(data) {
                        $.each(data, function(key,value) {
							  $("tbody#my_news").append("<tr><td>"+value.numrecord+"</td>" +
							"<td>"+value.ptname+"</td>" +
							"<td>"+value.hn+"</td>" +
							"<td>"+value.vstdttm+"</td>" +
							"<td onclick='edit_dx()'>"+value.pdx+"</td>" +
							"<td></td>" +
							"<td></td>" +
							"<td></td>" +
							"<td></td>" +
							"<td></td>" +
							"</tr>"
						);
                    });
                });

            };
                /*if(search != ''){
                    var limit = (num-1) * row_per_page;
                    $('tbody#my_news tr').remove();

                    $.getJSON('search_news.php',{search:search,limit:limit}, function(data) {
                        $.each(data, function(key,value) {
							$("tbody#my_news").append("<tr><td>"+value.numrecord+"</td>" +
								"<td>"+value.ptname+"</td>" +
								"<td>"+value.hn+"</td>" +
								"<td>"+value.vstdttm+"</td>" +
								"<td onclick='edit_dx()'>"+value.pdx+"</td>" +
								"<td></td>" +
								"<td></td>" +
								"<td></td>" +
								"<td></td>" +
								"<td></td>" +
								"</tr>"
							);
                        });
                    });

                };*/

            });
        });

    });
    $(document).keyup(function (e) {
        if ($("#Search").is(":focus") && (e.keyCode == 13)) {
            search_pt();
        }
    });


    function search_pt(){
        var search = $('#Search').val();

		//alert(search);
        if(search != ''){
            //var  row_per_page = 5;
            var total_row = new Array();
            $.getJSON('search_news.php',{search:search,limit:0}, function(data) {
               /* $.each(data, function(key,value) {
                    total_row.push(value.total_rows);
                });
                var numrow = (total_row[1]);*/

                $('.dem2').bootpag({
                    total: 1,
                    page: 1,
                    maxVisible: 1
                })
                $('tbody#my_news tr').remove();
                $.each(data, function(key,value) {
                    $("tbody#my_news").append("<tr><td>"+value.numrecord+"</td>" +
								"<td>"+value.ptname+"</td>" +
								"<td>"+value.hn+"</td>" +
								"<td>"+value.vstdttm+"</td>" +
								"<td onclick='edit_dx()'>"+value.pdx+"</td>" +
								"<td></td>" +
								"<td></td>" +
								"<td></td>" +
								"<td></td>" +
								"<td></td>" +
								"</tr>"
							);
                });
            });
        }else{
            $('tbody#my_news tr').remove();
            $.getJSON('pt_visit_data.php',{limit:0}, function(data) {
                $.each(data, function(key,value) {
                    $("tbody#my_news").append("<tr><td>"+value.numrecord+"</td>" +
                        "<td>"+value.ptname+"</td>" +
                        "<td>"+value.hn+"</td>" +
                        "<td>"+value.vstdttm+"</td>" +
                        "<td onclick='edit_dx()'>"+value.pdx+"</td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "<td></td>" +
                        "</tr>"
                    );
                });
            });
            var  row_per_page = 5;
            var total_row = new Array();
            $.getJSON('pt_visit_data.php',{limit:0}, function(data) {
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