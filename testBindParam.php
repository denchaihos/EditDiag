<?php

$HOST_NAME = "127.0.0.1";
$DB_NAME = "hi";
$CHAR_SET = "charset=utf8"; // เช็ตให้ใช้ภาษาไทยได้

$USERNAME = "root";     // ตั้งค่าตามการใช้งานจริง
$PASSWORD = "123456";  // ตั้งค่าตามการใช้งานจริง


$id = !empty($_GET['id']) ? $_GET['id'] : $_GET['reportId'];
$startDate = !empty($_GET['startDate']) ? $_GET['startDate'] : "";
$endDate = !empty($_GET['endDate']) ? $_GET['endDate'] : "";
?>
<form name="myform" action="" method="get">
    <input type="hidden" name="reportId" value="<?echo $id ?>">
    <span>startDate: <input type="text" name="startDate" placeholder="2015-10-01" value="<? echo $startDate ?>"></span>
    <span>endDate: <input type="text" name="endDate" placeholder="2015-10-01" value="<? echo $endDate ?>"></span>
    <input type="submit" name="submit" value="submit">
</form>
<?php

if(isset($_GET['startDate'])){
    $id = $_GET['reportId'];
    try {

        $db = new PDO('mysql:host='.$HOST_NAME.';dbname='.$DB_NAME.';'.$CHAR_SET,$USERNAME,$PASSWORD);

        // ดึงเอาคำสั่ง SQL  ออกมาก่อน
        $report_query ="SELECT * FROM tsuReport WHERE id=$id";
        //$sql = "SELECT hn,fname,lname FROM pt WHERE hn = :hn";
        $sql = $db->prepare($report_query);
        $sql->execute();
        $sql = $sql->fetch();
        $sql = $sql['r_query'];
        //echo $sql;



        //  column  head
        $ps = $db->prepare($sql);
        $start_date = $startDate;
        $end_date = $endDate;
        $ps->bindParam(1, $start_date, PDO::PARAM_STR);
        $ps->bindParam(2, $end_date, PDO::PARAM_STR);
        $ps->execute();
        $total_column = $ps->columnCount();
        //print_r($total_column);

        for ($counter = 0; $counter < $total_column; $counter ++) {
            $meta = $ps->getColumnMeta($counter);
            $column[] = $meta['name'];
        }

        echo "<table border='1'>";
        echo "<thead>";
        echo "<tr>";
        for ($x = 0; $x < $total_column; $x++) {
            echo "<td>";
            echo $column[$x];
            echo "</td>";
        }
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while ($row = $ps->fetch())  {
            echo "<tr>";
            for ($x = 0; $x < $total_column; $x++) {
                echo "<td>";
                echo $row[$column[$x]];
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";



    } catch (PDOException $e) {

        echo "ไม่สามารถเชื่อมต่อฐานข้อมูลได้ : ".$e->getMessage();

    }
}
?>