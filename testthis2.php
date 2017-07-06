<!DOCTYPE html>
<html>
<head>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>-->

    <!--<script src="js/jquery-1.11.0.min.js" type="text/javascript"></script>-->
    <!--<script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>-->
    <!--<script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>-->
    <!--<script src="js/jquery-latest.js" type="text/javascript"></script>-->
    <!--<script src="js/jquery-2.0.0.min.js" type="text/javascript"></script>-->
    <script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
<script>
$(document).ready(function(){
    $('body').on('click', '#parentElement', function(){
   // $("#my").html(result);
   alert('me');
});
});
</script>
</head>
<body>

<p>This is a paragraph.</p>

<button id="parentElement">Click me!</button>
<br><br>

<div><b>Note:</b> The live() method was deprecated in jQuery version 1.7, and removed in version 1.9. We have used an earlier version of jQuery (1.7 in the script tag), for this example to work.</div> 

</body>
</html>
