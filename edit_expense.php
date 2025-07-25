<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/gen_nav.php");
include("./includes/db_con.php");
check_login();

$edit_id=null;
$db_item_name=null;
$db_item_price=null;
$db_item_date=null;
$db_item_details=null;

if(isset($_REQUEST['edit_id'])){
    $edit_id=$_REQUEST['edit_id'];

    $fetch_query="SELECT * FROM records where id=$edit_id";
    $run_fetch_query=mysqli_query($conn,$fetch_query);
    $row=mysqli_fetch_assoc($run_fetch_query);
    $db_item_name=$row['item_name'];
    $db_item_price=$row['item_price'];
    $db_item_date=$row['item_date'];
    $db_item_details=$row['item_details'];
}
if(isset($_REQUEST['update_item_details'])){
$update_item_name=$_REQUEST['update_item_name'];
$update_item_price=$_REQUEST['update_item_price'];
$update_item_date=$_REQUEST['update_item_date'];
$update_item_details=$_REQUEST['update_item_details'];

$update_query="UPDATE records SET item_name='$update_item_name',item_price='$update_item_price',item_date='$update_item_date',item_details='$update_item_details' WHERE id=$edit_id";
$run_update_query=mysqli_query($conn,$update_query);
if($run_update_query){
    $fetch_query = "SELECT * FROM records WHERE id=$edit_id";
        $run_fetch_query = mysqli_query($conn, $fetch_query);
        if ($run_fetch_query) {
            $row = mysqli_fetch_assoc($run_fetch_query);
            $db_item_name = $row['item_name'];
            $db_item_price = $row['item_price'];
            $db_item_date = $row['item_date'];
            $db_item_details = $row['item_details'];
    my_alert("success","Record updated successfully");
}
}
}

mysqli_close($conn);


?>

<div class="container py-3">
<h2 class="text-center display-4 fw-semibold py-3 " id="expense">Update Expense</h2>
    <form method="POST" autocomplete="off">
    <div class="row">
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label ">Name</label>
            <input type="text" class="form-control" placeholder="Item Name" name="update_item_name" value="<?php echo $db_item_name ?>">
        </div>
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label">Price</label>
            <input type="number" class="form-control" placeholder="Amount" name="update_item_price" value="<?php echo $db_item_price ?>">
        </div>
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label">Date</label>
            <input type="date" class="form-control" name="update_item_date" value="<?php echo $db_item_date ?>">
        </div>
        <div class="col-md-12 mb-3">
            <label for="" class="form-label ">Details</label>
            <input type="text" class="form-control" placeholder="Enter Details" name="update_item_details" value="<?php echo $db_item_details ?>">
        </div>
        <div class="col-md-12 mb-3">
            <button type="submit" name="add_item" id="y1" class="fw-bold">Add Expense</button>
        </div>
    </div>
    </form>
</div>


















<?php

include("./includes/footer.php");

?>