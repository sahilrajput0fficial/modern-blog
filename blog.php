<?php
$conn = new mysqli("localhost","root","","blogs");

$slug=$_GET["slug"]??'';
$query = $conn->prepare("SELECT * FROM blogs WHERE slug=?");
$query->bind_param("s",$slug);
$query->execute();
$result = $query->get_result();
$blog= $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $blog['title']; ?></title>
  <link rel="stylesheet" href = "style.css">
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
 <?php include 'sidebar.php'?>
 <div class="container">
    <div>
      <a href=""><i class="fa-solid fa-arrow-left-long mb-5"></i> Back to Posts</a>
      <div class="content bg-white p-5 rounded-lg shadow-lg ">
        <div class="text-sm">
          <span class="blog-tag"><?php echo $blog['tags']; ?></span>
          <span class="text-gray-500">Published on <?php echo $blog['date']; ?></span>
        </div>
        <?php if($blog): ?>
          <p class="text-3xl mb-3"><?php echo $blog['title']; ?></p>
          <div class="post-header flex items-center justify-between my-3">
            <div class="author-section flex items-center gap-2">
              <div class="flex items-center justify-center circle bg-[var(--primary)] size-10 ">
                <span class="text-white text-lg">SA</span>
              </div>
              <div class="text-sm">
                <p>Sahil Rajput</p>
                <p class="text-gray-500">Blog Writer</p>
              </div>
            </div>
            <div class="text-gray-500">
              <span><i class="fa-regular fa-eye"></i> 1.2k views</span>
              <span><i class="fa-regular fa-clock"></i> 8 min read</span>
            </div>
          </div>
          <hr>
          <div class="my-3 rounded-lg shadow-md w-full h-96 overflow-hidden">
          <img class="w-full h-full object-cover"src="uploads/<?php echo $blog['image']; ?>">
          </div>
          <p><?php echo html_entity_decode($blog['content']); ?></p>
          <div class="extra-tags mt-5">
            <span class="blog-tag"><?php echo $blog['tags']; ?></span>
            <span class="blog-tag">Lizard</span>
          </div>
          <hr>
        <?php else: ?>
          <p>Blog not found.</p>
        <?php endif; ?>
      </div>
      <div class="left-sidebar">
        
      </div>
    </div>

  </div>
</body>
</html>