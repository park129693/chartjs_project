<?php

include "db_conn.php";

$output='';

$sql = "select * from lm_beacon_stat order by dc_cd desc limit 10";

$statement = connPlatonDB() -> prepare($sql);

$statement -> execute();

$output .= ' <table class="table">
                <thead>
                    <tr>
                        <th> NO </th>
                        <th> 비콘ID </th>
                        <th> 비콘 명 </th>
                        <th> 층 </th>
                        <th> X </th>
                        <th> Y </th>
                        <th> UID </th>
                        <th> 베터리량 </th>
                        <th> 교환일 </th>
                        <th> 잔량 </th>
                    </tr>
                </thead>';

if($statement -> rowCount() > 0) {

    while($row = $statement -> fetch(PDO::FETCH_ASSOC)) {

        $output .= '
                <tbody>
                    <tr>
                        <td>'.$row["dc_cd"].'</td>
                        <td>'.$row["beacon_id"].'</td>
                        <td>'.$row["rssi"].'</td>
                        <td>'.$row["floor"].'</td>
                        <td>'.$row["x"].'</td>
                        <td>'.$row["y"].'</td>
                        <td>'.$row["uid"].'</td>
                        <td>'.$row["batt_cap"].'</td>
                        <td>'.$row["reg_dt"].'</td>
                        <td>'.$row["rssi"].'</td>
                    </tr>
                </tbody>';  

    }

} else {
    
    $output .= '
        <tr >
            <td>fail</td>      
        </tr>';

}

    $output .= '</table>';

echo $output;


?>


