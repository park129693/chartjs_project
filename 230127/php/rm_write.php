<?php

include 'db_conn.php';

session_start();
ob_start();

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
        $입고일자 = $data[0];
        $발주번호 = $data[1];
        $거래처코드 = $data[2];
        $거래처명 = $data[3];
        $물류센터코드 = $data[4];
        $물류센터명 = $data[5];
        $품목코드 = $data[6];
        $품목명 = $data[7];
        $온도대 = $data[8];
        $입고수량 = $data[9];
        $단위 = $data[10];
        $email;

        $sql = "insert into rm (
                입고일자,
                발주번호,
                거래처코드,
                거래처명,
                물류센터코드,
                물류센터명,
                품목코드,
                품목명,
                온도대,
                입고수량,
                단위,
                email 
                )";

            $sql = $sql. "values (
                '$입고일자',
                '$발주번호',
                '$거래처코드',
                '$거래처명',
                '$물류센터코드',
                '$물류센터명',
                '$품목코드',
                '$품목명',
                '$온도대',
                '$입고수량',
                '$단위',
                '$email'
                )";

        $statement = connCSVDB() -> prepare($sql);

        $statement -> execute();

        if( opendir($uploaddir) ){
            @unlink("$uploaddir/" . $_SESSION['csv_file_name'] );
        }

        unset($_SESSION['csv_file_name']);
    }

header('Location: /index.html')

?>
