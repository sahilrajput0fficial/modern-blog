<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $servername = "127.0.0.1"; 
    $username   = "root";       
    $password   = "";           
    $database   = "blogs";
} else {
    $servername = "sql109.infinityfree.com";
    $username   = "if0_39725298";
    $password   = "blog9210819462";
    $database   = "if0_39725298_blogs";
}

$conn = new mysqli($servername, $username, $password, $database);


if($conn->connect_error){
    die ("Connection Failure");
}

?>