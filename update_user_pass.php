<?php

session_start();
include("./includes/functions.php");
include("./includes/db_con.php");

$update_id=null;
$db_user_name=null;

if(isset($_REQUEST['update_id'])){
    $update_id=$_REQUEST['update_id'];

    $fetch_query="SELECT user_name FROM reg_users where id=$update_id";
    $run_fetch_query=mysqli_query($conn,$fetch_query);
    $row=mysqli_fetch_assoc($run_fetch_query);
    $db_user_name=$row['user_name'];
    
}
if(isset($_REQUEST['update_pass'])){
$update_user_pass=$_REQUEST['update_user_pass'];
$enc_pass=password_hash($update_user_pass,PASSWORD_ARGON2I);
$update_query="UPDATE reg_users SET user_pass='$enc_pass' WHERE id=$update_id";
$run_update_query=mysqli_query($conn,$update_query);
if($run_update_query){
    my_alert("success","Password updated successfully");
}
else{
    my_alert("danger","Error");
}
}

mysqli_close($conn);


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


<div class="login-box">
<div class="card-header mb-4 ">
    Set New Password
  </div>
  <form method="POST" autocomplete="off">
    <div class="user-box">
    <input type="text" value="<?php echo $db_user_name ?>" disabled>
      <!-- <label>Username</label> -->
    </div>
    <div class="user-box">
    <input type="password" name="update_user_pass" required>
      <label>Password</label>
    </div><center>
      <div>
           <button id="button" type="submit" name="update_pass" class="btn">
           Update Password
           <span></span>
           </button>
       <span></span>
       </div>
    </center>
  </form>
</div>










<?php

include("./includes/footer.php");

?>