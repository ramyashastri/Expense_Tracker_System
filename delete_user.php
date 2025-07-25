<?php

include("./includes/header.php");
include("./includes/functions.php");
include("./includes/db_con.php");

if(isset($_REQUEST['delete_id'])){
    $delete_id=$_REQUEST['delete_id'];
    $del_query="DELETE FROM reg_users where id=$delete_id";
    $run_del_query=mysqli_query($conn,$del_query);
    if($run_del_query){
        my_alert("success","User deleted successfully");
        if( $_SESSION['id']==$delete_id){
            header("Location: ./logout.php");
        }
        else{
        header("Location: ./display_register_users.php");
        }
    }
    else{
        my_alert("danger","User doesn't exist");
    }
    mysqli_close($conn);
}


?>












<?php

include("./includes/footer.php");

?>