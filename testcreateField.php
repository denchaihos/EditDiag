<?php
$conn = mysql_connect('localhost', 'root', '123456');
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('hi');
$result = mysql_query('select p.hn,p.fname,p.lname,m.namemale from pt p join male m on m.male=p.male limit 100');
if (!$result) {
    die('Query failed: ' . mysql_error());
}

$i = 0;
$dataField = array();
while ($i < mysql_num_fields($result)) {
    $meta = mysql_fetch_field($result, $i);
    array_push($dataField,$meta->name);
    $i++;
}

$length_field = count($dataField);

echo "<table border='1'>";
echo "<thead>";
echo "<tr>";
for ($x = 0; $x < $length_field; $x++) {
    echo "<td>";
    echo $dataField[$x];
    echo "</td>";
}
echo "</tr>";
echo "</thead>";
echo "<tbody>";
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "<tr>";
    for ($x = 0; $x < $length_field; $x++) {
        echo "<td>";
        echo $row[$dataField[$x]];
        echo "</td>";
    }
    echo "</tr>";

}
echo "</tbody>";

echo "</table>";

mysql_free_result($result);


?>