<?php
include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_con.php");
include("./includes/gen_nav.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['submit'])) {
        $_SESSION['expense_form'] = $_POST['Duration'];
    }
    if (isset($_POST['submit1'])) {
        $_SESSION['budget_form'] = $_POST['Duration1'];
    }
}

$db_user_id = $_SESSION['id'];
$db_user_name = $_SESSION['name'];
$exp_date_line = mysqli_query($conn, "SELECT item_date FROM records WHERE item_id = '$db_user_id' GROUP BY item_date");
$exp_amt_line = mysqli_query($conn, "SELECT SUM(item_price) FROM records WHERE item_id = '$db_user_id' GROUP BY item_date");
?>

<div class="container">
    <div class="row">
        <div class="col-12 py-3">
            <h1 class="text-center " id="expense">Report </h1>
        </div>
    </div>
</div>

<div style="width: 600px; height: 400px; margin: 0 auto">
    <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php while ($c = mysqli_fetch_array($exp_date_line)) {
                            echo '"' . $c['item_date'] . '",';
                        } ?>],
            datasets: [{
                label: 'Expense by Month (Whole Year)',
                data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                            echo $d['SUM(item_price)'] . ',';
                        } ?>],
                borderWidth: 1,
                fill: false,
                borderColor: 'rgba(255,0,0,1)',
                tension: 0.4
            }]
        },
        options: {
            scales: {
                x: {
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        display: false
                    },
                    border: {
                        color: 'white',
                        width: 2
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'white'
                    },
                    grid: {
                        display: false
                    },
                    border: {
                        color: 'white',
                        width: 2
                    }
                }
            },
            plugins: {
                legend: {
                    labels: {
                        color: 'white'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';

                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('en-US', {
                                    style: 'currency',
                                    currency: 'INR'
                                }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            }
        },
        plugins: [{
            beforeDraw: function(chart) {
                const ctx = chart.ctx;
                ctx.save();
                ctx.fillStyle = 'black';
                ctx.fillRect(0, 0, chart.width, chart.height);
                ctx.restore();
            }
        }]
    });
</script>


<div class="container">
    <form action="" method="POST">
        <div class="row">
            <div class="col-12 py-3">
                <h1 class="text-center " id="expense">Expense </h1>
            </div>
            <div class="col-8">
                <a href="./add_expense.php" class="mb-3" id="y1">Add Expense<span></span></a>
            </div>
            <div class="col-2 py-2 mt-3 ">
                <Select name="Duration" class="form-control w-50 ">
                    <option value="" <?= isset($_SESSION['expense_form']) && $_SESSION['expense_form'] == '1' ? 'selected' : '' ?>>Select---</option>
                    <option value="2" <?= isset($_SESSION['expense_form']) && $_SESSION['expense_form'] == '2' ? 'selected' : '' ?>>This Month</option>
                    <option value="3" <?= isset($_SESSION['expense_form']) && $_SESSION['expense_form'] == '3' ? 'selected' : '' ?>>This Week</option>
                    <option value="4" <?= isset($_SESSION['expense_form']) && $_SESSION['expense_form'] == '4' ? 'selected' : '' ?>>Today</option>
                </Select>
            </div>
            <div class="col-2 py-2 ">
                <button type="submit" name="submit" id="y1">Submit</button>
            </div>
        </div>
    </form>
</div>


<div class="container">
    <form action="" method="POST">
        <div class="row">
            <div class="col-12 py-3">
                <h1 class="text-center " id="expense">Budget </h1>
            </div>
            <div class="col-8">
                <a href="./set_budget.php" class="mb-3" id="y1">Add Budget<span></span></a>
            </div>
            <div class="col-2 py-2 mt-3 ">
                <?php
                $a = "SELECT * FROM budget";
                $result_a = mysqli_query($conn, $a);
                ?>
                <Select name="Duration1" class="form-control w-50 ">
                    <option value="">Select--</option>
                    <?php
                    while ($row = mysqli_fetch_array($result_a)) : ?>
                        <option value="<?php echo $row['id'] ?>" <?= isset($_SESSION['budget_form']) && $_SESSION['budget_form'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['budget_name'] ?></option>
                    <?php endwhile; ?>
                </Select>
            </div>
            <div class="col-2 py-2 ">
                <button type="submit" name="submit1" id="y1">Submit</button>
            </div>
        </div>
    </form>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 py-3">
            <h1 class="text-center " id="expense">Total Balance</h1>
        </div>
    </div>
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">Total Budget</th>
                <th scope="col">Total Expense</th>
                <th scope="col">Remaining Budget</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_budget = 0;
            $total_expense = 0;
            $db_user_id = $_SESSION['id'];
            $db_user_name = $_SESSION['name'];
            $today_date = date('Y-m-d');
            $month_date = date('Y-m-d', strtotime($today_date . "-1 month"));
            $week_date = date('Y-m-d', strtotime($today_date . "-7 days"));
            if (isset($_SESSION['expense_form'])) {
                $select = $_SESSION['expense_form'];
                if ($select == '') {
                    // When "Select---" is chosen, set expense to 0
                    $total_expense = 0;
                } else {
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
                if (mysqli_num_rows($run_fetch_expense) > 0) {
                    while ($row = mysqli_fetch_assoc($run_fetch_expense)) {
                        $total_expense += $row['item_price'];
                    }
                } else {
                    $total_expense=0;
                }
            }
            }

            if (isset($_SESSION['budget_form'])) {
                $selecta = $_SESSION['budget_form'];
                $fetch_budget = $db_user_name == 'admin' ? 
                    "SELECT * FROM budget WHERE id='$selecta'" : 
                    "SELECT * FROM budget WHERE id='$selecta' AND budget_id='$db_user_id'";

                $run_fetch_budget = mysqli_query($conn, $fetch_budget);
                if (mysqli_num_rows($run_fetch_budget) > 0) {
                    while ($row = mysqli_fetch_assoc($run_fetch_budget)) {
                        $total_budget += $row['budget_price'];
                    }
                }
            }

            $balance = $total_budget - $total_expense;
            $balance_color = $balance < 0 ? 'red' : 'green';
            ?>

            <tr>
                <td><?php echo "₹" . $total_budget ?></td>
                <td><?php echo "₹" . $total_expense ?></td>
                <td style="color: <?php echo $balance_color; ?>;"><?php echo "₹" . $balance ?></td>
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
