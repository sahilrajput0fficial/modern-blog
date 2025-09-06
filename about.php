<?php
session_start();
require 'db.php';
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
        <section class=" px-6 py-12">
            <div class="container">
                <h1 class="text-4xl font-bold mb-6 text-gray-800">About This Blog</h1>
                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    Welcome to <span class="font-semibold text-gray-800">NSUT K Blog</span> — a space created by students, for students. 
                    Here, we share stories, updates, and experiences from the vibrant campus life of 
                    <span class="font-medium">Netaji Subhas University of Technology</span>.
                </p>
                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    From academics and research to fests, clubs, and hostel life — this blog covers it all. 
                    Our goal is to capture the true spirit of NSUT, where innovation meets creativity, 
                    and friendships turn into lifelong memories.
                </p>

                <p class="text-lg text-gray-600 leading-relaxed mb-6">
                    Whether you’re a current student, an alum, or someone curious about our campus, 
                    you’ll find insights, guides, and personal experiences that make NSUT unique. 
                    It’s not just about grades or placements — it’s about the people, the culture, 
                    and the unforgettable journey of being part of the NSUT family.
                </p>
                <p class="text-xl font-medium text-gray-700 italic">
                    NSUT K Blog is more than just a platform — it’s our diary, our newsroom, and our community space.  
                    Welcome aboard .
                </p>
                
            </div>
        </section>
        <?php include 'footer.php' ?>

        

    </body>
</html>




























