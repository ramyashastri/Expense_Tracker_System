<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/gen_nav.php");
include("./includes/db_con.php");
check_login();

$edit_id=null;
$db_income_name=null;
$db_income_price=null;
$db_income_date=null;


if(isset($_REQUEST['e_id'])){
    $edit_id=$_REQUEST['e_id'];

    $fetch_query="SELECT * FROM income where id=$edit_id";
    $run_fetch_query=mysqli_query($conn,$fetch_query);
    $row=mysqli_fetch_assoc($run_fetch_query);
    $db_income_name=$row['income_name'];
    $db_income_price=$row['income_price'];
    $db_income_date=$row['date'];
    
}
if(isset($_REQUEST['add_income'])){
$update_item_name=$_REQUEST['update_income_name'];
$update_item_price=$_REQUEST['update_income_price'];
$update_item_date=$_REQUEST['update_income_date'];


$update_query="UPDATE income SET income_name='$update_item_name',income_price='$update_item_price',date='$update_item_date' WHERE id=$edit_id";
$run_update_query=mysqli_query($conn,$update_query);
if($run_update_query){
    $fetch_query = "SELECT * FROM income WHERE id=$edit_id";
        $run_fetch_query = mysqli_query($conn, $fetch_query);
        if ($run_fetch_query) {
            $row = mysqli_fetch_assoc($run_fetch_query);
            $db_income_name = $row['income_name'];
            $db_income_price = $row['income_price'];
            $db_income_date = $row['date'];
    my_alert("success","Record updated successfully");
}
}
else{
    my_alert("danger","Error");
}
}

mysqli_close($conn);


?>

<div class="container py-3">
<h2 class="text-center display-4 fw-semibold py-3 " id="expense">Update income</h2>
    <form method="POST" autocomplete="off">
    <div class="row">
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label ">Name</label>
            <input type="text" class="form-control" placeholder="Income Name" name="update_income_name" value="<?php echo $db_income_name ?>">
        </div>
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label">Price</label>
            <input type="number" class="form-control" placeholder="Amount" name="update_income_price" value="<?php echo $db_income_price ?>">
        </div>
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label">Date</label>
            <input type="date" class="form-control" name="update_income_date" value="<?php echo $db_income_date ?>">
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