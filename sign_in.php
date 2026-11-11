<?php
session_start();
include "database.php";

if (isset($_SESSION["user_name"])) {
    header("Location: home.php");
    exit;
}

$error = "";

if (isset($_POST["login"])) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_name = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["user_password"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"]    = $user["user_id"] ?? null;
        $_SESSION["user_name"]  = $user["user_name"];
        $_SESSION["first_name"] = $user["user_first_name"];
        $_SESSION["last_name"]  = $user["user_last_name"];

        header("Location: home.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sign In</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card">
  <h1>SIGN IN</h1>

  <form id="signinForm" action="" method="post">
    <label class="field"><span>Username</span>
      <input type="text" name="username" autocomplete="username" placeholder=" " required
             value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"></label>
    <label class="field"><span>Password</span>
      <input type="password" name="password" autocomplete="current-password" placeholder=" " required><button type="button" class="eye" aria-label="Show password" aria-pressed="false"><svg class="on" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg><svg class="off" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.94 17.94A10.9 10.9 0 0 1 12 19C5 19 1 12 1 12a18.5 18.5 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.1 9.1 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><path d="M14.12 14.12A3 3 0 1 1 9.88 9.88"/><line x1="1" y1="1" x2="23" y2="23"/></svg></button></label>
  
  <?php if ($error): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>

      <button type="submit" name="login">Sign In</button>
  </form>
  <p class="switch">Don’t have an account? <a href="register.php">Register</a></p>
</main>
<script src="script.js"></script>
</body>
</html>