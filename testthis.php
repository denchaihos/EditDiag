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
    <script type="text/javascript">
        $(document).ready(function(){

            /*var dx = document.getElementsByName('te');
            var len_dx = dx.length;
            alert(len_dx);
            for(var i = 1; i <= len_dx; i += 1){
                $(".me"+i).click(function(event){
                    var m =  this.id;
                    alert(m);
                })
            }*/
            var dx = $('td.dx');
            var len_dx = dx.length;
            alert(len_dx);
            for(var i = 1; i <= len_dx; i += 1){
                $("table tr td").click(function(event){
                    var m =  this.id;
                    alert(m);
                });
            };
        })


        function edit_dx(){
           // var selected_tab = $(this).id;
            //alert(selected_tab);

        }


    </script>
</head>
<body>

<p><a href="connect.php">connet</a> </p>
<input type="text" value="11" name="te" class="me1" onclick="edit_dx()" id="1"/>
<input type="text" value="22" name="te" class="me2" onclick="edit_dx()" id="2"/>
<input type="submit" value="aaa" id="aa" "/>
<button name="m" value="ok" id="12"/>
<table border="1"><tr>
        <td class="dx" id="1">dx</td><td></td>
        <td class="dx" id="2">dx</td>
</tr></table>

</body>
</html>