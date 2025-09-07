<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require 'db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = $conn->prepare("
    SELECT b.*, c.name as category_name
    FROM blogs b
    LEFT JOIN categories c ON c.id = b.category
    WHERE b.user_id = ?
    ORDER BY b.date desc;
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

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
    <?php include 'sidebar.php' ?>
    <section class="myblogs">
        <div class="container text-gray-800">
    
            <h1 class="text-3xl font-bold mb-6">My Blogs</h1>

            <?php if (empty($result)): ?>
            <p class="text-lg text-gray-600">You have not published any blogs yet.</p>
            <?php else: ?>
            <table class="min-w-full border border-gray-200 bg-white shadow-sm rounded-lg">
                <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-3 border-b">Title</th>
                    <th class="px-4 py-3 border-b">Category</th>
                    <th class="px-4 py-3 border-b">Published On</th>
                    <th class="px-4 py-3 border-b">Approval Status</th>
                    <th class="action px-4 py-3 border-b text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                    <a class="btn py-2" href="write.php">
                    <i class="fa-solid fa-plus pr-1 mt-4"></i>Create A Blog </a>
                <?php while($blog=$result->fetch_assoc()): ?>
                    
                    <div class="mb-10"></div>
                    <tr class=" hover:bg-gray-50 ">
                    <td class="px-4 py-3 border-b font-medium hover:text-[var(--primary)]"><a href="blog.php?blog_name=<?php echo $blog["blog_name"]?>"><?php echo $blog['title']; ?></a></td>
                    <td class="px-4 py-3 border-b"><?php echo ($blog['category_name'] ?? 'Uncategorized') ?></td>
                    <td class="px-4 py-3 border-b"><?php echo ($blog['date']) ?></td>
                    <td class="px-4 py-3 border-b">
                        <?php if ($blog['is_approved'] == 1): ?>
                        <span class="text-green-600 font-semibold">Approved</span>
                        <?php elseif ($blog["is_approved"]==-1):?>
                        <span class="text-red-800 font-semibold">Rejected</span>
                        <?php else: ?>
                        <span class="text-red-600 font-semibold">Pending</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3 border-b text-center flex gap-2 justify-center">
                        <a href="blog.php?blog_name=<?php echo $blog['blog_name']?>" class="actionbtn view bg-green-700 py-2 px-2 rounded-lg text-white hover:bg-green-900">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a class="actionbtn edit bg-gray-700 py-2 px-2 rounded-lg text-white">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <a class="actionbtn delete bg-red-700 py-2 px-2 rounded-lg text-white">
                            <i class="fa-solid fa-trash"></i>
                        </a>

                            
                    </td>

                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            <?php endif; ?>

        </div>
    </section>
    <?php include 'footer.php' ?>
</body>
</html>
