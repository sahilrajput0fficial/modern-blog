<?php
require 'db.php';

session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: auth/login.php");
    exit;
}
if(isset($_POST["blog_submit"])){
    $title = $_POST["title"];
    $content = $_POST["content"];
    $link = $_POST["link"];
    $user_id = $_SESSION["user_id"];
    $selected_tags = json_decode($_POST['tags'], true);
    
    ////////////////
    $imagePath =null;
    if (!empty($_FILES['image']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); 
        }

        $fileName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        }
    }
    //////////////////
    $query = $conn->prepare("INSERT INTO blogs (user_id,title, blog_name,image,content,date) VALUES (?, ?,?,?,?,NOW())");
    $query->bind_param("issss",$user_id, $title,$link, $imagePath,$content );

    if ($query->execute()) {
        echo "Blog published successfully!";

    }
    $query->close();

    $query2 = $conn->prepare("INSERT IGNORE INTO blog_tags (name) VALUES (?)");
    foreach($selected_tags  as  $tag){
        $query2->bind_param("s",$tag);
        $query2->execute();

    }
}


$query = $conn->prepare("SELECT name from blog_tags");
$run = $query->execute();
$result = $query->get_result();

$tags=[];
while($tag = $result->fetch_assoc()){
    $tags[]=$tag["name"];
}








?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Your Writer Window</title>
  <link rel="stylesheet" href = "style.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="script.js"></script>
  <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body>
    <?php include 'sidebar.php';?>
    <section id="content-box">
        <div class="container">
            <div class="content bg-white p-5 rounded-lg shadow-lg">
                <p class="text-3xl mb-3 font-semibold">Write A New Blog</p>
                <form method="POST"action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title"class="w-full focus:outline-none focus:ring-1 focus:ring-[#970747]" required><br><br>
                    </div>
                    <div class="form-group">
                        <label for="editor">Content</label>
                        <textarea name="content" rows="10" id="editor" class="w-full pt-8 focus:outline-none focus:ring-1 focus:ring-[#970747]"></textarea><br><br>
                    </div>
                    <div class="form-group">
                        <label for="link">Blog Link(Usually each word of blog name separated by hypen(-))</label>
                            <input type="text" name="link" id="link"class="w-full focus:outline-none focus:ring-1 focus:ring-[#970747]" required><br><br>
                    </div>
                    <div class="form-group">
                        <label for="imageUpload">Cover Image</label>
                        <input type="file" id="imageUpload" name="image" accept="image/*">
                    </div>
                    <div class="form-group"></div>
                    <script>
                        let dbTags = <?php echo json_encode($tags); ?>;
                    </script>
                    <div class="mt-4 font-semibold"><p class="my-4">Add Blog Tags</p>
                        <div x-data="{
                            open: false, tags: [], options: dbTags, newTag: ''}" class="w-full max-w-md">

                            <div class="border rounded p-2 cursor-pointer flex flex-wrap items-center" @click="open = !open">
                                <template x-for="tag in tags" :key="tag">
                                    <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded mr-2 mb-1 text-sm flex items-center">
                                        <span x-text="tag"></span>
                                        <button type="button" class="ml-1 text-red-500" @click.stop="tags = tags.filter(t => t !== tag)">×</button>
                                    </span>
                                </template>
                                <span x-show="tags.length === 0" class="text-gray-400">Select or add tags...</span>
                            </div>

                            <div x-show="open" @click.away="open = false" class="border mt-1 bg-white rounded shadow p-2 max-h-48 overflow-y-auto">
                                <template x-for="option in options" :key="option">
                                    <label class="flex items-center space-x-2 p-1 hover:bg-gray-100 cursor-pointer">
                                        <input type="checkbox" :value="option" x-model="tags">
                                        <span x-text="option"></span>
                                    </label>
                                </template>

                                <div class="border-t my-2"></div>

                                <div class="flex items-center space-x-2">
                                    <input type="text" x-model="newTag" placeholder="Add new tag" class="border rounded p-1 flex-1 text-sm">
                                    <button type="button" class="bg-blue-500 text-white px-2 py-1 rounded text-sm"
                                        @click="
                                            if(newTag && !tags.includes(newTag)) {
                                                tags.push(newTag);
                                                if(!options.includes(newTag)) options.push(newTag);
                                                newTag='';
                                            }
                                        ">
                                        Add
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="tags" :value="JSON.stringify(tags)">
                        </div>
                    </div>



                    

                    

                    <button type="submit" class="btn mt-4" name="blog_submit">Publish</button>
                </form>
            </div>
        </div>
    </section>
    

<script>

</script>
   <script>
    ClassicEditor
      .create(document.querySelector('#editor'))
      .catch(error => {
        console.error(error);
      });
    let tagslist = <?php echo json_encode($tags);?>;
    function tagSelect() {
    return {
        open: false,
        search: "",
        options:tagslist,
        selected: [],
        filteredOptions() {
        return this.options.filter(opt => 
            opt.toLowerCase().includes(this.search.toLowerCase()) && 
            !this.selected.includes(opt)
        );
        },
        addTag(tag) {
        if (!this.selected.includes(tag)) {
            this.selected.push(tag);
            if (!this.options.includes(tag)) {
            this.options.push(tag); 
            }
        }
        this.search = "";
        this.open = true; 
            },
        removeTag(index) {
        this.selected.splice(index, 1);
            }
        }
    }
    </script>

  

  
</body>
</html>