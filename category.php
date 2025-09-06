<?php
require 'db.php';

session_start();
$name = $_GET["category"];


$query = $conn->prepare("SELECT b.*,u.name as author , c.name as category_name FROM blogs b
left join categories c
on c.id = b.category
left join users u 
on u.id = b.user_id
where c.name=?;");
$query->bind_param("s",$name);
$query->execute();
$result = $query ->get_result();

$stmt = $conn->prepare("
    SELECT u.id, u.name,
           COUNT(b.id) AS total_articles,
           COALESCE(SUM(b.views), 0) AS total_reads
    FROM blogs b
    LEFT JOIN users u ON b.user_id = u.id
    LEFT JOIN categories c ON c.id = b.category
    WHERE c.name = ? AND b.is_approved = 1
    GROUP BY u.id, u.name
    ORDER BY total_articles DESC
    LIMIT 6
");

$stmt->bind_param("s", $name);
$stmt->execute();
$topAuthors = $stmt->get_result();

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
    <?php include "sidebar.php";?>
    <section class="top-post">
        <div class="container">

            <div class="text-sm mb-6 text-gray-500">
                <a href="index.php" class="hover:text-[var(--primary)]">Home</a> >
                <span class="font-semibold text-gray-700"><?php echo ucfirst($name); ?></span>
            </div>
            <h2 class="text-2xl font-bold mb-6 border-l-4 border-[var(--primary)] pl-3">
                Weekly Top Post
            </h2>

            <div class=" grid grid-cols-3 gap-6">
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="group overflow-hidden rounded-lg shadow hover:shadow-lg transition bg-white">
                    <a href="blog.php?blog_name=<?php echo $row['blog_name']; ?>" class="block relative">
                        <img src="uploads/<?php echo $row['image']; ?>" 
                                alt="<?php echo $row['title']; ?>" 
                                class="w-full h-52 object-cover group-hover:scale-105 transition duration-500">
                        <span class="absolute bottom-2 left-2 bg-[var(--primary)] text-white text-xs font-bold px-2 py-1 rounded">
                            <?php echo $row['category']; ?>
                        </span>
                    </a>
                    <div class="p-4">
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
    <section class="author-section">
        <div class="container">
            <h2 class="text-2xl font-bold mb-6 border-l-4 border-[var(--primary)] pl-3">
                Top Authors from this Category
            </h2>
            <div class="grid grid-cols-6 gap-6">

                <?php while($author = $topAuthors->fetch_assoc()): ?>
                <div class="bg-white rounded-xl shadow-md p-6 text-center hover:shadow-xl transition">
                    <h3 class="mt-4 text-lg font-semibold text-gray-800"><?php echo $author['name']; ?></h3>
                    <p class="text-sm text-gray-500">

                        <?php echo $author['total_articles']; ?> Articles • 
                        <?php echo number_format($author['total_reads']); ?> Reads
                    </p>
                    <a href="profile.php?id=<?php echo $author['id']; ?>" 
                    class="mt-4 px-4 py-2 inline-block text-sm font-medium bg-[var(--primary)] text-white rounded-lg hover:bg-opacity-90">
                    View Profile
                    </a>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
  
    </section>
    <?php include 'footer.php';?>
</body>
</html>