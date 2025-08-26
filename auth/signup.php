<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
  <link rel="stylesheet" href = "../style.css">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
  <div class="section flex gap-2">
    <div class="form-section">
      <div class="form-container">
        <p class="form-title" style="margin-bottom:0.85rem">Create your account</p>

        <form method="POST" action="signup.php" class="signup-form">
          <div class="form-group">
            <label for="name">Full Name</label>
            <input id="name" name="name" type="text" placeholder="Jane Doe" required />
          </div>
          <div class="form-group">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" placeholder="e.g. jane@example.com" required />
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Create a password" required />
          </div>
          <div class="checkbox-items">
            <label for="agree_terms" class="checkbox-label">
              <input id="agree_terms" name="agree_terms" type="checkbox" required />
              I agree to the Terms and Policies</a>
            </label>
          </div>
          <div class="checkbox-items">
            <label for="agree-terms"class="checkbox-label">
              <input name="subscribe" type="checkbox" />
              <span class="checkbox-custom"></span>
              Subscribe to email newsletter
            </label>
          </div>
          <button class="submit-btn btn " type="submit">Sign up</button>

          <p class="for-login-link">
            Already have an account? <a class="no-underline font-[500] text-[#3b82f6]"href="login.php">Log in</a>
          </p>

          <div class="divider flex items-center "><span>or sign up with</span></div>

          <div class="social-buttons">
            <button class="social-btn" id="microsoft"><img src="https://img.icons8.com/color/24/000000/windows-10.png" /> Microsoft</button>
            <button class="social-btn"id="google"><img src="https://img.icons8.com/color/24/000000/google-logo.png" /> Google</button>
          </div>

          <p class="privacy-note">
            This site is protected by reCAPTCHA. Google
            <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a> apply.
          </p>
        </form>
      </div>
    </div>
    <div class="signup-section">
      <div class="info-content">
        <h2>Start your journey.<br />Join our platform today.</h2>
        <a href="#">Learn more</a>
      </div>
    </div>
  </div>

</body>
</html>
