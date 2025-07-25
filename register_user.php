<?php
include("./includes/header.php");
include("./includes/functions.php");
if(isset($_SESSION['is_login'])){
include("./includes/gen_nav.php");
}
if(isset($_REQUEST['register'])){
    
    include("./includes/db_con.php");

    $user_name=$_REQUEST['user_name'];
    $user_pass=$_REQUEST['user_pass'];

    $enc_pass=password_hash($user_pass,PASSWORD_BCRYPT);

    $check_user_name="SELECT * FROM reg_users WHERE user_name='$user_name' ";
    $run_check=mysqli_query($conn,$check_user_name);
    if(mysqli_num_rows($run_check)>0){
      my_alert("danger","Username already exist");
    }
    else{
    $sql = "INSERT INTO reg_users (user_name, user_pass) VALUES ('$user_name','$enc_pass')";
    if (mysqli_query($conn, $sql)) {
    my_alert("success","New record created successfully");
    } else {
      my_alert("danger","Error inserting data");
    }
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
<div class="login-box">
<div class="card-header mb-4 ">
    Register User
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
           <button id="button" type="submit" name="register" class="btn me-3">
           Register
           <span></span>
           </button>
           <!-- <button id="button" type="submit" name="login" class="btn">
           Login
           <span></span>
           </button> -->
       </div>
    </center>
  </form>
</div>

<!-- <div class="visme_d" data-title="Club Membership Sign Up Form" data-url="31nek38x-club-membership-sign-up-form?fullPage=true" data-domain="forms" data-full-page="false" data-min-height="100vh" data-form-id="81268"></div><script src="https://static-bundles.visme.co/forms/vismeforms-embed.js"></script> -->

  


<?php
if(!isset($_SESSION['is_login'])){
  ?>
<div class="second">
  <form method="POST" autocomplete="off">
    </div><center>
      <div>
        <a href="./login_user.php">
           <button id="second" type="button" class="btn1">
           Go back
           <span></span>
           </button>
           </a>
       </div>
    </center>
  </form>
</div> 
<?php
}
?>

<?php

include("./includes/footer.php");

?>


