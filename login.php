<?php include 'config.php'; session_start();

if(isset($_POST['login'])){
  $email = $_POST['email'];
  $pass = $_POST['password'];
  $res = $conn->query("SELECT * FROM users WHERE email='$email'");
  if($res->num_rows>0){
    $row = $res->fetch_assoc();
    if(password_verify($pass,$row['password'])){
      $_SESSION['user_id']=$row['id'];
      $_SESSION['name']=$row['name'];
      header("Location: home.php");
    } else {$msg="Incorrect password.";}
  } else {$msg="User not found.";}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
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
<h2>Login</h2>
<input type="email" name="email" placeholder="Email" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button type="submit" name="login">Login</button>
<p style="color:red;"><?php if(isset($msg)) echo $msg; ?></p>
<p>New user? <a href="signup.php">Sign up</a></p>
</form>
</body>
</html>
