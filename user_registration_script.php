<?php
    require 'connection.php';
    session_start();
    $name= mysqli_real_escape_string($conn,$_POST['name']);
    $email=mysqli_real_escape_string($conn,$_POST['email']);
    $regex_email="/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[_a-z0-9-]+)*(\.[a-z]{2,3})$/";
    if(!preg_match($regex_email,$email)){
        echo "Incorrect email.";
        return;
    }
    $password=md5(md5(mysqli_real_escape_string($conn,$_POST['password'])));
    if(strlen($password)<6){
        echo "Password should have atleast 6 characters. ";
        return;
    }
    $conntact=$_POST['contact'];
    $city=mysqli_real_escape_string($conn,$_POST['city']);
    $address=mysqli_real_escape_string($conn,$_POST['state']);
    $duplicate_user_query="select id from users where email='$email'";
    $duplicate_user_result=mysqli_query($conn,$duplicate_user_query) or die(mysqli_error($conn));
    $rows_fetched=mysqli_num_rows($duplicate_user_result);
    if($rows_fetched>0){
        //duplicate registration
        echo "Account already exists. ";
        return;
    }
    else
    {
        $user_registration_query="insert into users(name,email,password,contact,city,address) values ('$name','$email','$password','$conntact','$city','$address')";
        //die($user_registration_query);
        $user_registration_result=mysqli_query($conn,$user_registration_query) or die(mysqli_error($conn));
        //echo "User successfully registered";
        $_SESSION['email']=$email;
        //The mysqli_insert_id() function returns the id (generated with AUTO_INCREMENT) used in the last query.
        $_SESSION['id']=mysqli_insert_id($conn); 
        echo 1;  //for redirecting
       
    }
    
