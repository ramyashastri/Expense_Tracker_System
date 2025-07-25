<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_con.php");
include("./includes/gen_nav.php");

?>
<div class="container">
    <form action="" method="POST">
        <div class="row">
            <div class="col-12 py-3">
                <h1 class="text-center" id="expense">Income</h1>
            </div>
            <div class="col-8">
                <a href="./add_income.php" class="mb-3" id="y1">Add Income<span></span></a>
            </div>
            <div class="col-2 py-2 mt-3 ">
                <Select name="Duration" class="form-control w-50 ">
                    <option value="1">Select---</option>
                    <option value="1">All Time</option>
                    <option value="2">Monthly</option>
                </Select>
            </div>
            <div class="col-2 py-2 ">
                <button type="submit" name="submit" id="y1">Submit</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Date</th>
                <th scope="col">Operations</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $db_user_id = $_SESSION['id'];
            $db_user_name = $_SESSION['name'];
            $today_date = date('Y-m-d');
            $month_date = date('Y-m-d', strtotime($today_date . "-1 month"));
            if (isset($_REQUEST['submit'])) {
                $select = $_POST['Duration'];
                if ($select == "2") {
                    if ($db_user_name == 'admin') {
                        $fetch_expense = "SELECT * FROM income where date BETWEEN '$month_date' and '$today_date'";
                    } else {
                        $fetch_expense = "SELECT * FROM income Where date BETWEEN '$month_date' and '$today_date' AND income_id='$db_user_id'";
                    }
                } else {
                    if ($db_user_name == 'admin') {
                        $fetch_expense = "SELECT * FROM income";
                    } else {
                        $fetch_expense = "SELECT * FROM income Where income_id='$db_user_id'";
                    }
                }

                $run_fetch_expense = mysqli_query($conn, $fetch_expense);
                $counter = 1;
                $total = 0;
                if (mysqli_num_rows($run_fetch_expense) > 0) {
                    while ($row = mysqli_fetch_assoc($run_fetch_expense)) {
            ?>
                        <tr>
                            <td><?php echo $counter ?></td>
                            <td><?php echo $row['income_name'] ?></td>
                            <td><?php echo "₹" . $row['income_price'] ?></td>
                            <td><?php echo $row['date'] ?></td>
                            <td><a href="./delete_income.php?d_id=<?php echo $row['id'] ?>"><button class="button me-3">Delete</button></a>
                                <a href="./edit_income.php?e_id=<?php echo $row['id'] ?>"><button class="button px-2">Edit</button></a>
                            </td>
                        </tr>
                    <?php
                        $counter++;
                        $total = $total + $row['income_price'];
                    }
                    ?>
                    <tr>
                        <th colspan="4">Total</th>
                        <th><?php echo "₹" . $total ?></th>
                    </tr>
                <?php
                }
            } 
            else if(!isset($_REQUEST['submit'])) {
                if ($db_user_name == 'admin') {
                    $fetch_expense = "SELECT * FROM income";
                } else {
                    $fetch_expense = "SELECT * FROM income Where income_id='$db_user_id'";
                }
            

            $run_fetch_expense = mysqli_query($conn, $fetch_expense);
            $counter = 1;
            $total = 0;
            if (mysqli_num_rows($run_fetch_expense) > 0) {
                while ($row = mysqli_fetch_assoc($run_fetch_expense)) {
        ?>
                    <tr>
                        <td><?php echo $counter ?></td>
                        <td><?php echo $row['income_name'] ?></td>
                        <td><?php echo "₹" . $row['income_price'] ?></td>
                        <td><?php echo $row['date'] ?></td>
                        <td><a href="./delete_income.php?d_id=<?php echo $row['id'] ?>"><button class="button me-3">Delete</button></a>
                            <a href="./edit_income.php?e_id=<?php echo $row['id'] ?>"><button class="button px-2">Edit</button></a>
                        </td>
                    </tr>
                <?php
                    $counter++;
                    $total = $total + $row['income_price'];
                }
                ?>
                <tr>
                    <th colspan="4">Total</th>
                    <th><?php echo "₹" . $total ?></th>
                </tr>
            <?php
            }
        }
            else {
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