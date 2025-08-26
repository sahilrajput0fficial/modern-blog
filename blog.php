<?php
require 'db.php';
$blog_name=$_GET["blog_name"]??'';
$viewcount = $conn ->prepare("UPDATE blogs set views = (views+1) where blog_name =?");
$viewcount->bind_param("s",$blog_name);
$viewcount->execute();

$query = $conn->prepare("SELECT * FROM blogs WHERE blog_name=?");
$query->bind_param("s",$blog_name);
$query->execute();
$result = $query->get_result();
$blog= $result->fetch_assoc();
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
              <span><i class="fa-regular fa-eye"></i> <?php echo $blog['views'];?> views</span>
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
          <hr class="my-3">
          <p class="text-2xl font-semibold my-8">Comments (<?php echo $total_comment['count']?>)</p>
          <div>
            <div class="comment-form-container">
              <h3>Leave a Comment</h3>
              <form class="comment-form" id="comment-form" >
                <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                  <label for="comment">Comment:</label>
                  <textarea id="comment" name="comment" rows="5" required></textarea>
                </div>
                <button type="submit">Submit Comment</button>
              </form>
            </div>
            <?php while($row = $comm_text_query_result->fetch_assoc()): ?>
              <div class="comment_card mx-4 my-4">
                <div class="user-card">
                  <div class="author-section flex items-center gap-2">
                    <div class="flex items-center justify-center circle bg-[var(--primary)] size-8 ">
                      <span class="text-white text-md font-semibold">SA</span>
                    </div>
                    <div class="text-lg font-semibold">
                      <p>Sahil Rajput</p>
                    </div>
                  </div>
                </div>
                <div>
                  <p class="comment font-regular "><?php echo $row['text']?></p>
                </div>
                <div id ="comment-div" class=" comment-reaction comment flex text-xl gap-5 ">
                  <!--div class="flex items-center gap-2 unreact">
                    <i class="fa-regular fa-thumbs-up"></i>
                    <span class="text-sm">0</span>
                  </div>
                  <div class="flex items-center gap-2 unreact">
                    <i class="fa-regular fa-thumbs-down"></i>
                    <span class="text-sm">0</span>
                  </div>
                  <div class="flex items-center gap-2 unreact">
                    <i class="fa-regular fa-comment-dots "></i>
                    <span class="text-sm">Reply</span> -->
                  </div>  
                  

                </div>
              </div>
            <?php endwhile;?>
            

          </div>
        <?php else: ?>
          <p>Blog not found.</p>
        <?php endif; ?>
      </div>
    </div>

  </div>
</body>
<script>
  let comment = document.getElementById("comment-form");
  comment.addEventListener("submit",function(e){
    e.preventDefault();
    let data = new FormData(this);
    fetch("add_comment.php",{
      method:"POST",
      body:data
    })
    .then(reponse=>respons.text())
    .then(response=>{
      if(response.includes("Success")){
        this.reset();
        loadComments();
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
            <strong>${data.user_id}</strong>
            <div class="meta">${data.created_at}</div>
            <p>${data.comment_text}</p>
          </div>`
      })
    })

    
  }
  loadComments(<?php echo $blog["id"];?>);



</script>
</html>