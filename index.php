<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<title>LinkedIn Clone</title>
<style>
body {
  font-family: Arial, sans-serif;
  background: #f3f2ef;
  margin: 0;
  padding: 0;
}
.container {
  text-align: center;
  margin-top: 15%;
}
h1 {
  color: #0077B5;
  font-size: 48px;
}
p {
  color: #555;
  margin-bottom: 30px;
}
button {
  background-color: #0077B5;
  color: white;
  padding: 12px 24px;
  border: none;
  border-radius: 4px;
  margin: 5px;
  font-size: 16px;
  cursor: pointer;
}
button:hover {
  background-color: #005983;
}
</style>
<script>
function goToLogin() { window.location.href = 'login.php'; }
function goToSignup() { window.location.href = 'signup.php'; }
</script>
</head>
<body>
  <div class="container">
    <h1>Welcome to LinkedIn Clone</h1>
    <p>Connect, share, and grow your professional network.</p>
    <button onclick="goToLogin()">Login</button>
    <button onclick="goToSignup()">Sign Up</button>
  </div>
</body>
</html>
