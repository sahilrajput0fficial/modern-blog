<?php
require 'db.php';
session_start();
if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION["user_id"];
    $user_query = $conn->prepare("Select blogs_count ,favourite_genre from users ;");
    $user_query->execute();
    $run= $user_query->get_result();
    $stats = $run->fetch_assoc();
    
}


$result = $conn->query("SELECT b.* ,c.name as cat_tag ,u.name as writer FROM blogs b
left join categories c on c.id = b.category
left join users u on u.id = b.user_id 
where b.is_approved=1
order by b.views desc
limit 3;");

$category_query = $conn->prepare("SELECT c.name ,count(b.category) as count from blogs b
inner join categories c
where c.id = b.category
GROUP by b.category;");
$category_query->execute();
$run= $category_query->get_result();


$category_tab = $conn->prepare("SELECT c.name ,count(b.category) as count ,c.image from blogs b
inner join categories c
where c.id = b.category
GROUP by b.category
order by count(b.category) desc
limit 5

;");
$category_tab->execute();
$run2= $category_tab->get_result();


$query = $conn->prepare("Select c.name as tags from categories c ;");
$category_query->execute();
$run= $category_query->get_result();

$lifestyle_query = $conn->prepare("SELECT b.*, u.name as author, c.name as category_name 
FROM blogs b
LEFT JOIN categories c ON c.id = b.category
LEFT JOIN users u ON u.id = b.user_id
WHERE c.name = ?");
$lifestyle_query->bind_param("s", $category);
$category = "Lifestyle";
$lifestyle_query->execute();
$life_result=$lifestyle_query->get_result();


$topauth_query = $conn->prepare("
    SELECT b.id, b.title, b.blog_name,b.image, u.name AS author 
    FROM blogs b
    LEFT JOIN users u ON b.user_id = u.id
    WHERE b.is_approved = 1
    order by b.views desc
    LIMIT 4
");
$topauth_query->execute();
$topauth = $topauth_query->get_result();


$img_query=$conn->prepare("select * from magazine limit 5;");
$img_query->execute();
$images=$img_query->get_result();
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
   <?php if (!isset($_SESSION['user_id'])):?>
    <section class="main">
        
        <div class="container">

            <div>
                
                <div class="color-back bg-[#970747] rounded-lg p-3">
                    
                    <div class="p-3">
                    <p class="text-4xl text-center text-white font-semibold p-3">Welcome to NSUT K Blogs</p>
                    <p class="text-2xl text-center text-yellow-100">Discover insightful articles, tutorials, and stories from our community of writers.</p>

                    </div>
                    <div class="btn-group flex gap-2 justify-center p-3">
                        <a href="auth/signup.php" class="btn-2">Get Started</a>
                        <a href="auth/login.php" class="btn-2">Log in</a>
                    </div>
                </div>

            </div>
            
                
            </div>
        </div>
        
    </section>
    <?php endif;?>
    <section class="top-post mt-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-3 gap-6">
            <article class="img-container col-span-2 relative h-96 z-0 rounded-xl group overflow-hidden">
                <img src="uploads/ai.jpg" alt="Featured" class=" w-full h-full object-cover img-rot">
                
                <div class="absolute bottom-6 left-6 text-white">
                <span class="blog-tag transition-transform duration-500 group-hover:-translate-y-2">TECHNOLOGY</span><br>
                <a href="blog.php?blog_name=rise-of-ai-shaping-future"class="block text-2xl font-bold mt-2 transition-transform duration-500 group-hover:-translate-y-2 hover:text-[var(--primary)]">The Rise of Artificial Intelligence: Shaping Our Future</a>
                </div>
            </article>
            <div class="flex flex-col gap-6">
                
                <article class=" img-container relative h-44 rounded-xl overflow-hidden group">
                    <img src="uploads/oblivion.png" alt="Post" class="w-full h-full object-cover img-rot">
                    <div class="absolute bottom-4 left-4 text-white">
                        <span class="blog-tag transition-transform duration-500 group-hover:-translate-y-2">TECHNOLOGY</span>
                        <a href="blog.php?blog_name=oblivion-2025"class="block text-2xl font-bold mt-2 transition-transform duration-500 group-hover:-translate-y-2 hover:text-[var(--primary)]">Oblivion 2025 – D’Code’s Annual Tech Fest</a>
                    </div>
                </article>

                <article class="img-container group relative h-44 rounded-xl overflow-hidden">
                    <img src="uploads/nsut.png" alt="Post" class="w-full h-full object-cover img-rot">
                    <div class="absolute bottom-4 left-4 text-white">
                        <span class="blog-tag">INFORMATION</span>
                        <a href="blog.php?blog_name=best-nsut-soc"class="block text-2xl font-bold mt-2 transition-transform duration-500 group-hover:-translate-y-2 hover:text-[var(--primary)]">Top Student Societies at NSUT and Why You Should Join Them</a>
                    </div>
                </article>

            </div>
            </div>
            <div class="grid grid-cols-3 gap-6 mt-6">
            
            <article class="relative group h-60 rounded-xl overflow-hidden">
                    <img src="uploads/health.jpeg" alt="Post" class="w-full h-full object-cover img-rot" >
                    <div class="absolute bottom-4 left-4 text-white">
                        <span class="blog-tag">LIFESTYLE</span>
                        <a href="blog.php?blog_name=health-during-exam"class="block text-xl font-bold mt-2 transition-transform duration-500 group-hover:-translate-y-2 hover:text-[var(--primary)]">How to Stay Healthy During Exam Season</a>
                    </div>
            </article>

            <article class="relative group h-60 rounded-xl overflow-hidden">
                    <img src="uploads/fresher.jpg" alt="Post" class="w-full h-full object-cover img-rot">
                    <div class="absolute bottom-4 left-4 text-white">
                    <span class="blog-tag">INFORMATION</span>
                    <a href="blog.php?blog_name=fresher-guide-nsut"class="block text-xl font-bold mt-2 transition-transform duration-500 group-hover:-translate-y-2 hover:text-[var(--primary)]">A Freshers’ Guide to Surviving and Thriving at NSUT</a>
                    </div>
            </article>
            <article class="relative group h-60 rounded-xl overflow-hidden">
                    <img src="uploads/tech-fest.jpg" alt="Post" class="w-full h-full object-cover img-rot">
                    <div class="absolute bottom-4 left-4 text-white">
                    <span class="blog-tag">FEST</span>
                    <a href="blog.php?blog_name=tech-fest"class="block text-xl font-bold mt-2 transition-transform duration-500 group-hover:-translate-y-2 hover:text-[var(--primary)]">Highlights of Tech Fests at NSUT: Innovation Meets Celebration</a>
                    </div>
            </article>


            </div>
        </div>
    </section>    
    <section class="list-post">
        <div class="container">       
              
            <div class="net-container grid grid-cols-12 gap-6 ">
                
                    
                <div class="sidebar col-span-3 bg-white shadow rounded-2xl p-4 h-fit">
                    <?php if (isset($_SESSION['user_id'])):?>
                    <div class="flex flex-col justify-center border-b mb-4">
                        <div class="flex items-center justify-center justify-self-centre circle bg-[var(--primary)] size-24 "style=" align-self: center;">
                            <span class=" text-white text-4xl font-semibold">SA</span>
                        </div>
                        <p class="text-2xl font-semibold text-gray-800 mb-4">Your Stats</p>
                        
                        <div class="flex justify-between items-center border-b pb-3 mb-3">
                            <span class="text-gray-600">Blogs Published</span>
                            <span class="font-bold text-[var(--primary)]">
                                <?php echo $stats["blogs_count"]; ?>
                            </span>
                        </div>
                    
                    

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Favourite Genre</span>
                            <span class="font-bold text-[var(--primary)]">
                                <?php echo $stats["favourite_genre"]; ?>
                        </div>
                    </div>
                    <?php endif;?>

                    <p class="side-head mb-10">Tags</p>
                    <div class="tag-group">
                    <?php while($rowt = $run->fetch_assoc()):?>
                            <span class="blog-tag"><?php echo $rowt["name"]?></span>
                    <?php endwhile; ?>
                        
                    </div>
                </div>
                
                <div class="card-container col-span-6 flex flex-col gap-4">
                    <div class="mb-5">
                        <h2 class="text-2xl font-bold border-l-4 border-[var(--primary)] pl-3">
                        Top of The Week
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
                                <p class="text-sm mb-1 line-clamp-2"><?php echo strip_tags(substr($row['content'], 0, 270));?>...</p>
        
                                <div class="flex justify-between ">
                                    <div class="text-sm mb-2">
                                        <i class="fa-solid fa-user text-[#970747]"></i>
                                        <span class="text-gray-500 "><?php echo $row['writer'];?></span>
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    
                    
                </div>
                <aside class="col-span-3 bg-white shadow rounded-2xl p-4 h-fit">
                    <div class="mb-2">
                        <h2 class="text-xl font-bold border-l-4 border-[var(--primary)] pl-3">
                        Categories
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-1">

                        <?php while($row = $run2->fetch_assoc()):?>
                        <a href="category.php?category=<?php echo strtolower($row["name"])?>">
                        <div class="category-card rounded-lg h-24">
                            <img src="uploads/<?php echo $row["image"]?>"class="w-full h-full object-cover rounded-lg">
                            <div class="absolute inset-0 category-overlay rounded-lg"></div>
                            <div class="absolute left-0 top-1/2 transform -translate-y-1/2">
                                <div class="category-label bg-[var(--primary)] text-white px-6 py-2 font-bold text-sm uppercase tracking-wide">
                                    <?php echo $row["name"];?>
                                </div>
                            </div>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white text-[var(--primary)] font-bold text-lg px-3 py-1 rounded shadow">
                                <?php echo $row["count"];?>
                            </div>
                        </a>
                        </div>
                        <?php endwhile;?>
                </aside>
            </div>
            </div>
        </div>
    </section>
    <section class="lifestyle">
        <div class="container">
            <div class="mb-10">
                <h2 class="text-2xl font-bold mb-6 border-l-4 border-[var(--primary)] pl-3">
                Lifestyle
                </h2>
            </div>
            <div class=" grid grid-cols-3 gap-6">
                <?php while($row = $life_result->fetch_assoc()): ?>
                <div class="group overflow-hidden rounded-lg shadow hover:shadow-lg transition bg-white grid grid-cols-2" >
                    <div >
                        <a href="blog.php?blog_name=<?php echo $row['blog_name']; ?>" class="block relative w-full h-full">
                            <div class="w-full h-full overflow-hidden">
                                <img src="uploads/<?php echo $row['image']; ?>" 
                                        alt="<?php echo $row['title']; ?>" 
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ">
                            </div>
                            <span class="absolute bottom-2 left-2 bg-[var(--primary)] text-white text-xs font-bold px-2 py-1 rounded">
                                <?php echo $row['category']; ?>
                            </span>
                        </a>
                    </div>
                    <div class="p-4">
                        <p class="blog-tag"><?php echo $row['category_name']?></p></br>
                        <a href="blog.php?blog_name=<?php echo $row['blog_name']; ?>" 
                            class="font-bold text-lg group-hover:text-[var(--primary)] transition">
                            <?php echo $row['title']; ?>
                        </a>
                        <p class="text-gray-500 text-sm mt-2 line-clamp-2">
                            <?php echo strip_tags(substr($row['content'],0,200))?>...
                        </p>
                        <p class="text-gray-500 text-sm mt-2">
                            By <?php echo $row['author']; ?> · 
                            <?php echo ($row['date']); ?>
                        </p>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>

        </div>
    </section>
    <?php
    $query3 = $conn->prepare("Select * from videos limit 3");
    $query3->execute();
    $run = $query3->get_result();
     ?>
    
    <section class="video-section">
        <div class="container">
                <div class="mb-10">
                    <h2 class="text-2xl font-bold mb-6 border-l-4 border-[var(--primary)] pl-3">
                    Our Video Collection
                    </h2>
                </div>

                <div class="grid grid-cols-4 gap-8">
                    <?php while($row = $run->fetch_assoc()): ?>
                    <div class="video-card group cursor-pointer transform transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="relative overflow-hidden rounded-t-xl bg-black aspect-video">
                            <img 
                                src="uploads/<?php echo $row['image']; ?>" 
                                alt="<?php echo htmlspecialchars($row['title']); ?>"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110"
                            >
                            <div class="absolute inset-0 bg-black bg-opacity-30 transition-opacity duration-300 group-hover:bg-opacity-20"></div>
                            
                            <div class="absolute inset-0 flex items-center justify-center">
                                <button class="play-btn w-16 h-16 bg-white bg-opacity-90 rounded-full flex items-center justify-center shadow-lg transform transition-all duration-300 hover:bg-opacity-100 hover:scale-110 group-hover:shadow-xl">
                                    <svg class="w-6 h-6 text-[#970747] ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="absolute bottom-3 right-3 bg-black bg-opacity-80 text-white text-xs px-2 py-1 rounded-md">
                                <?php echo $row['time']; ?> min
                            </div>
                        </div>
                        <div class="bg-white p-5 rounded-b-xl border-l border-r border-b border-gray-200">
                            <h3 class="video-title font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-[#970747] transition-colors duration-200">
                                <?php echo htmlspecialchars($row['title']); ?>
                            </h3>
                            
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-[#970747] rounded-full flex items-center justify-center">
                                        <span class="text-white font-semibold text-xs">
                                            <?php echo strtoupper(substr($row['author'], 0, 1)); ?>
                                        </span>
                                    </div>
                                    <span class="font-medium hover:text-[#970747] transition-colors">
                                        <?php echo htmlspecialchars($row['author']); ?>
                                    </span>
                                </div>
                                
                                <div class="flex items-center space-x-1 text-gray-500">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                    <span><?php echo $row['time']; ?> min ago</span>
                                </div>
                            </div>
                            <div class="mt-4 flex space-x-2">
                                <button class="flex-1 bg-[#970747] hover:bg-[#7a0536] text-white py-2 px-4 rounded-lg transition-colors duration-200 font-medium">
                                    Watch Now
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>

                <div class="text-center mt-12">
                    <button class="bg-[#970747]  text-white px-8 py-3 rounded-full font-semibold shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        Load More Videos
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="top-author">
        <div class="container">
            <div class="mb-10">
            <h2 class="text-2xl font-bold mb-6 border-l-4 border-[var(--primary)] pl-3">
                From Our Top Authors
            </h2>
            </div>
            
            <div class="grid md:grid-cols-4 gap-8">
            <?php while($top = $topauth->fetch_assoc()):?>
                <article class="bg-white rounded-xl shadow-md overflow-hidden group hover:shadow-xl transition">
                    <img src="uploads/<?php echo $top["image"];?>" alt="Author" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="p-5">
                    <h3 class="text-lg font-semibold text-gray-800 group-hover:text-[var(--primary)] transition">
                        <?php echo $top["title"];?>
                    </h3>
                    <p class="text-gray-600 text-sm mt-2">
                        By <span class="font-medium text-gray-800"><?php echo $top["author"];?></span>
                    </p>
                    <a href="blog.php?blog_name=<?php echo $top["blog_name"];?>" class="inline-block mt-4 text-[var(--primary)] font-semibold hover:underline">
                        Read More →
                    </a>
                    </div>
                </article>
            <?php endwhile;?>
            </div>
        </div>
    </section>
    <section class="py-12 bg-gray-50">
        <div class="container">
            <div class="mb-10">
            <h2 class="text-2xl font-bold mb-6 border-l-4 border-[var(--primary)] pl-3">
                Editor’s Picks
            </h2>
            </div>
            <div class="grid grid-cols-3 gap-6">
            <article class="relative col-span-2 rounded-xl overflow-hidden group">
                <img src="uploads/fresher.jpg" alt="Highlight" class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/40 group-hover:bg-black/50 transition"></div>
                <div class="absolute bottom-6 left-6 text-white">
                <span class="blog-tag">Feature</span>
                <h3 class="text-2xl font-bold mt-3 group-hover:-translate-y-1 transition">A Freshers’ Guide to Surviving and Thriving at NSUT</h3>
                </div>
            </article>
            <div class="grid grid-cols-2 grid-rows-2 gap-6">
                <article class="relative rounded-xl overflow-hidden group h-38">
                <img src="uploads/oblivion.png" alt="Side pick" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <span class="blog-tag">Article</span>
                    <h4 class="font-semibold mt-2 group-hover:-translate-y-1 transition">Oblivion 2025 – The D’Code’s Society Annual Tech Fest</h4>
                </div>
                </article>

                <article class="relative rounded-xl overflow-hidden group h-38">
                <img src="uploads/hariprasad.avif" alt="Side pick" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition"></div>
                <div class="absolute bottom-4 left-4 text-white">
                    <span class="blog-tag">Story</span>
                    <h4 class="font-semibold mt-2 group-hover:-translate-y-1 transition">Behind the Scenes of Classical Fusion</h4>
                </div>
                </article>
            </div>
            </div>
        </div>
    </section>
    <section class="magazine">
        <div class="container">
            <div class="mb-5 ">
                <h2 class="text-2xl font-bold border-l-4 justify-center border-[var(--primary)] pl-3">
                @NSUT Gallery
                </h2>
            </div>
            
            <div class="grid grid-cols-5 overflow-hidden">
                <?php while($img = $images->fetch_assoc()):?>
                <div>
                    <img src="uploads/magazine/<?php echo $img["name"]?>" class="w-full h-48 object-cover ">
                </div>
                <?php endwhile;?>
            </div>
        </div>

    </section>
    <?php include 'footer.php'?>


    
    

    
</body>
</html>
