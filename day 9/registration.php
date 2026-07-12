<?php
include("mysql.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$branch = mysqli_real_escape_string($conn, $_POST['branch']);
$sql = "INSERT INTO user (name, email, branch)
VALUES ('$name', '$email', '$branch')";
if (mysqli_query($conn, $sql)) {
echo "User Registered Successfully!";
} else {
echo "Error: " . mysqli_error($conn);
}
}
$errors = [];
$success = "";

$name = "";
$email = "";
$phone = "";
$branch = "";

if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $branch = $_POST['branch'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    
    if (empty($name)) {
        $errors[] = "Full Name is required.";
    }

    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    
    if (empty($phone)) {
        $errors[] = "Phone Number is required.";
    } elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must be exactly 10 digits.";
    }


    if (empty($branch)) {
        $errors[] = "Please select a branch.";
    }


    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    
    if ($password != $confirm) {
        $errors[] = "Passwords do not match.";
    }

    
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {

        $allowed = ["jpg", "jpeg", "png", "gif"];

        $filename = $_FILES['photo']['name'];
        $filesize = $_FILES['photo']['size'];
        $tmpname = $_FILES['photo']['tmp_name'];

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    
        if ($filesize > 20 * 1024 * 1024) {
            $errors[] = "Image size must not exceed 20 MB.";
        }

        if (!in_array($extension, $allowed)) {
            $errors[] = "Only JPG, JPEG, PNG and GIF images are allowed.";
        }

    } else {
        $errors[] = "Please upload your picture.";
    }

    if (count($errors) == 0) {

    
        if (!is_dir("uploads")) {
            mkdir("uploads");
        }

        $newName = time() . "_" . basename($filename);
        $destination = "uploads/" . $newName;

        move_uploaded_file($tmpname, $destination);

        $success = "🎉 Registration Successful!";

        
        $name = "";
        $email = "";
        $phone = "";
        $branch = "";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Registration Form</title>

<style>
body {
    margin: 0;
    font-family: "Lucida Calligraphy", "Brush Script MT", cursive;
    background: linear-gradient(135deg, #ffb6d9, #d8b4f8); /* pastel pink to purple */
}

.container {
    width: 520px; /* increased size */
    margin: 50px auto;
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 0 20px rgba(0,0,0,.25);
}

h2 {
    text-align: center;
    color: #b51768;
    font-family: "Lucida Calligraphy", cursive;
    font-size: 28px;
}

input,
select {
    width: 100%;
    padding: 14px;
    margin: 12px 0;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-sizing: border-box;
    font-family: "Lucida Calligraphy", cursive;
    font-size: 15px;
}

button {
    width: 100%;
    padding: 14px;
    background: #d63384;
    color: #fff0f6;
    border: none;
    border-radius: 10px;
    font-size: 18px;
    cursor: pointer;
    font-family: "Lucida Calligraphy", cursive;
}

button:hover {
    background: #b51768;
}

.error, .success {
    font-family: "Lucida Calligraphy", cursive;
    font-size: 15px;
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

<form method="POST" enctype="multipart/form-data">

<input
type="text"
name="name"
placeholder="Full Name"
value="<?php echo htmlspecialchars($name); ?>">

<input
type="text"
name="email"
placeholder="Email Address"
value="<?php echo htmlspecialchars($email); ?>">

<input
type="text"
name="phone"
placeholder="Phone Number"
value="<?php echo htmlspecialchars($phone); ?>">

<select name="branch">
<option value="">-- Select Branch --</option>

<option value="CSE" <?php if($branch=="CSE") echo "selected"; ?>>CSE</option>

<option value="AI" <?php if($branch=="AI") echo "selected"; ?>>AI</option>

<option value="AIML" <?php if($branch=="AIML") echo "selected"; ?>>AI & ML</option>

<option value="DS" <?php if($branch=="DS") echo "selected"; ?>>Data Science</option>

<option value="IOT" <?php if($branch=="IOT") echo "selected"; ?>>IoT</option>

<option value="CYBER" <?php if($branch=="CYBER") echo "selected"; ?>>Cyber Security</option>

<option value="ECE" <?php if($branch=="ECE") echo "selected"; ?>>ECE</option>

<option value="EEE" <?php if($branch=="EEE") echo "selected"; ?>>EEE</option>

<option value="ME" <?php if($branch=="ME") echo "selected"; ?>>Mechanical</option>

<option value="CE" <?php if($branch=="CE") echo "selected"; ?>>Civil</option>

</select>

<label><b>Upload Picture (Max 20 MB)</b></label>

<input
type="file"
name="photo"
accept="image/*">

<input
type="password"
name="password"
placeholder="Password">

<input
type="password"
name="confirm"
placeholder="Confirm Password">

<button type="submit" name="register">
Register
</button>

</form>

</div>

</body>

</html>
