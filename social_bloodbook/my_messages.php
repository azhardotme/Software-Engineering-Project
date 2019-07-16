<?php
session_start();
include("includes/connection.php");
include("function/functions.php");

if(!isset($_SESSION['user_email'])){

	header("location: index.php");

}
else {
?>
<!DOCTYPE html>
<html>
    <head>
	    <title>Welcome User</title>
	<link rel="stylesheet" href="styles/home_style.css" media="all"/>  
    </head>
<body>
	<div class="container">
		<div id="head_wrap">
			<div id="header">
				<ul id="menu">
					<li><a href="home.php">Home</a></li>
					<li><a href="users.php">Users</a></li>
					<li><a href="donor.php">Donors</a></li>
					
				</ul>
				<form method="get" action="results.php" id="form1">
					<input type="text" name="user_query" placeholder="Search a topic"/>
					<input type="submit" name="search" value="Search"/>
				</form>
				
			</div>
			
		</div>
		<div class="content">
			<div id="user_timeline">
				<div id="user_details">
					<?php
					$user = $_SESSION['user_email'];

					$get_user = "select * from users where user_email='$user'";

					$run_user = mysqli_query($con,$get_user);
					$row=mysqli_fetch_array($run_user);

					$user_id = $row['user_id'];
					$user_name = $row['user_name']; 
					$user_blood_group = $row['user_blood_group']; 
					$user_image = $row['user_image']; 
					$user_reg_date = $row['user_reg_date']; 
					$user_last_login = $row['user_last_login'];

					$user_posts = "select * from posts where user_id='$user_id'";
					$run_posts = mysqli_query($con,$user_posts);
					$posts = mysqli_num_rows($run_posts);

					$sel_msg = "select * from messages where receiver='$user_id' AND status='unread' ORDER by 1 DESC"; 
					$run_msg = mysqli_query($con,$sel_msg);

					$count_msg = mysqli_num_rows($run_msg);

					echo "
					    <center>
					    <img src='users/$user_image' width='200' height='200'/>
					    </center>
					    <div id='user_mention'>
					    <p><strong>Name:</strong> $user_name</p>
					    <p><strong>Blood Group:</strong> $user_blood_group</p>
					    <p><strong>Last Login:</strong> $user_last_login</p>
					    <p><strong>User Since:</strong> $user_reg_date</p>

					    <p><a href='my_messages.php?inbox&u_id=$user_id'>Messages ($count_msg)</a></p>
					    <p><a href='my_posts.php?u_id=$user_id'>My Posts ($posts)</a></p>
					    <p><a href='edit_profile.php?u_id=$user_id'>Edit My Account</a></p>
					    <p><a href='logout.php'>Logout</a></p>
					    </di>
					";   
					?>
				    </div>
					
				</div>
				
			</div>
			     <div id="msg">
			     	<p align="center">
			     		<a href="my_messages.php?inbox">My Inbox</a>
			     		<a href="my_messages.php?sent">Sent Items</a>
			     	</p>

			     	<?php
			     	if (isset($_GET['sent'])) {
			     		include("sent.php");
			     	}

			     	?>
			     	<?php
			     	if (isset($_GET['inbox'])) {
			     	}

			     	?>
			     	<table width="700">
			     		<tr>
			     			<th>Sender:</th>
			     			<th>Subject:</th>
			     			<th>Date:</th>
			     			<th>Reply:</th>
			     		</tr>

			     		<?php
			     		$sel_msg = "select * from messages where receiver='$user_id' ORDER by 1 DESC";
			     		$run_msg = mysqli_query($con,$sel_msg);

			     		$count_msg = mysqli_num_rows($run_msg);

			     		while ($row_msg=mysqli_fetch_array($run_msg)) 
			     		{

			     		$msg_id = $row_msg['msg_id'];
			     		$msg_receiver = $row_msg['receiver'];
			     		$msg_sender = $row_msg['sender'];
			     		$msg_sub = $row_msg['msg_sub'];
			     		$msg_topic = $row_msg['msg_topic'];
			     		$msg_date = $row_msg['msg_date'];

			     		$get_sender = "select * from users where user_id='$msg_sender'";
			     		$run_sender = mysqli_query($con,$get_sender);
			     		$row=mysqli_fetch_array($run_sender);

			     		$sender_name = $row['user_name'];
 

			     		?>

			     		<tr align="center">
			     			<td>
			     				<a href="user_profile.php?u_id=<?php echo $msg_sender;?>" target="blank"><?php echo $sender_name;?></a>
			     			</td>
			     			<td>
			     				<a href="my_messages.php?inbox&msg_id=<?php echo $msg_id;?>"><?php echo $msg_sub;?>
			     				</a>
			     			</td>
			     			<td><?php echo $msg_date;?></td>
			     			<td><a href="my_messages.php?inbox&msg_id=<?php echo $msg_id;?>">View Reply</a></td>
			     			
			     		</tr>
			     		<?php } ?>
			     	</table>

			     	<?php
			     	if (isset($_GET['msg_id'])) {
			     		
			     		$get_id = $_GET['msg_id'];

			     		$sel_message = "select *from messages where msg_id='$get_id'";
			     		$run_message = mysqli_query($con,$sel_message);
			     		$row_message=mysqli_fetch_array($run_message);

			     		$msg_subject = $row_message['msg_sub'];
			     		$msg_topic = $row_message['msg_topic'];
			     		$msg_content = $row_message['reply'];

			     		echo "<center><br/><hr>
			     		<h2>$msg_subject</h2>
			     		<p><b>My Message:</b> $msg_topic</p>
			     		<p><b>Their Reply:</b> $msg_content</p>

			     		</center>
			     		";


			     	}

			     	?>


				  
				
			</div>
		</div>
		
	</div>

</body>
</html>
<?php } ?>
