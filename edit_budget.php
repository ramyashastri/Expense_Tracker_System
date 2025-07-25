<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/gen_nav.php");
include("./includes/db_con.php");
check_login();

$edit_id=null;
$db_budget_name=null;
$db_budget_price=null;



if(isset($_REQUEST['e_id'])){
    $edit_id=$_REQUEST['e_id'];

    $fetch_query="SELECT * FROM budget where id=$edit_id";
    $run_fetch_query=mysqli_query($conn,$fetch_query);
    $row=mysqli_fetch_assoc($run_fetch_query);
    $db_budget_name=$row['budget_name'];
    $db_budget_price=$row['budget_price'];
    
}
if(isset($_REQUEST['add_budget'])){
$update_budget_name=$_REQUEST['update_budget_name'];
$update_budget_price=$_REQUEST['update_budget_price'];

$update_query="UPDATE budget SET budget_name='$update_budget_name',budget_price='$update_budget_price' WHERE id=$edit_id";
$run_update_query=mysqli_query($conn,$update_query);
if($run_update_query){
    header("Location: set_budget.php");
}

else{
    my_alert("danger","Error");
}
}


mysqli_close($conn);


?>

<div class="container py-3">
<h2 class="text-center display-4 fw-semibold py-3 " id="expense">Update Budget</h2>
    <form method="POST" autocomplete="off">
    <div class="row">
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label ">Name</label>
            <input type="text" class="form-control" placeholder="Budget Name" name="update_budget_name" value="<?php echo $db_budget_name ?>">
        </div>
        <div class="col-md-4 mb-3 py-2">
            <label for="" class="form-label">Price</label>
            <input type="number" class="form-control" placeholder="Amount" name="update_budget_price" value="<?php echo $db_budget_price ?>">
        </div>
        <div class="col-md-12 mb-3">
            <button type="submit" name="add_budget" id="y1" class="fw-bold">Add budget</button>
        </div>
    </div>
    </form>
</div>


















<?php

include("./includes/footer.php");

?>