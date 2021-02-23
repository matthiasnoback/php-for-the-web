<?php
include(__DIR__ . '/../bootstrap.php');

if (!isset($_SESSION['authenticated_user'])) {
    header('Location: /login');
    exit;
}

$tasksData = load_all_tasks_data();

$title = 'Manage tasks';
include(__DIR__ . '/../_header.php');
?>
    <h1>Tasks</h1>
    <ul class="tasks">
        <?php
        foreach ($tasksData as $task) {
            if ($task['username'] !== $_SESSION['authenticated_user']) {
                continue;
            }

            if (isset($task['isDone']) && $task['isDone']) {
                continue;
            }

            ?>
            <li>
                <?php echo htmlspecialchars($task['task'], ENT_QUOTES); ?>
                <a href="/edit-task?id=<?php echo htmlspecialchars($task['id'], ENT_QUOTES); ?>">Edit</a>
                <form action="/mark-as-done" method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($task['id'], ENT_QUOTES); ?>">
                    <button type="submit">Done</button>
                </form>
            </li>
            <?php
        }
        ?>
    </ul>
<?php
include(__DIR__ . '/../_footer.php');
