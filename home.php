<?php include 'config.php'; session_start();
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit(); }

$user_id = $_SESSION['user_id'];
$name = $_SESSION['name'];

if(isset($_POST['post'])){
  $content = $_POST['content'];
  $conn->query("INSERT INTO posts(user_id,content) VALUES('$user_id','$content')");
}

if(isset($_POST['like'])){
  $pid = $_POST['pid'];
  $poster = $conn->query("SELECT user_id FROM posts WHERE id=$pid")->fetch_assoc()['user_id'];
  if($poster!=$user_id){
    $conn->query("INSERT INTO notifications(receiver_id,sender_name,type,post_id) VALUES('$poster','$name','like','$pid')");
  }
}

if(isset($_POST['comment'])){
  $pid = $_POST['pid'];
  $poster = $conn->query("SELECT user_id FROM posts WHERE id=$pid")->fetch_assoc()['user_id'];
  if($poster!=$user_id){
    $conn->query("INSERT INTO notifications(receiver_id,sender_name,type,post_id) VALUES('$poster','$name','comment','$pid')");
  }
}

$posts = $conn->query("SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id=users.id ORDER BY posts.id DESC");
$users = $conn->query("SELECT * FROM users WHERE id!=$user_id");
$notifs = $conn->query("SELECT * FROM notifications WHERE receiver_id='$user_id' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Home - LinkedIn Clone</title>
<style>
body {margin:0;font-family:Arial;background:#f3f2ef;}
header {background:#0077B5;color:white;padding:15px;font-size:20px;}
.container {display:flex;}
.sidebar {width:25%;background:white;padding:15px;margin:10px;border-radius:8px;}
.main {width:50%;margin:10px;}
.notifications {
  position:fixed;top:60px;right:20px;background:white;border:1px solid #ccc;
  padding:10px;border-radius:6px;width:250px;display:none;
}
.post {
  background:white;padding:15px;margin-bottom:10px;border-radius:8px;
  box-shadow:0 0 5px rgba(0,0,0,0.1);
}
textarea {width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;}
button {background:#0077B5;color:white;border:none;padding:8px 16px;border-radius:4px;margin-top:5px;}
button:hover {background:#005983;}
</style>
<script>
function toggleNotif(){
  var n=document.getElementById('notifBox');
  n.style.display = n.style.display=='block'?'none':'block';
}
</script>
</head>
<body>
<header>
  LinkedIn Clone - Welcome, <?php echo $name; ?> |
  <button onclick="toggleNotif()">🔔 Notifications</button>
  <a href="profile.php" style="color:white;margin-left:20px;">My Profile</a>
  <a href="logout.php" style="color:white;margin-left:20px;">Logout</a>
</header>

<div class="container">
  <div class="sidebar">
    <h3>People You May Know</h3>
    <?php while($u=$users->fetch_assoc()): ?>
      <p><?php echo $u['name']; ?></p>
    <?php endwhile; ?>
  </div>

  <div class="main">
    <form method="POST">
      <textarea name="content" placeholder="Start a post..." required></textarea><br>
      <button name="post">Post</button>
    </form>

    <h3>Recent Posts</h3>
    <?php while($p=$posts->fetch_assoc()): ?>
      <div class="post">
        <b><?php echo $p['name']; ?></b><br>
        <p><?php echo $p['content']; ?></p>
        <form method="POST" style="display:inline;">
          <input type="hidden" name="pid" value="<?php echo $p['id']; ?>">
          <button name="like">Like</button>
          <button name="comment">Comment</button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<div class="notifications" id="notifBox">
  <h4>Notifications</h4>
  <?php while($n=$notifs->fetch_assoc()): ?>
    <p><b><?php echo $n['sender_name']; ?></b> <?php echo $n['type']; ?>d your post.</p>
  <?php endwhile; ?>
</div>
</body>
</html>
