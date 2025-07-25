<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_con.php");
include("./includes/gen_nav.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit1'])) {
        $_SESSION['form1'] = $_POST;
    }
    if (isset($_POST['submit2'])) {
        $_SESSION['form2'] = $_POST;
    }
}

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
            <div class="col-2 py-2 mt-3">
                <select name="Duration" class="form-control w-50">
                    <option value="1" <?= isset($_SESSION['form1']['Duration']) && $_SESSION['form1']['Duration'] == '1' ? 'selected' : '' ?>>Select---</option>
                    <option value="1" <?= isset($_SESSION['form1']['Duration']) && $_SESSION['form1']['Duration'] == '1' ? 'selected' : '' ?>>All Time</option>
                    <option value="2" <?= isset($_SESSION['form1']['Duration']) && $_SESSION['form1']['Duration'] == '2' ? 'selected' : '' ?>>Monthly</option>
                </select>
            </div>
            <div class="col-2 py-2">
                <button type="submit" name="submit1" id="y1">Submit</button>
            </div>
        </div>
    </form>
    <!-- Income Table -->
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
            $total_income = 0;
            if (isset($_SESSION['form1']['Duration'])) {
                $select = $_SESSION['form1']['Duration'];
                if ($select == "2") {
                    $fetch_income = $db_user_name == 'admin' ? 
                        "SELECT * FROM income WHERE date BETWEEN '$month_date' and '$today_date'" : 
                        "SELECT * FROM income WHERE date BETWEEN '$month_date' and '$today_date' AND income_id='$db_user_id'";
                } else {
                    $fetch_income = $db_user_name == 'admin' ? 
                        "SELECT * FROM income" : 
                        "SELECT * FROM income WHERE income_id='$db_user_id'";
                }
            

            $run_fetch_income = mysqli_query($conn, $fetch_income);
            $counter = 1;
            $total_income = 0;
            if (mysqli_num_rows($run_fetch_income) > 0) {
                while ($row = mysqli_fetch_assoc($run_fetch_income)) {
                    echo "<tr>
                        <td>{$counter}</td>
                        <td>{$row['income_name']}</td>
                        <td>₹{$row['income_price']}</td>
                        <td>{$row['date']}</td>
                        <td>
                            <a href='./delete_income.php?d_id={$row['income_id']}'><button class='button me-3'>Delete</button></a>
                            <a href='./edit_income.php?e_id={$row['income_id']}'><button class='button px-2'>Edit</button></a>
                        </td>
                    </tr>";
                    $counter++;
                    $total_income += $row['income_price'];
                }
                echo "<tr>
                    <th colspan='4'>Total</th>
                    <th>₹{$total_income}</th>
                </tr>";
            }
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
            
        
            ?>
        </tbody>
    </table>
</div>

<div class="container">
    <form action="" method="POST">
        <div class="row">
            <div class="col-12 py-3">
                <h1 class="text-center" id="expense">Expense</h1>
            </div>
            <div class="col-8">
                <a href="./add_expense.php" class="mb-3" id="y1">Add Expense<span></span></a>
            </div>
            <div class="col-2 py-2 mt-3">
                <select name="Duration" class="form-control w-50">
                    <option value="1" <?= isset($_SESSION['form2']['Duration']) && $_SESSION['form2']['Duration'] == '1' ? 'selected' : '' ?>>Select---</option>
                    <option value="1" <?= isset($_SESSION['form2']['Duration']) && $_SESSION['form2']['Duration'] == '1' ? 'selected' : '' ?>>All Time</option>
                    <option value="2" <?= isset($_SESSION['form2']['Duration']) && $_SESSION['form2']['Duration'] == '2' ? 'selected' : '' ?>>This Month</option>
                    <option value="3" <?= isset($_SESSION['form2']['Duration']) && $_SESSION['form2']['Duration'] == '3' ? 'selected' : '' ?>>This Week</option>
                    <option value="4" <?= isset($_SESSION['form2']['Duration']) && $_SESSION['form2']['Duration'] == '4' ? 'selected' : '' ?>>Today</option>
                </select>
            </div>
            <div class="col-2 py-2">
                <button type="submit" name="submit2" id="y1">Submit</button>
            </div>
        </div>
    </form>
    <!-- Expense Table -->
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
             $db_user_id = $_SESSION['id'];
             $db_user_name = $_SESSION['name'];
            $today_date = date('Y-m-d');
            $month_date = date('Y-m-d', strtotime($today_date . "-1 month"));
            $week_date = date('Y-m-d', strtotime($today_date . "-7 days"));
           
            $total_expense = 0;
            if (isset($_SESSION['form2']['Duration'])) {
                $select = $_SESSION['form2']['Duration'];
                if ($select == "2") {
                    $fetch_expense = $db_user_name == 'admin' ? 
                        "SELECT * FROM records WHERE item_date BETWEEN '$month_date' and '$today_date' ORDER BY item_date DESC" : 
                        "SELECT * FROM records WHERE item_date BETWEEN '$month_date' and '$today_date' AND item_id='$db_user_id' ORDER BY item_date DESC";
                } else if ($select == "3") {
                    $fetch_expense = $db_user_name == 'admin' ? 
                        "SELECT * FROM records WHERE item_date BETWEEN '$week_date' and '$today_date' ORDER BY item_date DESC" : 
                        "SELECT * FROM records WHERE item_date BETWEEN '$week_date' and '$today_date' AND item_id='$db_user_id' ORDER BY item_date DESC";
                } else if ($select == "4") {
                    $fetch_expense = $db_user_name == 'admin' ? 
                        "SELECT * FROM records WHERE item_date='$today_date' ORDER BY item_date DESC" : 
                        "SELECT * FROM records WHERE item_date='$today_date' AND item_id='$db_user_id' ORDER BY item_date DESC";
                } else {
                    $fetch_expense = $db_user_name == 'admin' ? 
                        "SELECT * FROM records ORDER BY item_date DESC" : 
                        "SELECT * FROM records WHERE item_id='$db_user_id' ORDER BY item_date DESC";
                }
            

            $run_fetch_expense = mysqli_query($conn, $fetch_expense);
            $counter = 1;
            $total_expense = 0;
            if (mysqli_num_rows($run_fetch_expense) > 0) {
                while ($row = mysqli_fetch_assoc($run_fetch_expense)) {
                    echo "<tr>
                        <td>{$counter}</td>
                        <td>{$row['item_name']}</td>
                        <td>₹{$row['item_price']}</td>
                        <td>{$row['item_date']}</td>
                        <td>{$row['item_details']}</td>
                        <td>
                            <a href='./delete_expense.php?del_id={$row['id']}'><button class='button me-3'>Delete</button></a>
                            <a href='./edit_expense.php?edit_id={$row['id']}'><button class='button px-2'>Edit</button></a>
                        </td>
                    </tr>";
                    $counter++;
                    $total_expense += $row['item_price'];
                }
                echo "<tr>
                    <th colspan='5'>Total</th>
                    <th>₹{$total_expense}</th>
                </tr>";
            }
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
            
         
            ?>
        </tbody>
    </table>
</div>


<div class="container">
    <div class="row">
        <div class="col-12 py-3">
            <h1 class="text-center" id="expense">Total Balance</h1>
        </div>
    </div>
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">Total Income</th>
                <th scope="col">Total Expense</th>
                <th scope="col">Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $balance = $total_income - $total_expense;
            ?>
            <tr>
                <td><?php echo "₹" . $total_income ?></td>
                <td><?php echo "₹" . $total_expense ?></td>
                <td><?php echo "₹" . $balance ?></td>
            </tr>
            <?php
            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</div>


<?php

include("./includes/footer.php");

?>