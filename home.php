<?php
session_start();

if (isset($_POST["logout"])) {
    $_SESSION = [];
    session_destroy();
    header("Location: sign_in.php");
    exit;
}

if (!isset($_SESSION["user_name"])) {
    header("Location: sign_in.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Home</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<main class="card">
  <h1>HOME</h1>
  <p>
    Welcome,
    <?= htmlspecialchars($_SESSION["first_name"] ?? '') ?>
    <?= htmlspecialchars($_SESSION["last_name"] ?? '') ?>!
</p>
  <form method="post" action="">
    <button type="submit" name="logout">Log out</button>
  </form>
</main>
</body>
</html>