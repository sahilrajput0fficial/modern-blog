 <section class="navigation sticky top-0 z-50 w-full">
        <div class="container">
            <nav>
                <a class="logo text-2xl font-bold" href="index.php">NSUT K Blogs</a>
                <ul class="nav-list flex-wrap">
                    <li><a href="index.php">HOME</a></li>
                    <li><a href="category.php?category=news">NEWS</a></li>
                    <li><a href="category.php?category=sports">SPORTS</a></li>
                    <li><a href="category.php?category=technology">TECH</a></li>
                    <li><a href="myblogs.php">MY BLOGS</a></li>
                    <li><a href="about.php">ABOUT</a></li>
                    
                </ul>
                <div>
                    <div class="relative flex gap-2">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center ">
                            <i class="fa-solid fa-magnifying-glass text-[#970747]"></i>
                        </span>
                        <input name="search" class="pl-8 pr-3 pt-1.5 pb-1.5 justify-center border rounded-md border-[#970747] focus:outline-none focus:ring-1 focus:ring-[#970747] text-sm"placeholder="Search posts..." aria-label="search" />
                        <?php if (isset($_SESSION['user_id'])):?>
                            <a  class="btn" href="write.php">
                                <i class="fa-solid fa-plus"></i>
                                Write</a>
                           
                        <?php else:?>
                            <a class="btn"  href="auth/login.php">
                                <i class="fa-solid fa-plus"></i>
                                Log in </a>
                        <?php endif;?>
                    </div>
                        
                </div>
                
                
                
                
            </nav>
        </div>
    </section>