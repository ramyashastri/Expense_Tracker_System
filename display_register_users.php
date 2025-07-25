<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_con.php");
include("./includes/gen_nav.php");

?>
<div class="container">
    <div class="row">
        <div class="col-12 py-3">
            <h1 class="text-center " id="expense">Registered Users</h1>
        </div>
        <div class="col-12">
            <a href="./register_user.php" class="mb-3" id="y1">ADD USER<span></span></a>
        </div>
    </div>
<table class="table table-bordered table-striped table-hover">
  <thead class="table-dark">
    <tr>
      <th scope="col">ID</th>
      <th scope="col">User Name</th>
      <th scope="col">Operation</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $fetch_data="SELECT id,user_name from reg_users";
    $run_fetch_data=mysqli_query($conn,$fetch_data);
    $counter=1;
    if(mysqli_num_rows($run_fetch_data)>0){
            while($row=mysqli_fetch_assoc($run_fetch_data)){
            ?>
                <tr>
                    <th scope="row"><?php echo $counter ?></th>
                    <td><?php echo $row['user_name'] ?></td>
                    <td>
                    <a class="me-3" target="_blank" href="./update_user_pass.php?update_id=<?php echo $row['id'] ?>"><button class="button">Set new password</button></a>
                        <a href="./delete_user.php?delete_id=<?php echo $row['id'] ?>"><button class="button">Delete</button></a>
                    </td>
                </tr> 
            <?php 
            $counter++;  
            }
        }
        else{
            ?>
            <tr>
                <td colspan="3">
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