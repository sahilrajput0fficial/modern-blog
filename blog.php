<?php
require 'db.php';

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}

$blog_name=$_GET["blog_name"]??'';
$viewcount = $conn ->prepare("UPDATE blogs set views = (views+1) where blog_name =?");
$viewcount->bind_param("s",$blog_name);
$viewcount->execute();

$query = $conn->prepare("SELECT * FROM blogs WHERE blog_name=?");
$query->bind_param("s",$blog_name);
$query->execute();
$result = $query->get_result();
$blog= $result->fetch_assoc();


$category_query = $conn->prepare("Select c.name as cat_tag from categories c join blogs b where c.id = b.category and b.id=?;");
$category_query->bind_param("i",$blog["id"]);
$category_query->execute();
$run= $category_query->get_result();
$category_tags = $run->fetch_assoc();

$blog_query = $conn->prepare("SELECT t.id, t.name FROM blog_tags t JOIN blog_tag_connection bt ON t.id = bt.tag_id WHERE bt.blog_id = ?;");
$blog_query->bind_param("i",$blog["id"]);
$blog_query->execute();
$run2= $blog_query->get_result();

$comm_query = $conn->prepare("Select count(*) as count from comments where blog_id = ?");
$comm_query->bind_param("i",$blog["id"]);
$comm_query->execute();
$comm_query_result = $comm_query->get_result();
$total_comment = $comm_query_result->fetch_assoc();

$comm_text_query = $conn->prepare("Select comment_text as text from comments where blog_id = ?");
$comm_text_query->bind_param("i",$blog["id"]);
$comm_text_query-> execute();
$comm_text_query_result = $comm_text_query->get_result();



?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $blog['title']; ?></title>
  <link rel="stylesheet" href = "style.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="script.js"></script>

</head>
<body>
 <?php include 'sidebar.php'?>
  <div class="container">
    <div>
      <a href=""><i class="fa-solid fa-arrow-left-long mb-5"></i> Back to Posts</a>
    </div>
    <div class="blog-container grid grid-cols-1 lg:grid-cols-4 gap-6">
      <div class="lg:col-span-3 content bg-white p-5 rounded-lg shadow-lg">
        <div class="text-sm">
          <span class="blog-tag"><?php echo $category_tags['cat_tag']; ?></span>
          <span class="text-gray-500">Published on <?php echo $blog['date']; ?></span>
        </div>

        <?php if($blog): ?>
          <p class="text-3xl mb-3"><?php echo $blog['title']; ?></p>
          <div class="post-header flex items-center justify-between my-3">
            <div class="author-section flex items-center gap-2">
              <div class="flex items-center justify-center circle bg-[var(--primary)] size-10">
                <span class="text-white text-lg">SA</span>
              </div>
              <div class="text-sm">
                <p>Sahil Rajput</p>
                <p class="text-gray-500">Blog Writer</p>
              </div>
            </div>
            <div class="text-gray-500">
              <span><i class="fa-regular fa-eye"></i> <?php echo $blog['views'];?> views</span>
              <span><i class="fa-regular fa-clock"></i> 8 min read</span>
            </div>
          </div>

          <hr>

          <div class="my-3 rounded-lg shadow-md w-full h-96 overflow-hidden">
            <img class="w-full h-full object-cover" src="uploads/<?php echo $blog['image']; ?>">
          </div>
            <p><?php echo html_entity_decode($blog['content']); ?></p>

          <div class="extra-tags mt-5">
            
          </div>

          <hr class="my-3">

          <p class="text-2xl font-semibold my-8">Comments (<?php echo $total_comment['count']?>)</p>

          <div>
            <div class="comment-form-container">
              <h3>Leave a Comment</h3>
              <form class="comment-form flex flex-col gap-2" id="comment-form" action="add_comment.php" method="POST">
                <input type="hidden" name="blog_id" value="<?php echo $blog["id"]; ?>">
                <div class="form-group">
                  <label for="comment">Comment:</label>
                  <textarea class="focus:outline-none focus:ring-1 focus:ring-[#970747]"id="comment" name="comment"  rows="5" required></textarea>
                </div>
                <div class="form-group">
                  <label for="name">Name:</label>
                  <input class="focus:outline-none focus:ring-1 focus:ring-[#970747]"type="text" id="name" name="username" required>
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input class="focus:outline-none focus:ring-1 focus:ring-[#970747]"type="email" id="email" name="email" required>
                </div>
                <button class="btn w-fit "type="submit">Submit</button>
              </form>
            </div>

            <div id="comment-div" class="mx-4 my-4">
            </div>
          </div>
        <?php else: ?>
          <p>Blog not found.</p>
        <?php endif; ?>
      </div>
      <aside class="lg:col-span-1 space-y-6 ">
        <div class="bg-white p-5 rounded-lg shadow-lg">
          <h3 class="text-xl font-semibold mb-3">Related Posts</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-[var(--primary)] hover:underline">Another Blog Title</a></li>
            <li><a href="#" class="text-[var(--primary)] hover:underline">Trending Article</a></li>
            <li><a href="#" class="text-[var(--primary)] hover:underline">How to Write Blogs</a></li>
          </ul>
        </div>

        <div class="bg-white p-5 rounded-lg shadow-lg mt-6">
          <h3 class="text-xl font-semibold mb-3">Tags</h3>
          <div class="flex flex-wrap gap-2">
            <?php while($tag=$run2->fetch_assoc()):?>
            <span class="blog-tag"><?php echo $tag["name"]; ?></span>
            <?php endwhile ?>
          </div>
        </div>
      </aside>
  
    </div>

</body>
<script>
  let comment = document.getElementById("comment-form");
  comment.addEventListener("submit",function(e){
    e.preventDefault();
    let data = new FormData(this);
    alert("Done");
    fetch("add_comment.php",{
      method:"POST",
      body:data
    })
    .then(response=>response.text())
    .then(response=>{
      if(response.includes("Success")){
        this.reset();
        loadComments(<?php echo $blog["id"];?>);
      }
      else {
      alert("Error: " + data);

    }})
  })

  function loadComments(blog_id){
    fetch("load_comments.php?blog_id="+blog_id)
    .then(response=>response.json())
    .then(response_json=>{
      let section = document.getElementById("comment-div");
      section.innerHTML="";

      response_json.forEach (data=>{
        section.innerHTML += `
          <div class="comment">
            <div class="user-card">
              <div class="author-section flex items-center gap-2">
                <div class="flex items-center justify-center circle bg-[var(--primary)] size-8 ">
                  <span class="text-white text-md font-semibold">${data.username.split(" ").map(w => w[0]).join("").toUpperCase()}</span>
                </div>
                <div class="text-lg font-semibold">
                  <p>${data.username}</p>
                </div>
              </div>
            </div>
            <div>
              <p class="comment font-regular ">${data.comment_text}</p>
            </div>
          </div>`
      })
    })

    
  }
  loadComments(<?php echo $blog["id"];?>);



</script>
</html>