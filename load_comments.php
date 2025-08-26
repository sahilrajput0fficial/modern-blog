<?php
require 'db.php';
$blog_id = $_GET['blog_id'];
$query = $conn->prepare("SELECT * FROM comments WHERE blog_id = ? ORDER BY created_at DESC;");
$query->bind_param("i",$blog_id);
$query->execute();
$result=$query->get_result();

$comments=[];
while($row = $result->fetch_assoc()){
    $comments[]=$row;
}

header('Content-Type: application/json');
echo json_encode($comments);
?>