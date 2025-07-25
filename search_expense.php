<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_con.php");
include("./includes/gen_nav.php");

check_login();
?>

<div class="container">
    <form method="POST" >
        <div class="row">
            <div class="col-12">
            <h2 class="text-center display-4 fw-bold py-3 " id="expense">Seacrh Expenses</h2>
             </div>
                 <div class="col-5 mb-3">
                    <label for="" class="form-label fw-bold ">From</label>
                    <input type="date" class="form-control" name="from_date" max="<?php echo date("Y-m-d");?>" id="from_date" onchange="get_date()">
                </div>
                <div class="col-5 ">
                    <label for="" class="form-label fw-bold">To</label>
                    <input type="date" class="form-control" name="to_date" max="<?php echo date("Y-m-d");?>" id="to_date">
            </div>
            <div class="col-2 mb-3 align-self-end">
                    <button id="y1" type="submit" class="w-100 fw-bold" name="search">Search</button>
            </div>  
        </div>
    </form>
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
        if(isset($_REQUEST['search'])){
            $from_date= $_REQUEST['from_date'];
            $to_date= $_REQUEST['to_date'];
            $fetch_expense="SELECT * FROM records WHERE item_date BETWEEN '$from_date' and '$to_date' ORDER BY item_date DESC";
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
        }

     ?>
  </tbody>
</table>
</div>













<?php

include("./includes/footer.php");

?>