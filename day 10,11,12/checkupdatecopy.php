<?php
    include("dashboardheader.php");
    session_start();
    echo "Welcome, ".$_SESSION['user_name']."!";
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <a href="updatePassword.php">Update Password</a>
            <br>
            <a href="updateProfile.php">Update Password</a>
        </div>

        <div class="col-md-9">
            <h2><?php echo "Welcome, " . $_SESSION['user_name']; ?></h2>
        </div>
    </div>
</div>
    <a href="updatePassword.php">Update Password</a>
<?php
    include("footer.php");
?>
