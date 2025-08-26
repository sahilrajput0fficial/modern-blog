<?php
require 'db.php';

if($_SERVER['REQUEST_METHOD']=="POST"){
    $username = $_POST['username'];
    $comment = $_POST['comment'];
    $query = $conn->prepare("INSERT INTO comments (username, comment) VALUES (?,?)");
    $query->bind_param("ss",$username,$comment);
    $query->execute();
    if($query){
        echo "Success";
    }
    
    else{
        echo "Failure";
    }
}
