<?php
$error = "";

$newpassword ="";
$confirmpassword ="";
$oldpassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newpassword = mysqli_real_escape_string($conn,$_POST["newPassword"]);
    $confirmpassword = mysqli_real_escape_string($conn,$_POST["confirmPassword"]);
    $oldpassword = mysqli_real_escape_string($conn , $_POST["oldpassword"]);
    if ($newpassword == "" || $confirmpassword == "" || $oldpassword == "") {
        $error = "All fields are required.";
        echo $error;
    } elseif() {
        //insert
        $selectQuery = "Select * from user where id=$_SESSION['user_id']";

        $result= mysqli_query($conn, $selectQuery);
        $user = mysqli_fetch_assoc($result);

        if($user["newpassword"] && $user["password"] == $oldpassword){
            $updateQuery = "update user set password= '' ";
        }else{
            echo "Invalid Credentials";
            echo "Error: " . mysqli_error($conn);
        }
       
    }
}
?>
