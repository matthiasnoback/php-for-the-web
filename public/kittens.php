<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kittens</title>
</head>
<body>
<?php

$numberOfKittens = isset($_GET['number']) ? (int)$_GET['number'] : 1;
if ($numberOfKittens < 1) {
    $numberOfKittens = 1;
}

for ($i = 1; $i <= $numberOfKittens; $i++) {
    ?>
    Cat <?php echo $i; ?>:
    <img src="/cat.jpg" alt="Cat <?php echo $i; ?>">
    <?php
}
?>
</body>
</html>
