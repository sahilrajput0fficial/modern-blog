<?php 
$category_query = $conn->prepare("SELECT c.name ,count(b.category) as count from blogs b
inner join categories c
where c.id = b.category
GROUP by b.category
order by count(b.category) desc ;");
$category_query->execute();
$run2= $category_query->get_result();
?>
<footer class="bg-black text-white pt-10">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10 border-b border-gray-700 pb-10">
        <div>
        <h3 class="text-lg font-bold border-l-4 border-[var(--primary)] pl-2 mb-4">EDITOR'S PICKS</h3>
        <ul class="space-y-4">
            <li class="flex items-center space-x-3">
            <img src="uploads/fresher.jpg" class="w-16 h-16 object-cover rounded" alt="">
            <div>
                <p class="font-medium">A Freshers’ Guide to Surviving and Thriving at NSUT</p>
                <span class="text-xs">4 DAYS AGO</span>
            </div>
            </li>
            <li class="flex items-center space-x-3">
            <img src="uploads/oblivion.png" class="w-16 h-16 object-cover rounded" alt="">
            <div>
                <p class="font-medium">Oblivion 2025 – The D’Code’s Society Annual Tech Fest</p>
                <span class="text-xs">4 DAYS AGO</span>
            </div>
            </li>
        </ul>
        </div>
        <div>
        <h3 class="text-lg font-bold border-l-4 border-l-4 border-[var(--primary)] pl-2 mb-4">LATEST ARTICLES</h3>
        <ul class="space-y-4">
            <li class="flex items-center space-x-3">
            <img src="uploads/tech-fest.jpg" class="w-16 h-16 object-cover rounded" alt="">
            <div>
                <p class="font-medium">Highlights of Tech Fests at NSUT: Innovation Meets Celebration</p>
                <span class="text-xs">4 DAYS AGO</span>
            </div>
            </li>
            <li class="flex items-center space-x-3">
            <img src="uploads/nsut.png" class="w-16 h-16 object-cover rounded" alt="">
            <div>
                <p class="font-medium">Top Student Societies at NSUT and Why You Should Join Them</p>
                <span class="text-xs">4 DAYS AGO</span>
            </div>
            </li>
        </ul>
        </div>
        <div>
        <h3 class="text-lg font-bold border-l-4 border-l-4 border-[var(--primary)] pl-2 mb-4">POPULAR CATEGORIES</h3>
        
        <ul class="space-y-2">
            <?php while($row = $run2->fetch_assoc()):?>
            <li class="flex justify-between"><span><?php echo $row["name"]?></span><span class=""><?php echo $row["count"]?></span></li>

            <?php endwhile;?>
        </ul>
        </div>

    </div>
    <div class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
        <div>
        <h2 class="text-2xl font-bold text-[var(--primary)]">NSUT K BLOGS</h2>
        <p class="text-sm text-gray-400 mt-2">
            
        </p>NSUT Blogs is your hub for campus stories, insights, and student life. We bring you the latest updates, opinions, and creative voices straight from the heart of NSUT.
        <p class="mt-4 font-semibold">Contact Us: <a href="mailto:rajpootsahil51@gmail.com" class="text-[var(--primary)]">rajpootsahil51@gmail.com</a></p>
        </div>

        <div class="flex flex-col md:items-end">
        <input type="email" placeholder="your email address" class="px-4 py-2 w-full md:w-80 text-black rounded-t-md">
        <button class="bg-[var(--primary)] hover:bg-white hover:text-[var(--primary)] hover:border-t px-4 py-2 w-full md:w-80 font-bold rounded-b-md">SUBSCRIBE</button>
        </div>
    </div>

    <div class="text-center border-t border-gray-700 py-4 text-sm">
        © Sahil Rajput. All rights reserved 2025. nsutKblogs.com  
        <div class="mt-2 space-x-4">
        <a href="./privacy.php" class="hover:text-white">Privacy</a>
        <a href="./advertisement.php" class="hover:text-white">Advertisement</a>
        <a href="./about.php" class="hover:text-white">About Us</a>
        </div>
    </div>
</footer>