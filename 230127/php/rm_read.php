<?php

include 'db_conn.php';

session_start();

$email = $_SESSION['email'];

$sql_query = "select date_format(입고일자, '%Y-%m') 월별입고량, sum(입고수량) 총입고수량 FROM rm where email ='$email' group by 월별입고량";

$statement = connCSVDB() -> prepare($sql_query);

$statement -> execute();

$query_data = $statement -> fetchAll(PDO::FETCH_CLASS);

$R_temp = "select sum(입고수량) 상온 from rm where 온도대='상온'";

$statement = connCSVDB() -> prepare($R_temp);

$statement -> execute();

$R_temp = $statement -> fetchAll(PDO::FETCH_CLASS);

$Ref = "select sum(입고수량) 냉장 from rm where 온도대='냉장'";

$statement = connCSVDB() -> prepare($Ref);

$statement -> execute();

$Ref = $statement -> fetchAll(PDO::FETCH_CLASS);

$fz = "select sum(입고수량) 냉동 from rm where 온도대='냉동'";

$statement = connCSVDB() -> prepare($fz);

$statement -> execute();

$fz = $statement -> fetchAll(PDO::FETCH_CLASS);

$temp = array_merge($R_temp, $Ref, $fz);

echo json_encode(array($query_data, $temp));


// $coulumn_query = "DESC rm";

// $statement = connCSVDB() -> prepare($coulumn_query);

// $statement -> execute();

// $column_name = array();


// while ( $coulumn_query_data = $statement -> fetch()) {

//     $column_name[] = $coulumn_query_data[0];

// }
?>