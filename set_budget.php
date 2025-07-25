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


if(isset($_REQUEST['add_budget'])){
 $budget_name=$_REQUEST['budget_name'];
 $budget_price=$_REQUEST['budget_price'];

 $sql = "INSERT INTO budget (budget_id,budget_name, budget_price) VALUES ('$user_id','$budget_name','$budget_price')";
    if (mysqli_query($conn, $sql)) {
    my_alert("success","New record created successfully");
    } else {
      my_alert("danger","Error inserting data");
    }


}



?>

<div class="container py-3">
<h2 class="text-center display-4 fw-semibold py-3 " id="expense">Set Budget</h2>
    <form method="POST" autocomplete="off">
    <div class="row">
        <div class="col-md-5 mb-3 py-2">
            <label for="" class="form-label fw-bold ">Name</label>
            <input type="text" class="form-control" placeholder="Budget Name" name="budget_name">
        </div>
        <div class="col-md-5 mb-3 py-2">
            <label for="" class="form-label fw-bold">Price</label>
            <input type="number" class="form-control" placeholder="Amount" name="budget_price">
        </div>
        <div class="col-md-12 mb-3">
            <button type="submit" name="add_budget" id="y1" class="fw-bold">Add Budget</button>
        </div>
    </div>
    </form>
</div>

<div class="container">
        <div class="row">
            <div class="col-12 py-3">
                <h1 class="text-center" id="expense">Budget</h1>
            </div>
        </div>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Budget Name</th>
                <th scope="col"> Budget Price</th>
                <th scope="col">Operations</th>
        </thead>
        <tbody>
            <?php
            $db_user_id = $_SESSION['id'];
            $db_user_name = $_SESSION['name'];
                    if ($db_user_name == 'admin') {
                        $fetch_expense = "SELECT * FROM budget";
                    } else {
                        $fetch_expense = "SELECT * FROM budget where budget_id='$db_user_id'";
                    }

                $run_fetch_expense = mysqli_query($conn, $fetch_expense);
                $counter = 1;
                $total = 0;
                if (mysqli_num_rows($run_fetch_expense) > 0) {
                    while ($row = mysqli_fetch_assoc($run_fetch_expense)) {
            ?>
                        <tr>
                            <td><?php echo $counter ?></td>
                            <td><?php echo $row['budget_name'] ?></td>
                            <td><?php echo "₹" . $row['budget_price'] ?></td>
                            <td><a href="./delete_budget.php?d_id=<?php echo $row['id'] ?>"><button class="button me-3">Delete</button></a>
                                <a href="./edit_budget.php?e_id=<?php echo $row['id'] ?>"><button class="button px-2">Edit</button></a>
                            </td>
                        </tr>
                  
                <?php
                }
            }
            else {
                ?>
                <tr>
                    <td colspan="4">
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















