<?php
session_start();

if (!isset($_SESSION['authenticated_user'])) {
    header('Location: /login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Secret</title>
</head>
<body>
<p><a href="/logout.php">Log out</a></p>
<p>Here's something special for users who are logged in:</p>
<p><img src="/elephpant.jpg" alt="An elephpant"></p>
</body>
</html>
