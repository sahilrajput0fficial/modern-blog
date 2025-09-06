<?php
require 'db.php';

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}
$categories = $conn->query("SELECT id, name, image FROM categories ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Categories</title>
    <link rel="stylesheet" href = "style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer src="script.js"></script>

</head>
<body>
       <?php include 'sidebar.php'?>
       <section class="container mx-auto px-6 py-10">
            <h2 class="text-3xl font-bold mb-8 border-l-4 border-[var(--primary)] pl-3">
                Explore Categories
            </h2>
            <div class="grid md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php while($cat = $categories->fetch_assoc()):?>
                    <a href="category.php?category=<?php echo (strtolower($cat['name']));  ?>" 
                    class="group block bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">
                    
                        <?php if(!empty($cat['image'])): ?>
                            <img src="uploads/<?php echo $cat['image']; ?>" 
                                alt="<?php echo $cat['name']; ?>" 
                                class="w-full h-40 object-cover group-hover:scale-105 transition-transform duration-500">
                        <?php else: ?>
                            <div class="w-full h-40 bg-gray-100 flex items-center justify-center text-gray-500 text-lg">
                                No Image
                            </div>
                        <?php endif; ?>

                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-gray-800 group-hover:text-[var(--primary)] transition">
                                <?php echo $cat['name']; ?>
                            </h3>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </section>
        <?php include 'footer.php' ?>

    
</body>
</html>