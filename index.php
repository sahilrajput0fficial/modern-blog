<?php
require 'db.php';
$result = $conn->query("SELECT * FROM blogs");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href = "style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    

    <script defer src="script.js"></script>

</head>
<body>
   <?php include 'sidebar.php'?>
    <section class="main">
        <div class="container">
            <div>
                <div class="color-back bg-[#970747] rounded-lg p-3">
                    <div class="p-3">
                        <p class="text-4xl text-center text-white font-semibold p-3">Welcome to ModernBlog</p>
                        <p class="text-2xl text-center text-yellow-100">Discover insightful articles, tutorials, and stories from our community of writers.</p>

                    </div>
                    <div class="btn-group flex gap-2 justify-center p-3">
                        <button class="btn-2">Get Started</button>
                        <button class="btn-2">Log in</button>
                    </div>
                    <div></div>
                </div>
            </div>
        </div>
    </section>
    <section class="featurepost">
        <div class="container">
            
            <div class="net-contianer">
                
                <div class="sidebar shadow-lg">
                    <p class="text-xl ">Search & Filter</p>
                    <div class="search-box">
                        <input type="text" placeholder="Search posts...">
                    </div>
                    <div class="filter-section">
                        <p class="side-head">Category</p>
                        <label for="category">
                            <select name="category" id="category">
                                <option value="" default>All Category </option>
                                <option value="zoology">Zoology</option>
                                <option value="agriculture">Agriculture</option>
                                <option value="technology">Technology</option>
                                <option value="travel">Travel</option>
                            </select>
                        </label>
                    </div>

                    <p class="side-head mb-10">Tags</p>
                    <div class="tag-group">
                        <span class="blog-tag">Zoology</span>
                        <span class="blog-tag">Technology</span>
                        <span class="blog-tag">Travel</span>
                        <span class="blog-tag">Website</span>
                        <span class="blog-tag">Machine Learning</span>
                    </div>
                </div>
                
                <div class="card-container flex flex-col gap-2 ">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="card flex  bg-white rounded-md shadow-lg ">
                            <img class="post-img"src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['image']; ?>">
                            <div class="p-3">
                                <div class="top-elem flex justify-between">
                                    <span class="blog-tag"><?php echo $row['tags'];?></span>
                                    <span class="text-gray-500 text-sm"><?php echo $row['date'];?></span>
                                </div>
                                <a href="blog.php?blog_name=<?php echo $row['blog_name']; ?>" target="_blank"class="title text-xl font-bold"><?php echo $row['title']; ?></a>
                                <p class="text-sm mb-4"><?php echo strip_tags(substr($row['content'], 0, 270));?>...</p>
        
                                <div class="flex justify-between ">
                                    <div class="text-sm">
                                        <i class="fa-solid fa-user text-[#970747]"></i>
                                        <span class="text-gray-500">Sahil Rajput</span>

                                    </div>
                    
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            </div>
        </div>
    </section >

    
</body>
</html>