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
        $sql ="select o.cln,o.vn,
  CASE o.cln WHEN '40100' THEN
            (
                SELECT dx.id FROM dt d JOIN dtdx dx ON dx.dn=d.dn WHERE d.vn=o.vn LIMIT 1
            )
            ELSE IF(od.id IS NULL ,'',od.id)
            END AS id_dx,concat(p.fname,'  ',p.lname) as ptname,
            o.hn,o.an,date(o.vstdttm) as datevisit,o.vstdttm as vstdttm,
            c.dspname as department,
            CASE o.cln WHEN '40100' THEN
                (
                    SELECT dx.icdda FROM dt d JOIN dtdx dx ON dx.dn=d.dn WHERE d.vn=o.vn LIMIT 1
                )
                ELSE IF(od.icd10 IS NULL,'',od.icd10)
            END AS icd10,
            od.cnt
            from ovst o left outer join ovstdx od on od.vn=o.vn and od.cnt='1'
            left outer join pt p on p.hn=o.hn
            LEFT OUTER JOIN cln c on c.cln=o.cln
            WHERE o.hn=".$hn."
            group by o.vn order by o.vstdttm desc ";

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
    $row_array['cln'] = $row['cln'];
    $row_array['vn'] = $row['vn'];
    $row_array['hn'] = $row['hn'];
    $row_array['an'] = $row['an'];
    $row_array['ptname'] = $row['ptname'];
    $row_array['datevisit'] = $row['datevisit'];
    $row_array['vstdttm'] = $row['vstdttm'];
    $row_array['department'] = $row['department'];

    if($row['cln']=='40100'){
        // cc dental//
        $sql_cc = 'SELECT s.symptom FROM dt d JOIN symp_d s ON s.dn=d.dn WHERE d.vn="'.$row['vn'].'"  ';
        $result_cc = mysql_query($sql_cc);
        $row_array['cc'] = "";
        while($row_cc = mysql_fetch_array($result_cc,MYSQL_ASSOC)){
            $row_array['cc'] = $row_array['cc'].$row_cc['symptom'];
        }
    }else{
        // cc opd//
        $sql_cc = ' select symptom from symptm where vn="'.$row['vn'].'"  ';
        $result_cc = mysql_query($sql_cc);
        $row_array['cc'] = "";
        while($row_cc = mysql_fetch_array($result_cc,MYSQL_ASSOC)){
            $row_array['cc'] = $row_array['cc'].$row_cc['symptom'];
        }
    }

    //  add PI//////
    $sql_pi = 'select pillness from pillness where vn="'.$row['vn'].'"  ';
    $result_pi = mysql_query($sql_pi);
    $row_array['pi'] = "";
    while($row_pi = mysql_fetch_array($result_pi,MYSQL_ASSOC)){
        $row_array['pi'] = $row_array['pi'].$row_cc['pillness'];
    };
    $row_array['pdx'] = $row['icd10'];
    // add other dx///
    if($row['cln']=='40100'){
        $sql_subdx = "SELECT dx.id,dx.icdda as subdx from dt d JOIN dtdx dx on dx.dn=d.dn where vn=".$row['vn']."  ORDER BY id limit 1,5 ";
    }else{
        $sql_subdx = 'select id,icd10 as subdx from ovstdx where vn="'.$row['vn'].'" and cnt = 0 ';
    }
    //$sql_subdx = 'select id,icd10 as subdx from ovstdx where vn="'.$row['vn'].'" and cnt = 0 ';
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