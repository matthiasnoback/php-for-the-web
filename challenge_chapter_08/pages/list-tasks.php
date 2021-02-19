<?php
include(__DIR__ . '/../bootstrap.php');

if (!isset($_SESSION['authenticated_user'])) {
    header('Location: /login');
    exit;
}

$tasksJsonFile = __DIR__ . '/../data/tasks.json';
if (file_exists($tasksJsonFile)) {
    $jsonData = file_get_contents($tasksJsonFile);

    $tasksData = json_decode($jsonData, true);
} else {
    $tasksData = [];
}

$title = 'Manage tasks';
include(__DIR__ . '/../_header.php');
?>
    <h1>Tasks</h1>
    <ul class="tasks">
        <?php
        foreach ($tasksData as $task) {
            if ($task['username'] === $_SESSION['authenticated_user']) {
                ?>
                <li><?php echo htmlspecialchars($task['task'], ENT_QUOTES); ?></li>
                <?php
            }
        }
        ?>
    </ul>
<?php
include(__DIR__ . '/../_footer.php');
