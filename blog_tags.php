<?php
require 'db.php';

$query = $conn->prepare("SELECT name from blog_tags");
$run = $query->execute();
$result = $query->get_result();

$tags=[];
while($tag = $result->fetch_assoc()){
    $tags[]=$tag["name"];
}
?>