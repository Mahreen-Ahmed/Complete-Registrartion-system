<?php
/*
This file contains dadatbase configuration assuming you are running ysql using user root and password=""

*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD','');
define('DB_NAME','login_tt');
//try connecting to the database
$conn= mysqli_connect( DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_NAME);

// CHECK THE CONNECTION
if($conn==false){
    dir('Error: Cannot connect');
}
?>