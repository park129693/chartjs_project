<?php

function connUSERDB() {
    
    $db_host='localhost';
    $db_name='user';
    $db_user='user0';
    $db_pw='1234';

    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;", $db_user, $db_pw);

    return $conn;
}

function connCSVDB() {
    
    $db_host='localhost';
    $db_name='csv';
    $db_user='user0';
    $db_pw='1234';

    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;", $db_user, $db_pw);

    return $conn;
}

?>