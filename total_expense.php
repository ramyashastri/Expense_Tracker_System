<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/gen_nav.php");
include("./includes/db_con.php");
check_login();


?>

<div class="container py-4 ">
    <h2 class="text-center display-4 fw-semibold py-3" id="expense">Date Wise Expense</h2>
    <div class="row ">
        <div class="col-xl-5 col-lg-6 me-5">
            <a href="./today_expense.php">
            <div class="card l-bg-cherry">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon fa-5x"><i class="fas fa-shopping-cart"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Today</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                            <?php
                                $db_user_id=$_SESSION['id'];
                                $db_user_name=$_SESSION['name'];
                                $today_date=date("Y-m-d");
                                if($db_user_name=='admin'){
                                    $user_query="SELECT * FROM records WHERE item_date='$today_date' ORDER BY item_date DESC";
                                }
                                else{
                                $user_query="SELECT * FROM records WHERE item_date='$today_date' AND item_id='$db_user_id' ORDER BY item_date DESC";
                                }
                                $run=mysqli_query($conn,$user_query);
                                echo mysqli_num_rows($run);
                                ?>
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>12.5% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <!-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> -->
                </div>
            </div>
            </a>
        </div>
       
         <div class="col-xl-5 col-lg-6 me-5 ">
         <a href="./yesterday_expense.php">
            <div class="card l-bg-blue-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon fa-5x"><i class="fas fa-users"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Yesterday</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                            <?php    
                            $db_user_id=$_SESSION['id'];
                            $db_user_name=$_SESSION['name'];
                            $yesterday_date=date('Y-m-d',strtotime("-1 days"));
                            if($db_user_name=='admin'){
                                $user_query="SELECT * FROM records WHERE item_date='$yesterday_date' ORDER BY item_date DESC";
                            }
                            else{
                            $user_query="SELECT * FROM records WHERE item_date='$yesterday_date' AND item_id='$db_user_id' ORDER BY item_date DESC";
                            }
                            $run=mysqli_query($conn,$user_query);
                            echo mysqli_num_rows($run);
                            ?>
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>9.23% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <!-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-green" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> -->
                </div>
            </div>
            </a>
        </div>
   
        <div class="col-xl-5 col-lg-6 me-5">
            <a href="./week_expense.php">
            <div class="card l-bg-green-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon fa-5x"><i class="fas fa-ticket-alt"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Last Week</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                <?php
                                 $db_user_id=$_SESSION['id'];
                                 $db_user_name=$_SESSION['name'];
                                 $today_date=date('Y-m-d');
                                 $week_date=date('Y-m-d',strtotime($today_date ."-7 days"));
                                 if($db_user_name=='admin'){
                                    $user_query="SELECT * FROM records WHERE item_date BETWEEN '$week_date' and '$today_date' ORDER BY item_date DESC";
                                }
                                else{
                                 $user_query="SELECT * FROM records WHERE item_date BETWEEN '$week_date' and '$today_date' AND item_id='$db_user_id' ORDER BY item_date DESC";
                                }
                                 $run=mysqli_query($conn,$user_query);
                                 echo mysqli_num_rows($run);
                                ?>
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>10% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <!-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-orange" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> -->
                </div>
            </div>
            </a>
        </div>
        <div class="col-xl-5 col-lg-6 me-5">
            <a href="./month_expense.php">
            <div class="card l-bg-orange-dark">
                <div class="card-statistic-3 p-4">
                    <div class="card-icon card-icon fa-5x"><i class="fas fa-dollar-sign"></i></div>
                    <div class="mb-4">
                        <h5 class="card-title mb-0">Last Month</h5>
                    </div>
                    <div class="row align-items-center mb-2 d-flex">
                        <div class="col-8">
                            <h2 class="d-flex align-items-center mb-0">
                                <?php
                                $db_user_id=$_SESSION['id'];
                                $db_user_name=$_SESSION['name'];
                                $today_date=date('Y-m-d');
                                $month_date=date('Y-m-d',strtotime($today_date ."-31 days"));
                                if($db_user_name=='admin'){
                                    $user_query="SELECT * FROM records WHERE item_date BETWEEN '$month_date' and '$today_date' ORDER BY item_date DESC";
                                }
                                else{
                                $user_query="SELECT * FROM records WHERE item_date BETWEEN '$month_date' and '$today_date' AND item_id='$db_user_id' ORDER BY item_date DESC";
                                }
                                $run=mysqli_query($conn,$user_query);
                                echo mysqli_num_rows($run);
                                ?>
                            </h2>
                        </div>
                        <!-- <div class="col-4 text-right">
                            <span>2.5% <i class="fa fa-arrow-up"></i></span>
                        </div> -->
                    </div>
                    <!-- <div class="progress mt-1 " data-height="8" style="height: 8px;">
                        <div class="progress-bar l-bg-cyan" role="progressbar" data-width="25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%;"></div>
                    </div> -->
                </div>
            </div>
            </a>
        </div>
    </div>
</div>





<?php

include("./includes/footer.php");

?>