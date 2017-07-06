<?
include "connect.php";
mysql_query("set character_set_results=utf8");
mysql_query("set character_set_connection=utf8");
mysql_query("set character_set_client=utf8");

    $visit_date = substr($_GET['visit_date'],-4)."-".substr($_GET['visit_date'],3,2)."-".substr($_GET['visit_date'],0,2);

$limit = $_GET['limit'];
$hn = $_GET['hn'];


$data = array();

    if($_GET['visit_date'] == ''){
        $sql ='select od.id as id_dx,concat(p.fname," ",p.lname) as ptname,o.hn,o.an,date(o.vstdttm) as datevisit,o.vstdttm as vstdttm,c.dspname as department,od.icd10,od.cnt,o.vn from ovst o left outer join ovstdx od on od.vn=o.vn and od.cnt="1"
                left outer join pt p on p.hn=o.hn  LEFT OUTER JOIN cln c on c.cln=o.cln
                where o.hn="'.$hn.'"  order by o.vstdttm desc  ';

    }else{
        $sql ='select od.id as id_dx,concat(p.fname," ",p.lname) as ptname,o.hn,o.an,date(o.vstdttm) as datevisit,vstdttm as vstdttm,c.dspname as department,od.icd10,od.cnt,o.vn from ovst o left outer join ovstdx od on od.vn=o.vn and od.cnt="1"
                left outer join pt p on p.hn=o.hn  LEFT OUTER JOIN cln c on c.cln=o.cln
                where o.hn="'.$hn.'" and date(o.vstdttm)="'.$visit_date.'"   order by o.vstdttm desc ';
    }


$result = mysql_query($sql,$con);
$i = 1;
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['numrecord'] = $i ;
    $row_array['id_dx'] = $row['id_dx'];
    $row_array['vn'] = $row['vn'];
    $row_array['hn'] = $row['hn'];
    $row_array['an'] = $row['an'];
    $row_array['ptname'] = $row['ptname'];
    $row_array['datevisit'] = $row['datevisit'];
    $row_array['vstdttm'] = $row['vstdttm'];
    $row_array['department'] = $row['department'];
    //  add cc//////
    $sql_cc = 'select symptom from symptm where vn="'.$row['vn'].'"  ';
    $result_cc = mysql_query($sql_cc);
    $row_array['cc'] = "";
    while($row_cc = mysql_fetch_array($result_cc,MYSQL_ASSOC)){
        $row_array['cc'] = $row_array['cc'].$row_cc['symptom'];
    };
    //  add PI//////
    $sql_pi = 'select pillness from pillness where vn="'.$row['vn'].'"  ';
    $result_pi = mysql_query($sql_pi);
    $row_array['pi'] = "";
    while($row_pi = mysql_fetch_array($result_pi,MYSQL_ASSOC)){
        $row_array['pi'] = $row_array['pi'].$row_cc['pillness'];
    };
    $row_array['pdx'] = $row['icd10'];
    // add other dx///

        $sql_subdx = 'select id,icd10 as subdx from ovstdx where vn="'.$row['vn'].'" and cnt = 0 ';
        $result_subdx = mysql_query($sql_subdx);
        $numrow_subdx = mysql_num_rows($result_subdx);
        $j = 1;
        while($row_subdx = mysql_fetch_array($result_subdx, MYSQL_ASSOC)){
            $row_array['id'.$j] = $row_subdx['id'];
            $row_array['dx'.$j] = $row_subdx['subdx'];
            $j++;

        };

    if($numrow_subdx < 5){
        for($k=$numrow_subdx+1; $k<=5; $k++) {
            $row_array['id'.$k] = '';
            $row_array['dx'.$k] = '';
        }
    }
    //$row_array['total_rows'] = $numrow['totalrow'];
    array_push($data,$row_array);
    $i++;
}


/////////////IPD/////////////////

$sql = 'select idx.id as id_dx,concat(p.fname," ",p.lname) as ptname,i.hn,i.an,i.dchdate as datevisit,i.dchtime as vstdttm,idx.icd10,idx.itemno as cnt,i.vn
    from ipt i left outer join iptdx idx  on idx.an=i.an left outer join pt p on p.hn=i.hn   where i.an="'.$hn.'"  and idx.itemno="1"  ';


$result = mysql_query($sql,$con);
$i = 1;
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $row_array['numrecord'] = $i ;
    $row_array['id_dx'] = $row['id_dx'];
    $row_array['vn'] = $row['vn'];
    $row_array['hn'] = $row['hn'];
    $row_array['an'] = $row['an'];
    $row_array['ptname'] = $row['ptname'];
    $row_array['datevisit'] = $row['datevisit'];
    $row_array['vstdttm'] = $row['vstdttm'];
    $row_array['department'] = $row['department'];
    //  add cc//////
    $sql_cc = 'select symptom from symptm where vn="'.$row['vn'].'"  ';
    $result_cc = mysql_query($sql_cc);
    $row_array['cc'] = "";
    while($row_cc = mysql_fetch_array($result_cc,MYSQL_ASSOC)){
        $row_array['cc'] = $row_array['cc'].$row_cc['symptom'];
    };
    //  add PI//////
    $sql_pi = 'select pillness from pillness where vn="'.$row['vn'].'"  ';
    $result_pi = mysql_query($sql_pi);
    $row_array['pi'] = "";
    while($row_pi = mysql_fetch_array($result_pi,MYSQL_ASSOC)){
        $row_array['pi'] = $row_array['pi'].$row_cc['pillness'];
    };
    $row_array['pdx'] = $row['icd10'];
    // add other dx///


        $sql_subdx = 'select id,icd10 as subdx from iptdx where an="'.$row['an'].'" and itemno = 2 ';
        $result_subdx = mysql_query($sql_subdx);
        $numrow_subdx = mysql_num_rows($result_subdx);
        $j = 1;
        while($row_subdx = mysql_fetch_array($result_subdx, MYSQL_ASSOC)){
            $row_array['id'.$j] = $row_subdx['id'];
            $row_array['dx'.$j] = $row_subdx['subdx'];
            $j++;

        };


    if($numrow_subdx < 5){
        for($k=$numrow_subdx+1; $k<=5; $k++) {
            $row_array['id'.$k] = '';
            $row_array['dx'.$k] = '';
        }
    }
    //$row_array['total_rows'] = $numrow['totalrow'];
    array_push($data,$row_array);
    $i++;
}




echo json_encode($data);
exit;
?>