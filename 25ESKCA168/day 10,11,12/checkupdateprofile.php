<?php
if ($_SERVER["REQUEST_METHOD"] !== 'POST') {
    return;
}

if (!isset($_SESSION)) session_start();
// ensure DB connection exists
if (!isset($conn)) {
    include_once("db_connect.php");
}

$error = "";

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($name === '' || $email === '') {
    $error = "All fields are required.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Please provide a valid email address.";
} else {
    $user_id = $_SESSION['user_id'] ?? null;
    if (!$user_id) {
        $error = "User not authenticated.";
    } else {
        // check if email is used by another user
        $stmt = mysqli_prepare($conn, "SELECT id FROM user WHERE email = ? AND id != ?");
        mysqli_stmt_bind_param($stmt, "si", $email, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = "This email is already in use by another account.";
        }
        mysqli_stmt_close($stmt);
    }
}

if ($error === '') {
    $stmt = mysqli_prepare($conn, "UPDATE user SET name = ?, email = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $name, $email, $_SESSION['user_id']);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['user_name'] = $name;
        header('Location: success.php');
        exit;
    } else {
        $error = "Update failed: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

if ($error !== '') {
    echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>';
}

?>
