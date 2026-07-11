<?php
// Simple profile registration with CSV storage
session_start();
$errors = [];
$values = [
  'name'=> '', 'email'=>'', 'phone'=>'', 'gender'=>'', 'dob'=>'',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $values['name'] = trim($_POST['name'] ?? '');
  $values['email'] = trim($_POST['email'] ?? '');
  $values['phone'] = trim($_POST['phone'] ?? '');
  $values['gender'] = trim($_POST['gender'] ?? '');
  $values['dob'] = trim($_POST['dob'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm = $_POST['confirm'] ?? '';

  if ($values['name'] === '') $errors[] = 'Full name is required.';
  if ($values['email'] === '' || !filter_var($values['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
  if ($values['phone'] === '') $errors[] = 'Phone number is required.';
  if ($values['gender'] === '') $errors[] = 'Please select a gender.';
  if ($values['dob'] === '') $errors[] = 'Date of birth is required.';
  if ($password === '' || strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
  if ($password !== $confirm) $errors[] = 'Passwords do not match.';

  if (empty($errors)) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $file = __DIR__ . DIRECTORY_SEPARATOR . 'users.csv';
    $registered_at = date('c');
    $row = [
      $values['name'], $values['email'], $values['phone'], $values['gender'], $values['dob'], $hash, $registered_at
    ];
    $fp = fopen($file, 'a');
    if ($fp) {
      if (flock($fp, LOCK_EX)) {
        fputcsv($fp, $row);
        flock($fp, LOCK_UN);
      }
      fclose($fp);
    }
    // Set flash data to show once after redirect (do not include raw password)
    $_SESSION['flash_user'] = [
      'name' => $values['name'],
      'email' => $values['email'],
      'phone' => $values['phone'],
      'gender' => $values['gender'],
      'dob' => $values['dob'],
      'registered_at' => $registered_at,
    ];
    // Redirect to avoid form resubmission and to show the details once
    header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?') . '?registered=1');
    exit;
  }
}
?>
<?php
// Pull flash data (if any) to display once
$registered_user = null;
if (!empty($_SESSION['flash_user'])) {
  $registered_user = $_SESSION['flash_user'];
  unset($_SESSION['flash_user']);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Profile Registration Form</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #eef2f3;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background: #fff;
      padding: 25px;
      border-radius: 10px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
      width: 350px;
    }
    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    .form-container input, .form-container select {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .form-container button {
      width: 100%;
      padding: 12px;
      background: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    .form-container button:hover {
      background: #45a049;
    }
    .errors { color: #b00020; margin-bottom: 10px; }
    .success { color: #0a7d00; margin-bottom: 10px; }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Register Profile</h2>
    <?php if (!empty($errors)): ?>
      <div class="errors">
        <ul>
          <?php foreach ($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>
    <?php if (!empty($registered_user)): ?>
      <div class="success">
        <strong>Registration successful.</strong>
        <div>
          <p><strong>Name:</strong> <?= htmlspecialchars($registered_user['name']) ?></p>
          <p><strong>Email:</strong> <?= htmlspecialchars($registered_user['email']) ?></p>
          <p><strong>Phone:</strong> <?= htmlspecialchars($registered_user['phone']) ?></p>
          <p><strong>Gender:</strong> <?= htmlspecialchars(ucfirst($registered_user['gender'])) ?></p>
          <p><strong>Date of Birth:</strong> <?= htmlspecialchars($registered_user['dob']) ?></p>
          <p><strong>Registered At:</strong> <?= htmlspecialchars($registered_user['registered_at']) ?></p>
        </div>
      </div>
    <?php endif; ?>
    <form method="post" action="">
      <input type="text" name="name" placeholder="Full Name" required value="<?= htmlspecialchars($values['name']) ?>">
      <input type="email" name="email" placeholder="Email" required value="<?= htmlspecialchars($values['email']) ?>">
      <input type="tel" name="phone" placeholder="Phone Number" required value="<?= htmlspecialchars($values['phone']) ?>">
      <select name="gender" required>
        <option value="">Select Gender</option>
        <option value="male" <?= $values['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
        <option value="female" <?= $values['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
        <option value="other" <?= $values['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
      </select>
      <input type="date" name="dob" required value="<?= htmlspecialchars($values['dob']) ?>">
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm" placeholder="Confirm Password" required>
      <button type="submit">Sign Up</button>
    </form>
  </div>
</body>
</html>
