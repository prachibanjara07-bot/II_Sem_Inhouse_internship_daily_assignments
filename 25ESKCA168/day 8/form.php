<?php
$errors = [];
$success = "";

$name = "";
$email = "";
$phone = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // Name Validation
    if (empty($name)) {
        $errors[] = "Full Name is required.";
    }

    // Email Validation
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    // Phone Validation
    if (empty($phone)) {
        $errors[] = "Phone Number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must be exactly 10 digits.";
    }

    // Password Validation
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Confirm Password
    if ($password != $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (count($errors) == 0) {
        $success = "🎉 Registration Successful!";
        $name = "";
        $email = "";
        $phone = "";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Registration Form</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#ffb6d9;
}

.container{
    width:400px;
    margin:40px auto;
    background:white;
    padding:30px;
    border-radius:15px;
    box-shadow:0 0 15px rgba(0,0,0,.2);
}

h2{
    text-align:center;
    color:#d63384;
}

input{
    width:100%;
    padding:12px;
    margin:10px 0;
    border:1px solid #ccc;
    border-radius:8px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:12px;
    background:#d63384;
    color:white;
    border:none;
    border-radius:8px;
    font-size:17px;
    cursor:pointer;
}

button:hover{
    background:#b51768;
}

.error{
    background:#ffd6d6;
    color:red;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

.success{
    background:#d4edda;
    color:green;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

ul{
    margin:0;
    padding-left:20px;
}

</style>

</head>

<body>

<div class="container">

<h2>Registration Form</h2>

<?php
if(count($errors)>0){
    echo "<div class='error'><ul>";
    foreach($errors as $e){
        echo "<li>$e</li>";
    }
    echo "</ul></div>";
}

if($success!=""){
    echo "<div class='success'>$success</div>";
}
?>

<form method="POST">

<input type="text"
name="name"
placeholder="Full Name"
value="<?php echo htmlspecialchars($name); ?>">

<input type="text"
name="email"
placeholder="Email Address"
value="<?php echo htmlspecialchars($email); ?>">

<input type="text"
name="phone"
placeholder="Phone Number"
value="<?php echo htmlspecialchars($phone); ?>">

<input type="password"
name="password"
placeholder="Password">

<input type="password"
name="confirm"
placeholder="Confirm Password">

<button type="submit" name="register">
Register
</button>

</form>

</div>

</body>
</html>
