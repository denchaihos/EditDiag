<?php
$host = "localhost";
$uname = "root";
$passwd = "123456";
$dbname = "suhos";
//$con = mysql_connect($host,$uname,$passwd);
$con_suhos = mysql_connect('localhost', 'root', '123456');
If (!$con_suhos) {
    echo "<h3> error  :  Can not coonect databse</h3>";
    exit();
}
//echo "success";
mysql_select_db("suhos");
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");
?>