<?php
include "database.php";

$error = "";

if (isset($_POST["register"])) {
    $firstname       = trim($_POST["first"]);
    $lastname        = trim($_POST["last"]);
    $username        = trim($_POST["username"]);
    $password        = $_POST["password"];
    $confirmPassword = $_POST["confirm"];

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users
                    (user_first_name, user_last_name, user_name, user_password)
                    VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$firstname, $lastname, $username, $hashedPassword]);

            header("Location: sign_in.php");
            exit;
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $error = "That username is already taken.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Register</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card">
  <h1>REGISTER</h1>

  <form id="registerForm" method="post" action="">
    <div class="row">
      <label class="field"><span>First name</span>
        <input type="text" name="first" autocomplete="given-name" placeholder=" " required
               value="<?= htmlspecialchars($_POST['first'] ?? '') ?>"></label>
      <label class="field"><span>Last name</span>
        <input type="text" name="last" autocomplete="family-name" placeholder=" " required
               value="<?= htmlspecialchars($_POST['last'] ?? '') ?>"></label>
    </div>
    <label class="field"><span>Username</span>
      <input type="text" name="username" autocomplete="username" placeholder=" " required
             value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"></label>
    <label class="field"><span>Password</span>
      <input type="password" name="password" autocomplete="new-password" minlength="6" placeholder=" " required><button type="button" class="eye" aria-label="Show password" aria-pressed="false"><svg class="on" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg><svg class="off" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.94 17.94A10.9 10.9 0 0 1 12 19C5 19 1 12 1 12a18.5 18.5 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.1 9.1 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><path d="M14.12 14.12A3 3 0 1 1 9.88 9.88"/><line x1="1" y1="1" x2="23" y2="23"/></svg></button></label>
    <label class="field"><span>Confirm password</span>
      <input type="password" name="confirm" autocomplete="new-password" minlength="6" placeholder=" " required><button type="button" class="eye" aria-label="Show password" aria-pressed="false"><svg class="on" viewBox="0 0 24 24" aria-hidden="true"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg><svg class="off" viewBox="0 0 24 24" aria-hidden="true"><path d="M17.94 17.94A10.9 10.9 0 0 1 12 19C5 19 1 12 1 12a18.5 18.5 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.1 9.1 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><path d="M14.12 14.12A3 3 0 1 1 9.88 9.88"/><line x1="1" y1="1" x2="23" y2="23"/></svg></button></label>
    
    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

      <button type="submit" name="register">Register</button>
  </form>
  <p class="switch">Already Registered? <a href="sign_in.php">Log In</a></p>
</main>
<script src="script.js"></script>
</body>
</html>