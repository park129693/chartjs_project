<?php

include 'db_conn.php';

ob_start();

// $db_host='localhost';
// $db_port='3306';
// $db_user='user0';
// $db_password='1234';
// $db_database='csv';

session_start();


// $pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=csv", $db_user, $db_password);

$uploaddir = '/var/www/html/files';

var_dump($_FILES["uploadfile"]["name"]);

    $allowed_extension = array('csv');
    $file_array = explode(".", $_FILES["uploadfile"]["name"]);
    $extension = end($file_array);

    if(in_array($extension, $allowed_extension)) {
      $new_file_name = rand() . '.' . $extension;

      $_SESSION['csv_file_name'] = $new_file_name;

      move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "$uploaddir/$new_file_name");
      $file_content = file("$uploaddir/$new_file_name", FILE_SKIP_EMPTY_LINES);
    }

set_time_limit(0);
ob_implicit_flush(1);

$email = $_SESSION['email'];
$handle = fopen('/var/www/html/files/' . $_SESSION['csv_file_name'], "r");

fgetcsv($handle);

    while (($data = fgetcsv($handle)) !== false) {
        
	$enc_Year = $data[0];
	$enc_Wearing = $data[1];
	$enc_Release = $data[2];
	$enc_Stock = $data[3];
	$enc_Return = $data[4];
	$enc_gf_Wearing = $data[5];
	$enc_gf_Release = $data[6];
	$enc_gf_Stock = $data[7];
	$enc_gf_Return = $data[8];
	$email;

	$sql = "insert into wrsr (
            enc_Year,
            enc_Wearing,
            enc_Release,
            enc_Stock,
            enc_Return,
            enc_gf_Wearing,
            enc_gf_Release,
            enc_gf_Stock,
            enc_gf_Return,
            email 
         )";

        $sql = $sql. "values (
            '$enc_Year',
            '$enc_Wearing',
            '$enc_Release',
            '$enc_Stock',
            '$enc_Return',
            '$enc_gf_Wearing',
            '$enc_gf_Release',
            '$enc_gf_Stock',
	        '$enc_gf_Return',
	        '$email'
         )";


        $statement = connCSVDB() -> prepare($sql);

        $statement -> execute($data);

        if( opendir($uploaddir) ){
            @unlink("$uploaddir/" . $_SESSION['csv_file_name'] );
        }

        unset($_SESSION['csv_file_name']);
    }

header('Location: /index.html')

?>
