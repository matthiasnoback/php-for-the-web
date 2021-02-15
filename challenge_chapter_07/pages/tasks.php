<?php
include(__DIR__ . '/../bootstrap.php');

if (!isset($_SESSION['authenticated_user'])) {
    header('Location: /login');
    exit;
}

$username = $_SESSION['authenticated_user'];

if (isset($_POST['task']) && $_POST['task'] !== '') {
    $_SESSION['tasks'][$username][] = $_POST['task'];
}

$title = 'Manage tasks';
include(__DIR__ . '/../_header.php');
?>
    <h1>Manage tasks</h1>
    <h2>New task</h2>
    <form method="post">
        <div>
            <label for="task">Task</label>
            <input type="text" id="task" name="task">
        </div>
        <div>
            <button type="submit">Create</button>
        </div>
    </form>

    <h2>Tasks</h2>
<?php
// The tasks array may not be set:
$allTasks = isset($_SESSION['tasks'][$username])
    ? $_SESSION['tasks'][$username]
    : [];
?>
    <ul class="tasks">
        <?php
        foreach ($allTasks as $task) {
            ?>
            <li><?php echo htmlspecialchars($task, ENT_QUOTES); ?></li>
            <?php
        }
        ?>
    </ul>
<?php
include(__DIR__ . '/../_footer.php');
