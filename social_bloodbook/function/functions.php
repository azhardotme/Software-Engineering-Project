<?php

$con = mysqli_connect("localhost","root","","software_project") or die ("Connection was not established");
   


   function insertPost() {

   	if(isset($_POST['sub'])){
   		global $con;
   		global $user_id;
      
   		$title = addslashes($_POST['title']);
   		$content = addslashes($_POST['content']);

   		if($content=='' OR $title==''){

   		echo "<h2>Please enter title and description</h2>";

   		exit();

   		}
   		else{

   		$insert = "insert into posts (user_id,post_title,post_content,post_date) values ('$user_id','$title','$content',NOW())";

   		$run = mysqli_query($con,$insert);

   		   if($run){
   		   	echo "<h3>Posted to timeline, Looks great!</h3>";

   		   	$update = "update users set posts='yes' where user_id='$user_id'";
   		   	$run_update = mysqli_query($con,$update);
   		   }

   		}
   	}
   }


     function get_posts() {

 	 global $con;
  

 	 $per_page=5;

 	 if (isset($_GET['page'])) {
 	 $page = $_GET['page'];
 	 	
 	 }
 	 else {
 	 $page=1;
 	 }
 	 $start_from = ($page-1) * $per_page;

 	 $get_posts = "select * from posts ORDER by 1 DESC LIMIT $start_from, $per_page";

 	 $run_posts = mysqli_query($con,$get_posts);

 	 while($row_posts=mysqli_fetch_array($run_posts)) {

 	 	$post_id = $row_posts['post_id'];
 	 	$user_id = $row_posts['user_id']; 
 	 	$post_title = $row_posts['post_title'];
 	 	$content = substr($row_posts['post_content'],0,350);
 	 	$post_date = $row_posts['post_date'];

 	 	$user = "select * from users where user_id='$user_id' AND posts='yes'";

 	 	$run_user = mysqli_query($con,$user);
 	 	$row_user=mysqli_fetch_array($run_user);
 	 	$user_name = $row_user['user_name'];
 	 	$user_image = $row_user['user_image'];

 	 	echo "<div id='posts'>

 	 	<p><img src='users/$user_image' width='50' height='50'></p>
 	 	<h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
 	 	<h3>$post_title</h3>
    <p>$post_date</p>
    <p>$content</p>
    <a href='single.php?post_id=$post_id' style='float:right;'><button>See Replies or Reply to This</button></a>

    </div><br/>
 	 	";  

 	 }
 	 include("pagination.php");
 }

 function single_post(){

 if(isset($_GET['post_id'])){

  global $con;

  $get_id = $_GET['post_id'];

  $get_posts = "select *from posts where post_id='$get_id'";

  $run_posts = mysqli_query($con,$get_posts);

  $row_posts=mysqli_fetch_array($run_posts);

      $post_id = $row_posts['post_id'];
      $user_id = $row_posts['user_id']; 
      $post_title = $row_posts['post_title'];
      $content = $row_posts['post_content'];
      $post_date = $row_posts['post_date'];

      $user = "select * form users where user_id='$user_id' AND posts='yes'";

      $run_user = mysqli_query($con,$user);
      $row_user=mysqli_fetch_array($run_user);
      $user_name = $row_user['user_name'];
      $user_image = $row_user['user_image'];

      
      $user_com = $_SESSION['user_email'];
      $get_com = "select * from users where user_email='$user_com'";
      $run_com = mysqli_query($con,$get_com);
      $row_com=mysqli_fetch_array($run_com);
      $user_com_id = $row_com['user_id'];
      $user_com_name = $row_com['user_name'];

      echo "<div id='posts'>

      <p><img src='users/$user_image' width='50' height='50'></p>
      <h3><a href='user_profile.php?user_id=$user_id'>$user_name</a></h3>
      <h3>$post_title</h3>
      <p>$post_date</p>
      <p>$content</p>

      </div>

      ";
  
    
      include("comments.php");

      echo "
      <form action='' method='post' id='reply'>
      <textarea cols='50' rows='5' name='comment' placeholder='write your reply'></textarea></br>
      <input type='submit' name='reply' value='Reply to This'/>
      </form>
      ";

      if(isset($_POST['reply'])){

        $comment = $_POST['comment'];

        $insert = "insert into comments
        (post_id,user_id,comment,com_author,date) values('$post_id','$user_id','$comment','$user_com_name',NOW())";

        $run = mysqli_query($con,$insert);

        echo "<h2>Your Reply was added!</h2>";

      }


}

}
 

 function users(){

  global $con;

  $user = "select * from users";

  $run_user = mysqli_query($con,$user);

  echo"<br/><h2>See all users here</h2><br>";
  while ($row_user=mysqli_fetch_array($run_user)){

    $user_id = $row_user['user_id'];
    $user_name = $row_user['user_name'];
    $user_image = $row_user['user_image'];

    echo"
    <span>
    <a href='user_profile.php?u_id=$user_id'>
    <img src='users/$user_image' width='50' height='50' title='$user_name' style='float:left; margin: 1px;'/>
    </a>
    </span>
    ";
  }

 }

 function donors(){

  global $con;

  $user = "select * from users";

  $run_user = mysqli_query($con,$user);

  echo"<br/><h2>See all donors here</h2><br>";
  while ($row_user=mysqli_fetch_array($run_user)){

    $user_id = $row_user['user_id'];
    $user_name = $row_user['user_name'];
    $user_image = $row_user['user_image'];

    echo"
    <span>
    <a href='user_profile.php?u_id=$user_id'>
    <img src='users/$user_image' width='50' height='50' title='$user_name' style='float:left; margin: 1px;'/>
    </a>
    </span>
    ";
  }

 }

 function user_posts(){

  global $con;

  if(isset($_GET['u_id'])){
  $u_id = $_GET['u_id'];
  }
  $get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 5";

  $run_posts = mysqli_query($con,$get_posts);

  while($row_posts=mysqli_fetch_array($run_posts)){

    $post_id = $row_posts['post_id'];
    $user_id = $row_posts['user_id'];
    $post_title = $row_posts['post_title'];
    $content = $row_posts['post_content'];
    $post_date = $row_posts['post_date'];

    $user = "select * from users where user_id='$user_id' AND posts='yes'";

    $run_user = mysqli_query($con,$user);
    $row_user = mysqli_fetch_array($run_user);
    $user_name = $row_user['user_name'];
    $user_image = $row_user['user_image'];

    echo "<div id='posts'>

    <p><img src='users/$user_image' width='50' height='50'></p>
    <h3><a href='user_profile.php?u_id=$user_id'>$user_name</a></h3>
    <h3>$post_title</h3>
    <p>$post_date</p>
    <p>$content</hp>
    <a href='single.php?post_id=$post_id'
    style='float:right;'><button>View</button></a>
    <a href='edit_post.php?post_id=$post_id'
    style='float:right;'><button>Edit</button></a>
    <a href='functions/delete_post.php?post_id=$post_id'
    style='float:right;'><button>Delete</button></a>

    </div></br>
    ";

    include("delete_post.php");
  }
  }

  function user_profile() {

    if (isset($_GET['u_id'])) {

      global $con;

      $user_id = $_GET['u_id'];

      $select = "select * from users where user_id='$user_id'";
      $run = mysqli_query($con,$select);
      $row=mysqli_fetch_array($run);

      $id = $row['user_id'];
      $image = $row['user_image'];
      $name = $row['user_name'];
      $blood = $row['user_blood_group'];
      $gender = $row['user_gender'];
      $last_login = $row['user_last_login'];
      $reg_date = $row['user_reg_date'];

      if ($gender=='Male') {
        $msg="Send him a message"; 
      }
      else{
        $msg="Send her a message";
      }

      echo "<div id ='user_profile'>

      <img src='users/$image' width='150' height='150'/><br/>
      <p><strong>Name:</strong> $name </p><br/>
      <p><strong>Gender:</strong> $gender </p><br/>
      <p><strong>Blood Group:</strong> $blood </p><br/>
      <p><strong>Last Login:</strong> $last_login </p><br/>
      <p><strong>User Since:</strong> $reg_date </p><br/>
      <a href='messages.php?u_id=$id'><button>$msg</button></a><br/>
      </div>

      ";

      
    }
  }


  ?>