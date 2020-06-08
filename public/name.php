<?php
if (isset($_POST['name'])) {
    setcookie('name', $_POST['name']);
    header('Location: /random.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Name</title>
</head>
<body>
<form method="post">
    <div>
        <label for="name">
            Your name:
        </label>
        <input type="text" name="name" id="name">
    </div>
    <div>
        <button type="submit">Submit</button>
    </div>
</form>
</body>
</html>
