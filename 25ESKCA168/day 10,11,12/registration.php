<?php
    include("header.php");
    include("db-connect.php");
    include("checkRegistrationError.php");
?>
<div class="container mt-5" style="max-width:400px;">
    <form action="" method="post">
        <h3 class="mb-3">Register</h3>
        <input type="text" name="name" class="form-control mb-3" placeholder="Name" value="<?= $name ?>">
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" value="<?= $email ?>">
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" value="<?= $password ?>">
        <input type="password" name="confirmpassword" class="form-control mb-3" placeholder="Confirm Password" value="<?= $confirmpassword ?>">
        <button type="submit">SUBMIT</button> 
    </form>
</div>


<?php
    include("footer.php");
?>
