<head>
    <script src="js/jquery-1.11.0.min.js"></script>
    <script>

        function check_index(){

            /*var dx = $('input#test');

            var len_dx = dx.length;


            alert(len_dx);*/
            $('ol#data').append('<li><input type="text" name="icd"/><input type="text" name="icdname"/></li>');

        }
    </script>
</head>
<body>


<input id="test" type="text" name="" />
<input id="test" type="text"  name="" />
<input type="button" name="ch" value="check" onclick="check_index()"/>
<ol id="data">
</ol>
<br/>



</body>