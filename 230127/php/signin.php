<?php

include 'db_conn.php';

session_start();

// $db_host='localhost';
// $db_port='3306';
// $db_user='user0';
// $db_password='1234';

// $pdo = new PDO("mysql:host=$db_host;port=$db_port;dbname=user", $db_user, $db_password);


// $email = json_decode(file_get_contents('php://input'))->{"email"};
// $passwd = json_decode(file_get_contents('php://input'))->{"password"};

$email = $_POST["email"];
$passwd = $_POST["password"];

if ($email == "" || $passwd == "") {

    $error = "need email or password";

    header("Location: /signin.html");

} else {

    $email_sql = "SELECT * FROM members WHERE email='$email'";

    $statement = connUSERDB() -> prepare($email_sql);

    $statement -> execute();

    $result = $statement -> fetch();

    json_encode($result);
    
    if ($result[0] !== $email) {
        
        $error = "user is not exist";
       header("Location: /signin.html");

    } else {

        $pw_sql = "SELECT `password` FROM members WHERE email='$email'";
    
        $statement = connUSERDB() -> prepare($pw_sql);
    
        $statement -> execute();
    
        $result = $statement -> fetch();
    
        $encryp = $result[0];

        if ( password_verify($passwd, $encryp) ) {

            $error = "signin Success!";

            $_SESSION['email'] = $email;
	   header("Location: /index.html");

        } else {
            
            $error = "password wrong";
	    header("Location: /signin.html");
            
        }
    }

}

echo json_encode($output);


?>
