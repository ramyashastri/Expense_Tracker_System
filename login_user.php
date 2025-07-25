<?php
session_start();
include("./includes/functions.php");


if(isset($_REQUEST['login'])){
    
    include("./includes/db_con.php");

    $user_name=$_REQUEST['user_name'];
    $user_pass=$_REQUEST['user_pass'];
    $login_query="SELECT * FROM reg_users WHERE user_name='$user_name' ";
    $run_login_query=mysqli_query($conn,$login_query);
    if(mysqli_num_rows($run_login_query)==1){
        $row=mysqli_fetch_assoc($run_login_query);
            $db_user_id=$row['id'];
            $db_user_name=$row['user_name'];
            $db_user_pass=$row['user_pass'];
        if(password_verify($user_pass,$db_user_pass)){
            $_SESSION['name']=$db_user_name;
            $_SESSION['id']=$db_user_id;
            $_SESSION['is_login']=true;
            if($user_pass=='admin123'&& $db_user_name=='admin'){
            // my_alert("success","Login Successfull");
            $_SESSION['is_admin']=true;
            header("Location: index.php");
            }
            else{
              header("Location: user_page.php");

            }
        }
        
        else{
            my_alert("danger","Incorrect password");
        }   
    }
    else{
        my_alert("danger","User not found");
    }
    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Bootstrap icons cdn-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap css cdn-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
    <title>Register</title>
</head>
<body class="d">



<!-- <div class="container">
<div class="card login-box">
  <div class="card-header">
    Register User
  </div>
  <div class="card-body">
    <div class="col-12">
        <form method="POST">
        <div class="user-box mb-3">
             <label for="" class="form-label" >Username</label>
             <input type="text" name="user_name" class="form-control" required>
        </div>
        <div class="user-box mb-3">
            <label for="" class="form-label">Password</label>
            <input type="password" name="user_pass" class="form-control" required>
        </div>
        <div class="mb-3">
            <button type="submit" name="register" class="btn">Register</button>
        </div>
        </form>
    </div>
  </div>
</div>
</div>   -->

<div class="login-box1">
<div class="card-header mb-4 ">
    Login Form
  </div>
  <form method="POST" autocomplete="off">
    <div class="user-box">
    <input type="text" name="user_name" required>
      <label>Username</label>
    </div>
    <div class="user-box">
    <input type="password" name="user_pass" required>
      <label>Password</label>
    </div><center>
      <div>
           <!-- <button id="button" type="submit" name="register" class="btn me-3">
           Register
           <span></span>
           </button> -->
           <button id="button" type="submit" name="login" class="btn">
           Login
           <span></span>
           </button>
       </div>
    </center>
  </form>
</div> 



<div class="mycard1">
<div class="card-header mb-2">
    NO ACCOUNT ? 
  </div>
  <form method="POST" autocomplete="off">
    </div><center>
      <div>
        <a href="./register_user.php">
           <button id="b" type="button" class="btn1">
           Register
           <span></span>
           </button>
           </a>
       </div>
    </center>
  </form>
</div> 





<?php

include("./includes/footer.php");

?>


