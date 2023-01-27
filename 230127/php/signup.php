<?php

include 'db_conn.php';

// $db_host='localhost';
// $db_port='3306';
// $db_user='user0';
// $db_password='1234';

// $pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=user", $db_user, $db_password);

// $email = json_decode(file_get_contents('php://input'))->{"email"};
// $username = json_decode(file_get_contents('php://input'))->{"username"};
// $password = json_decode(file_get_contents('php://input'))->{"password"};


$email = $_POST["email"];
$username = $_POST["username"];
$password = $_POST["password"];

$encryp = password_hash($password, PASSWORD_DEFAULT);

if ( $username == "" || $email == "" || $password == "" ) {

    $error = "Error";
    
    header('Location: /signup.html');

} else {
    
    $email_sql = "SELECT * FROM members WHERE email='$email'";

    $statement = connUSERDB() -> prepare($email_sql);

    $statement -> execute();
    
    $email_check = $statement -> fetch();
    
    if ( $email_check[0] == $email ) {

        $error = "exist email";

        header('Location: /signup.html');
        
    } else {
        
        $signup_sql = "INSERT INTO members  VALUES ('$email', '$username', '$encryp')";

        $statement = connUSERDB() -> prepare($signup_sql);

        $statement -> execute();
         
        header('Location: /index.html');
    }
}

echo json_encode($output);

?>
