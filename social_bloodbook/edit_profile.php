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
	<style>
	input[type='file']{width:200px;}
    </style>  
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
					$user_email = $row['user_email'];
					$user_pass = $row['user_pass']; 
					$user_blood_group = $row['user_blood_group'];
					$user_gender = $row['user_gender']; 
					$user_image = $row['user_image']; 
					$user_reg_date = $row['user_reg_date']; 
					$user_last_login = $row['user_last_login'];

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

					    <p><a href='my_messages.php?inbox& u_id=$user_id'>Messages ($count_msg)</a></p>
					    <p><a href='my_posts.php?u_id=$user_id'>My Posts (3)</a></p>
					    <p><a href='edit_profile.php?u_id=$user_id'>Edit My Account</a></p>
					    <p><a href='logout.php'>Logout</a></p>
					    </di>
					";   
					?>
				    </div>
					 
				</div>
				
			</div>
			     <div id="content_timeline">

				    <form action="" method="post" id="f" class="ff" enctype="multipart/form-data">
				    <table>
				    	<tr align="center">
				    		<td colspan="7"><h2>Edit Your Profile:</h2></td>
				    	</tr>
				    	<tr>
				    		<td align="right">Name:</td>
				    		<td>
				    			<input type="text" name="u_name" required="required" value="<?php echo $user_name;?>"/>
				    		</td>

				    	</tr>

				    	<tr>
				    		<td align="right">Email:</td>
				    		<td>
				    			<input type="email" name="u_email" required="required" value="<?php echo $user_email;?>">
				    		</td>
				    	</tr>
				    	<tr>
				    		<td align="right">Password:</td>
				    		<td>
				    			<input type="password" name="u_pass" required="required" value="<?php echo $user_pass;?>"/>
				    		</td>
				    	</tr>
				    	<tr>
				    		<td align="right">Blood Group:</td>
				    		<td>
				    			<select name="u_blood_group" disabled="disabled">
				    				<option><?php echo $user_blood_group;?></option>
				    				<option>A+</option>
                                    <option>A-</option>
                                    <option>B+</option>
                                    <option>B-</option>
                                    <option>O-</option>
                                    <option>O+</option>
                                    <option>AB+</option>
                                    <option>AB-</option>
				    			</select>
				    		</td>
				    	</tr>
				    	<tr>
				    		<td align="right">Gender:</td>
				    		<td>
				    			<select name="u_gender" disabled="disabled">
				    				<option><?php echo $user_gender;?></option>
				    				<option>Male</option>
                                    <option>Female</option>
				    				
				    			</select>
				    		</td>
				    	</tr>
				    	<tr>
				    		<td align="right">Photo:</td>
				    		<td><input type="file" name="u_image" required="required"/></td>

				    		
				    	</tr>
				    	<tr align="center">
				    		<td colspan="7">
				    			<input type="submit" name="update" value="Update"/>
				    		</td>
				    	</tr>
				    </table>
				</form> 
<?php
    if(isset($_POST['update'])) {

    	$u_name = $_POST['u_name'];
    	$U_email = $_POST['U_email'];
    	$u_pass = $_POST['u_pass'];
    	$u_image = $_FILES['u_image']['name'];
    	$image_tmp = $_FILES['u_image']['tmp_name'];

    	move_uploaded_file($image_tmp,"users/$u_image");

    	$update = "update users set user_name='$u_name',user_email='$u_email',user_pass='$u_pass',user_image='$u_image' where user_id='$user_id'";

    	$run = mysqli_query($con,$update);

    	if($run) {

    		echo "<script>alert('Your Profile Updated!')</script>";
    		echo "<script>window.open('home.php','_self')</script>";
    	}
    	
    }

    ?>				


			</div>
		</div>
		
	</div>

</body>
</html>
<?php } ?>
