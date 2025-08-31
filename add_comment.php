<?php
require 'db.php';

if($_SERVER['REQUEST_METHOD']=="POST"){
    $username = $_POST['username'];
    $comment = $_POST['comment'];
    $blog_id = $_POST['blog_id'];
    $query = $conn->prepare("INSERT INTO comments (username, comment_text,blog_id) VALUES (?,?,?)");
    $query->bind_param("ssi",$username,$comment,$blog_id);
    if($query->execute()){
        echo "Success";
    }
    
    else{
        echo "Failure";
    }
    $query->close();
    $conn->close();
}
