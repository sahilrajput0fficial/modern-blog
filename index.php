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
left join users u on u.id = b.user_id;");

$category_query = $conn->prepare("SELECT c.name ,count(b.category) as count from blogs b
inner join categories c
where c.id = b.category
GROUP by b.category;");

$category_query->execute();
$run= $category_query->get_result();
$category_tab = $conn->prepare("SELECT c.name ,count(b.category) as count from blogs b
inner join categories c
where c.id = b.category
GROUP by b.category
limit 5
;");

$category_tab->execute();
$run2= $category_tab->get_result();

$query = $conn->prepare("Select c.name as tags from categories c ;");
$category_query->execute();
$run= $category_query->get_result();

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
        <?php if (!isset($_SESSION['user_id'])):?>
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
                </div>

            </div>
            
                
            </div>
        </div>
        <?php endif;?>
    </section>
    <section class="top-post mt-20 mb-10">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-3 gap-6">
        <article class="col-span-2 relative h-96 z-0 rounded-xl overflow-hidden">
            <img src="uploads/hariprasad.avif" alt="Featured" class="w-full h-full object-cover ">
            
            <div class="absolute bottom-6 left-6 text-white">
            <span class="blog-tag">Music</span><br>
            <a href="http://localhost/blog/blog.php?blog_name=spic-macay-nsut"class="text-2xl font-bold mt-2 text-[#]">A Historic Beginning: SPIC MACAY NSUT Hosts Pandit Hariprasad Chaurasia</a>
            </div>
        </article>
        <div class="flex flex-col gap-6">
            
            <article class="relative h-44 rounded-xl overflow-hidden">
            <img src="uploads/hariprasad.avif" alt="Post" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black"></div>
            <div class="absolute bottom-4 left-4 text-white">
                <span class="blog-tag">DESIGN</span>
                <h3 class="font-semibold">5 Top Typography Tips for Home Page</h3>
            </div>
            </article>

            <article class="relative h-44 rounded-xl overflow-hidden">
            <img src="uploads/hariprasad.avif" alt="Post" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black"></div>
            <div class="absolute bottom-4 left-4 text-white">
                <span class="blog-tag">LIFESTYLE</span>
                <h3 class="font-semibold">8 Reasons Why Playing in the Sand is Good for Kids</h3>
            </div>
            </article>

        </div>
        </div>
        <div class="grid grid-cols-3 gap-6 mt-6">
        
        <article class="relative h-60 rounded-xl overflow-hidden">
            <img src="uploads/hariprasad.avif" alt="Post" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black"></div>
            <div class="absolute bottom-4 left-4 text-white">
            <span class="blog-tag">DESIGN</span>
            <h3 class="font-semibold">Basic Rules About Lighting in a Restaurant</h3>
            </div>
        </article>

        <article class="relative h-60 rounded-xl overflow-hidden">
            <img src="uploads/hariprasad.avif" alt="Post" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black"></div>
            <div class="absolute bottom-4 left-4 text-white">
            <span class="blog-tag">LIFESTYLE</span>
            <h3 class="font-semibold">New Snow Falling Softly</h3>
            </div>
        </article>

        <article class="relative h-60 rounded-xl overflow-hidden">
            <img src="uploads/hariprasad.avif" alt="Post" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black"></div>
            <div class="absolute bottom-4 left-4 text-white">
            <span class="blog-tag">TRAVEL</span>
            <h3 class="font-semibold">Top 10 Travel Hacks for 2025</h3>
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
                    <div>
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
                    </div>

                    <p class="side-head mb-10">Tags</p>
                    <div class="tag-group">
                    <?php while($rowt = $run->fetch_assoc()):?>
                            <span class="blog-tag"><?php echo $rowt["name"]?></span>
                    <?php endwhile; ?>
                        
                    </div>
                </div>
                
                <div class="card-container col-span-6 flex flex-col gap-4">
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="card flex bg-white rounded-md shadow-lg border-b">
                            <img class="post-img"src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['image']; ?>">
                            <div class="p-3">
                                <div class="top-elem flex justify-between items-center">
                                    <span class="blog-tag"><?php echo $row['cat_tag'];?></span>
                                    <span class="text-gray-500 text-sm"><?php echo $row['date'];?></span>
                                </div>
                                <a href="blog.php?blog_name=<?php echo $row['blog_name']; ?>" target="_blank"class="title text-xl font-bold mb-4"><?php echo $row['title']; ?></a>
                                <p class="text-sm mb-4 line-clamp-2"><?php echo strip_tags(substr($row['content'], 0, 270));?>...</p>
        
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
                    <h2 class="text-lg font-semibold mb-4">Categories</h2>

                    <div class="grid grid-cols-1 gap-4">
                        <?php while($row = $run2->fetch_assoc()):?>
                        <div class="category-card rounded-lg h-24">
                            <img src="uploads/tech.jpg" alt="Travel" class="w-full h-full object-cover rounded-lg">
                            <div class="absolute inset-0 category-overlay rounded-lg"></div>
                            <div class="absolute left-0 top-1/2 transform -translate-y-1/2">
                                <div class="category-label bg-[var(--primary)] text-white px-6 py-2 font-bold text-sm uppercase tracking-wide">
                                    <?php echo $row["name"];?>
                                </div>
                            </div>
                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white text-[var(--primary)] font-bold text-lg px-3 py-1 rounded shadow">
                                <?php echo $row["count"];?>
                            </div>
                        </div>
                        <?php endwhile;?>
                    
                    </div>
                        </li>
                        <li class="border-b pb-2">
                            <a href="#" class="text-sm font-medium text-[var(--primary)] hover:underline">
                                🚀 Top 10 Tech Trends in 2025
                            </a>
                        </li>
                        <li class="border-b pb-2">
                            <a href="#" class="text-sm font-medium text-[var(--primary)] hover:underline">
                                ✨ Blogging for beginners guide
                            </a>
                        </li>
                    </ul>
                    <div class="mt-6">
                        <h3 class="font-semibold mb-2">Subscribe</h3>
                        <input type="email" placeholder="Your email" class="w-full border rounded-lg p-2 mb-2"/>
                        <button class="w-full bg-[var(--primary)] text-white py-2 rounded-lg">Subscribe</button>
                    </div>
                </aside>
            </div>
            </div>
        </div>
    </section >

    
</body>
</html>