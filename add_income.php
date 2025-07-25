<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/gen_nav.php");
include("./includes/db_con.php");
check_login();

$db_user_id=$_SESSION['id'];
$user_query="Select * From reg_users where id='$db_user_id'";
$run_user=mysqli_query($conn,$user_query);
$row=mysqli_fetch_assoc($run_user);
$user_id=$row['id'];

if(isset($_REQUEST['add_income'])){
 $income_name=$_REQUEST['income_name'];
 $income_price=$_REQUEST['income_price'];
 $date=$_REQUEST['date'];


 $sql = "INSERT INTO income (income_id,income_name, income_price, date ) VALUES ('$user_id','$income_name','$income_price','$date')";
    if (mysqli_query($conn, $sql)) {
    my_alert("success","New record created successfully");
    } else {
      my_alert("danger","Error inserting data");
    }
    mysqli_close($conn);

}



?>

<div class="container py-3">
<h2 class="text-center display-4 fw-semibold py-3 " id="expense">Add Income</h2>
    <form method="POST" autocomplete="off">
    <div class="row">
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label fw-bold ">Description</label>
            <input type="text" class="form-control" placeholder="Income Name" name="income_name">
        </div>
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label fw-bold ">Price</label>
            <input type="number" class="form-control" placeholder="Amount" name="income_price">
        </div>
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label fw-bold">Date</label>
            <input type="date" class="form-control" name="date">
        </div>
        <div class="col-md-12 mb-3">
            <button type="submit" name="add_income" id="y1" class="fw-bold">Add Income</button>
        </div>
    </div>
    </form>
</div>


















<?php

include("./includes/footer.php");

?>