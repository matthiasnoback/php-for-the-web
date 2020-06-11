<?php

$randomInt = random_int(1, 10);

$title = 'Random';
include(__DIR__ . '/../_header.php');
?>
<h1>Your lucky number is: <?php echo $randomInt; ?></h1>
<?php if ($randomInt > 5) { ?>
    <h2>Nice, <?php
    echo htmlspecialchars($_SESSION['name'] ?? 'anonymous user', ENT_QUOTES);
    ?>!</h2>
<?php } ?>
<p>
    <a href="/pictures?number=<?php echo $randomInt; ?>">
        Now show me <?php echo $randomInt; ?> kittens!
    </a>
</p>
<?php include(__DIR__ . '/../_footer.php'); ?>
