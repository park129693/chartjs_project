<?php

include 'db_conn.php';

session_start();

$email = $_SESSION['email'];
// $email = 'kim@naver.com';

$sql_query = "select * from wrsr where email='$email' order by no desc limit 11";

$coulumn_query = "DESC wrsr";


$statement = connCSVDB() -> prepare($sql_query);

$statement -> execute();

$query_data = $statement -> fetchAll(PDO::FETCH_CLASS);

// $data = array();

// if(!empty($query_data)){
//     foreach($query_data as $row) {
//         $data[] = $row;
//     }
// } 

$statement = connCSVDB() -> prepare($coulumn_query);

$statement -> execute();

$column_name = array();


while ( $coulumn_query_data = $statement -> fetch()) {

    $column_name[] = $coulumn_query_data[0];

}

print json_encode(array($query_data, $column_name));



// while ($query_data = $statement -> fetchAll()){
//     $data[] = $query_data;
// }


?>

