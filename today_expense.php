<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_con.php");
include("./includes/gen_nav.php");

?>
<div class="container">
    <div class="row">
        <div class="col-12 py-3">
            <h1 class="text-center " id="expense">Expense Dashboard</h1>
        </div>
        <div class="col-12">
            <a href="./add_expense.php" class="mb-3" id="y1">Add Expense<span></span></a>
        </div>
    </div>
<table class="table table-bordered table-striped table-hover">
  <thead class="table-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Date</th>
      <th scope="col">Details</th>
      <th scope="col">Operations</th>
    </tr>
  </thead>
  <tbody>
    <?php
        $db_user_id=$_SESSION['id'];
        $db_user_name=$_SESSION['name'];
        $today_date=date("Y-m-d");
        if($db_user_name=='admin'){
            $fetch_expense="SELECT * FROM records WHERE item_date='$today_date' ORDER BY item_date DESC";
        }
        else{
        $fetch_expense="SELECT * FROM records WHERE item_date='$today_date' AND item_id='$db_user_id' ORDER BY item_date DESC";
        }
        $run_fetch_expense=mysqli_query($conn,$fetch_expense);
        $counter=1;
        $total=0;
        if(mysqli_num_rows($run_fetch_expense)>0){
            while($row=mysqli_fetch_assoc($run_fetch_expense)){
            ?>          
                <tr>
                <td><?php echo $counter ?></td>
                <td><?php echo $row['item_name'] ?></td>
                <td><?php echo "₹".$row['item_price'] ?></td>
                <td><?php echo $row['item_date'] ?></td>
                <td><?php echo $row['item_details'] ?></td>
                <td><a href="./delete_today.php?del_id=<?php echo $row['id'] ?>"><button class="button me-3">Delete</button></a>
                    <a href="./edit_expense.php?edit_id=<?php echo $row['id'] ?>"><button class="button px-2">Edit</button></a>
                </td>
                </tr>
            <?php
                 $counter++;
                 $total=$total+$row['item_price'];
            }
            ?>
            <tr>
                <th colspan="5">Total</th>
                <th><?php echo "₹".$total ?></th>
            </tr>
            <?php
        }
        else{
            ?>
            <tr>
                <td colspan="6">
                    <h3 class="text-center text-danger">No Record Found</h3>
                </td>
                </tr> 
            <?php
        }
        mysqli_close($conn);
     ?>
  </tbody>
</table>
</div>
<?php

include("./includes/footer.php");

?>