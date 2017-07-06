<?php
$conn = mysql_connect('localhost', 'root', '123456');
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('hi');
$result = mysql_query('select hn,fname from pt limit 100');
if (!$result) {
    die('Query failed: ' . mysql_error());
}
/* get column metadata */
$i = 0;
$dataField = array();
while ($i < mysql_num_fields($result)) {
    echo "Information for column $i:<br />\n";
    $meta = mysql_fetch_field($result, $i);
    if (!$meta) {
        echo "No information available<br />\n";
    }
    /*echo "<pre>
blob:         $meta->blob
max_length:   $meta->max_length
multiple_key: $meta->multiple_key
name:         $meta->name
not_null:     $meta->not_null
numeric:      $meta->numeric
primary_key:  $meta->primary_key
table:        $meta->table
type:         $meta->type
unique_key:   $meta->unique_key
unsigned:     $meta->unsigned
zerofill:     $meta->zerofill
</pre>";*/
    array_push($dataField,$meta->name);
    $i++;
}
mysql_free_result($result);

print_r($dataField);
?>