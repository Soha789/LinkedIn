<?php include 'config.php'; session_start();

if(isset($_POST['signup'])){
  $name = $_POST['name'];
  $email = $_POST['email'];
  $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $check = $conn->query("SELECT * FROM users WHERE email='$email'");
  if($check->num_rows > 0){
    $msg = "Email already exists.";
  } else {
    $conn->query("INSERT INTO users(name,email,password) VALUES('$name','$email','$pass')");
    $msg = "Account created! You can login now.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Sign Up</title>
<style>
body {font-family:Arial;background:#f3f2ef;text-align:center;}
form {
  background:white;padding:30px;width:350px;margin:100px auto;
  border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,0.1);
}
input {width:90%;padding:10px;margin:10px;border:1px solid #ccc;border-radius:4px;}
button {
  background:#0077B5;color:white;padding:10px 20px;border:none;border-radius:4px;cursor:pointer;
}
</style>
</head>
<body>
<form method="POST">
<h2>Create Account</h2>
<input type="text" name="name" placeholder="Full Name" required><br>
<input type="email" name="email" placeholder="Email" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button type="submit" name="signup">Sign Up</button>
<p style="color:green;"><?php if(isset($msg)) echo $msg; ?></p>
<p>Already have an account? <a href="login.php">Login</a></p>
</form>
</body>
</html>
