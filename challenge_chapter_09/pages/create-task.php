<?php
include(__DIR__ . '/../bootstrap.php');

if (!isset($_SESSION['authenticated_user'])) {
    header('Location: /login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $normalizedData = normalize_submitted_data($_POST);

    $formErrors = validate_normalized_data($normalizedData);

    if (count($formErrors) === 0) {
        $tasksData = load_all_tasks_data();

        $tasksData[] = [
            'username' => $_SESSION['authenticated_user'],
            'task' => $normalizedData['task']
        ];

        save_all_tasks($tasksData);

        header('Location: /list-tasks');
        exit;
    }
}

$title = 'New task';
include(__DIR__ . '/../_header.php');
?>
    <h1>New task</h1>
    <form method="post">
        <div>
            <label for="task">Task</label>
            <input type="text" id="task" name="task">
            <?php
            if (isset($formErrors['task'])) {
                ?><strong><?php echo htmlspecialchars($formErrors['task'], ENT_QUOTES); ?></strong><?php
            }
            ?>
        </div>
        <div>
            <button type="submit">Create</button>
        </div>
    </form>
<?php

include(__DIR__ . '/../_footer.php');
