<?php
session_start();

include('classes/connect.php');
include('classes/login2.php');
include('classes/user.php');
include('classes/post.php');

//check if user is logged in
if(isset($_SESSION['sharespace_id']) && is_numeric($_SESSION['sharespace_id'])){
  $id = $_SESSION['sharespace_id'];
  $login = new Login();
  $result = $login->check_login($id);

  if($result){
    //if everything is okay we retrive data
    $user = new User();
    $user_data = $user-> get_data($id);

    if(!$user_data){
      header("Location: login.php");
      die;
    }
  }
  else{
    header("Location: login.php");
    die;
  }
}
else{
  header("Location: login.php");
  die;
}
//post code
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $post = new Post();
  $id = $_SESSION['sharespace_id'];
  $result = $post->create_post($id,$_POST);//posts is an array with rows of posts
  //if nothing goes wrong
  if($result == ""){
    header("Location: profilepage.php");
    die;
  }
  //if there is an error
  else{
    echo "The following errors occured: ";
    echo $result;
  }
}
//collect posts
$post = new Post();
$id = $_SESSION['sharespace_id'];

$posts = $post->get_posts($id);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile Page</title>
  <link rel="stylesheet" href="profilepage.css">
  <script defer src="profilepage.js"></script>
</head>
<body>
<div id='bar'> 
 <div id="in-bar" style="margin: auto;width: 800px;font-size:20px;">
    <h1>ShareSpace</h1>&nbsp &nbsp &nbsp
    <input type="text" id="search" placeholder="Search here">
    <a href="logout.php"><span style = "color: black;float: right; margin: 10px;">Logout</span></a>
  </div>
</div>
<div id="profilePic">
  <span>
  <img id="profile_pic">
  <a href="changeImage.php"> <button>Change Image</button></a>
  </span>
</div>
<div id='main'>
<div id='side'>
  <button type="button" class="collapsible">Friends</button>
<div class="content">
  <p>Lorem ipsum...</p>
</div>
<button type="button" class="collapsible">About</button>
<div class="content">
  <p>Lorem ipsum...</p>
</div>
</div>
<div id='posts'>
  <h1><?php echo $user_data['username'] ?></h1>
  <div style="border: solid black; padding: 10px; min-height: 400px;">
  <form method="post">
    <textarea name="post_text" placeholder="What's on your mind?"></textarea>
    </div>
    <input id="post_button" type = "submit" value="Post">
  </form>
  <h1>Posts</h1>
  <!--posts display here-->
  <?php
  if($posts){
    foreach($posts as $row){
      $user = new User();
      $row_user = $user-> get_user($row['id']);
      $row_username = $user->get_username($row['username']?? "");
      include("posts.php");
    }
  }
  ?>
</div>
</div>
</body>
</html>