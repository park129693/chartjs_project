<?php

include "db_conn.php";

$output='';

$sql = "select * from lm_insp_regu_area order by dc_cd desc limit 10";

$statement = connPlatonDB() -> prepare($sql);

$statement -> execute();

$output .= ' <table class="table">
                <thead>
                    <tr>
                        <th> 센터코드 </th>
                        <th> 구역코드 </th>
                        <th> 구역명 </th>
                        <th> 사용구분 </th>
                        <th> 물류센터코드 </th>
                        <th> 비고 </th>
                        <th> 등록자 </th>
                        <th> 등록일 </th>
                    </tr>
                </thead>';

if($statement -> rowCount() > 0) {

    while($row = $statement -> fetch(PDO::FETCH_ASSOC)) {

        $output .= '
                <tbody>
                    <tr>
                        <td>'.$row["dc_cd"].'</td>
                        <td>'.$row["area_cd"].'</td>
                        <td>'.$row["area_nm"].'</td>
                        <td>'.$row["use_yn"].'</td>
                        <td>'.$row["dct_cd"].'</td>
                        <td>'.$row["rmk"].'</td>
                        <td>'.$row["reg_user"].'</td>
                        <td>'.$row["reg_dt"].'</td>
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


