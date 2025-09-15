<?php
require 'db.php';

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $search = "%".$search."%";

    $query = $conn->prepare("SELECT b.* ,c.name as cat_tag ,u.name as writer FROM blogs b
                left join categories c on c.id = b.category
                left join users u on u.id = b.user_id 
                where b.is_approved=1 and b.title LIKE ? OR b.content LIKE ? ORDER BY views DESC");
    $query->bind_param("ss",$search,$search);
    $query->execute();
    $result = $query->get_result();
}
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
    <section>
        <div class="container">
            <div class="card-container col-span-6 flex flex-col gap-4">
                    <div class="mb-5">
                        <h2 class="text-2xl font-bold border-l-4 border-[var(--primary)] pl-3">
                        Posts Based On Your Search : <?php echo $_GET['search']?>
                        </h2>
                    </div>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="card group flex bg-white rounded-md shadow-lg border-b transform transition-all duration-300 hover:-translate-y-2 hover:shadow-xl">
                            <div class="img_cont overflow-hidden object-contain" >
                                <img class="post-img w-full h-full"src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['image']; ?>">
                            </div>
                            <div class="p-3">
                                <div class="top-elem flex justify-between items-center">
                                    <span class="blog-tag"><?php echo $row['cat_tag'];?></span>
                                    <span class="text-gray-500 text-sm"><?php echo $row['date'];?></span>
                                </div>
                                <a href="blog.php?blog_name=<?php echo $row['blog_name']; ?>" target="_blank"class="title text-xl font-bold mb-4"><?php echo $row['title']; ?></a>
                                <p class="text-sm mb-1 line-clamp-2"><?php echo strip_tags(substr($row['content'], 0, 600));?>...</p>
        
                                <div class="flex justify-between ">
                                    <div class="text-sm mb-2">
                                        <i class="fa-solid fa-user text-[#970747]"></i>
                                        <span class="text-gray-500 "><?php echo $row['writer'];?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php if($result->num_rows==0):?>
                        <span class="text-lg font-semibold">Blogs Not Found</span>
                    <?php endif;?>

                    
                    
                </div>
        </div>
    </section>
</body>
</html>
