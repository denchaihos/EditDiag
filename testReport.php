<?php

$HOST_NAME = "127.0.0.1";
$DB_NAME = "hi";
$CHAR_SET = "charset=utf8"; // เช็ตให้ใช้ภาษาไทยได้

$USERNAME = "root";     // ตั้งค่าตามการใช้งานจริง
$PASSWORD = "123456";  // ตั้งค่าตามการใช้งานจริง


try {

    $db = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);
    $report_query ="SELECT * FROM tsuReport";
    $sql = $db->prepare($report_query);
    $sql->execute();
    //$sql = $sql->fetch();
    echo "<table border='1'>";
    echo "<thead>";
    echo "<tr>";
    echo "<td>ชื่อรายงาน</td>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    while ($row = $sql->fetch())  {
        echo "<tr>";

            echo "<td>";
            echo "<a href='testBindParam.php?id=$row[id]' target='_blank'>".$row['namereport']."</a>";
            echo "</td>";

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";



}catch (PDOException $e) {

    echo "ไม่สามารถเชื่อมต่อฐานข้อมูลได้ : ".$e->getMessage();

}

?>
