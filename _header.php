<?php
$title = $title ?? 'PHP for the Web';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($title, ENT_QUOTES); ?></title>
    <link rel="stylesheet" href="/bootstrap.min.css">
</head>
<body>
    <div class="container">
    <nav class="navbar navbar-expand-lg bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/">Homepage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/name">Name</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/random">Random number</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pictures">Pictures</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/secret">Secret picture</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/list-tours">List tours</a>
            </li>
            <?php
            if (isset($_SESSION['authenticated_user'])) {
                ?>
                <li class="navbar-text">
                    You are logged in as:
                    <?php echo $_SESSION['authenticated_user']; ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">Log out</a>
                </li>
                <?php
            } else {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="/login">Log in</a>
                </li>
                <?php
            }
            ?>
        </ul>
    </nav>
<?php
include(__DIR__ . '/_flash_message.php');
