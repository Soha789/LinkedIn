<?php include 'config.php'; session_start();
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit(); }

$uid = $_SESSION['user_id'];

if(isset($_POST['update'])){
  $name = $_POST['name'];
  $bio = $_POST['bio'];
  $conn->query("UPDATE users SET name='$name', bio='$bio' WHERE id='$uid'");
  $_SESSION['name']=$name;
}

$user = $conn->query("SELECT * FROM users WHERE id='$uid'")->fetch_assoc();
$posts = $conn->query("SELECT * FROM posts WHERE user_id='$uid' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<style>
body {font-family:Arial;background:#f3f2ef;margin:0;}
header {background:#0077B5;color:white;padding:15px;}
.container {width:60%;margin:40px auto;background:white;padding:20px;border-radius:8px;}
input,textarea {width:100%;padding:8px;margin:6px 0;border:1px solid #ccc;border-radius:4px;}
button {background:#0077B5;color:white;padding:10px 20px;border:none;border-radius:4px;}
.post {background:#fafafa;padding:10px;margin-top:10px;border-radius:6px;}
</style>
</head>
<body>
<header>My Profile | <a href="home.php" style="color:white;">Home</a> | <a href="logout.php" style="color:white;">Logout</a></header>
<div class="container">
  <h2><?php echo $user['name']; ?></h2>
  <p><?php echo $user['bio']; ?></p>

  <h3>Edit Profile</h3>
  <form method="POST">
    <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
    <textarea name="bio" placeholder="Your bio..."><?php echo $user['bio']; ?></textarea>
    <button name="update">Update</button>
  </form>

  <h3>Your Posts</h3>
  <?php while($p=$posts->fetch_assoc()): ?>
    <div class="post">
      <p><?php echo $p['content']; ?></p>
    </div>
  <?php endwhile; ?>
</div>
</body>
</html>
