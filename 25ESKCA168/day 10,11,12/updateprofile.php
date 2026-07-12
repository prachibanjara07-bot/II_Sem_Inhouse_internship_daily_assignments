<?php
session_start();
include("dashboardheader.php");
include("dashboardVerticalContent.php");
include("checkUpdateError.php");
?>



<div class="container mt-5" style="max-width:400px;">
    <form action="" method = "post">
        <h3 class="mb-3">Update Password</h3>

        <input type="password" class="form-control mb-3" name="oldpassword" placeholder="Old Password">

        <input type="password" class="form-control mb-3" placeholder="New Password" name="newpassword" >
        <input type="password" class="form-control mb-3" placeholder="Confirm Password" name="confirmpassword" >


        <button class="btn btn-primary w-100">Update</button>
    </form>

<?php 
    include("footer.php");
?>
