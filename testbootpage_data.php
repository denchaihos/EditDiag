<?
/*
$host ="localhost";
$uname="sn";
$passwd="sn";
$dbname="snhos";
$con = mysql_connect($host,$uname,$passwd);
If (!$con) {
	echo "<h3> error  :  can not connect database</h3>";
	exit();
}
mysql_query("set character_set_results=tis620");
mysql_query("set character_set_connection=tis620");
mysql_query("set character_set_client=tis620");
*/
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

//$totalrow = array();
$sql_numrow = "SELECT count(vn) as totalrow  FROM  ovst where date(vstdttm)='2014-10-02' ";
$result_numrow = mysql_query($sql_numrow);
$numrow = mysql_fetch_array($result_numrow);
//$row_array['totalrow'] = $numrow['totalrow'];
//array_push($totalrow,$row_array);
//echo json_encode($totalrow);

$limit = $_GET['limit'];

//$limit = $limit * 4;
$data = array();

while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {

    $row_array['total_rows'] = $numrow['totalrow'];


    array_push($data,$row_array);

}

//$data['rows'] = $row_array;
//echo json_encode($data);
echo json_encode($data);
exit;



?>