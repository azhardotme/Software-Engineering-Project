<?php
include("includes/connection.php");

    if(isset($_POST['sign_up'])){

    $name = mysqli_real_escape_string ($con,$_POST['u_name']);
    $email = mysqli_real_escape_string ($con,$_POST['u_email']);
    $pass = mysqli_real_escape_string ($con,$_POST['u_pass']);
    $blood = mysqli_real_escape_string ($con,$_POST['u_blood_group']);
    $gender = mysqli_real_escape_string ($con,$_POST['u_gender']);
    $birthday = mysqli_real_escape_string ($con,$_POST['u_birthday']);
    $status = "unverified";
    $posts = "no";
    $ver_code = mt_rand();

    if(strlen($pass)<8){

    echo "<script>alert('Password should be minimum 8 characters!')</script>";
    exit();	
    }

    $check_email = "select * from users where user_email='$email'";
    $run_email = mysqli_query($con,$check_email);

    $check = mysqli_num_rows($run_email);

    if($check==1){

    echo "<script>alert('Email already exist, please try another!')</script>";
    exit();
    }

   $insert = "insert into users
   (user_name,user_email,user_pass,user_blood_group,user_gender,user_birthday,user_image,user_reg_date,user_last_login,status,ver_code,posts) values ('$name','$email','$pass','$blood','$gender','$birthday','default.jpg',NOW(),NOW(),'$status','$ver_code','$posts')";

    $query = mysqli_query($con,$insert);

    if($query){
       
    echo "<h3 style='width:500px; text-align:justify; color:green;'>Hi, $name congratulations, registrationn is almost complete, please check your email for final verification.</h3>";


    }
    else {

    echo "Registration failed, try again!";	
    }
}

?>