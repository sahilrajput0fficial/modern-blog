<?php
session_start();
require '../db.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password==$row['password']) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: ../index.php");
            exit();
        } else {
            echo "Invalid login!";
        }
    } else {
        echo "No user found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link rel="stylesheet" href="../style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div class="section grid grid-cols-1 lg:grid-cols-2 min-h-screen">
    <div class="signup-section lg:col-span-1">
      <div class="info-content">
        <img src="../uploads/login.png" alt="login.png">
      </div>
    </div>

    <div class="form-section lg:col-span-1 bg-white flex flex-col justify-start w-full h-full p-10">
      <p class="text-4xl text-center text-[#970747] font-semibold p-3">Welcome Back to ModernBlog</p>
      <div class="form-container">
        <p class="form-title" style="margin-bottom:0.85rem">Log in to your account</p>

        <form method="POST" action="login.php" class="login-form">
          <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" placeholder="e.g. jane@example.com" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Enter your password" required />
          </div>
          
          <button class="submit-btn btn mt-2" type="submit" name="login">Login</button>

          <p class="for-login-link">
            Don’t have an account? <a class="no-underline font-[500] text-[#3b82f6]" href="signup.php">Sign up</a>
          </p>

          <div class="divider flex items-center"><span>or login with</span></div>

          <div class="social-buttons grid grid-cols-1">
            <button class="social-btn" id="microsoft"><img src="https://img.icons8.com/color/24/000000/windows-10.png" /> Login with Microsoft</button>
            <button class="social-btn" id="google"><img src="https://img.icons8.com/color/24/000000/google-logo.png" /> Login with Google</button>
          </div>

          <p class="privacy-note">
            This site is protected by reCAPTCHA. Google
            <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a> apply.
          </p>
        </form>
      </div>
    </div>
    

  </div>
</body>
</html>
