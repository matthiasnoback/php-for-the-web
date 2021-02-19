<?php
include(__DIR__ . '/../bootstrap.php');

if (!isset($_SESSION['authenticated_user'])) {
    header('Location: /login');
    exit;
}

$formErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $normalizedData = [
        'task' => $_POST['task'] ?? ''
    ];

    if ($normalizedData['task'] === '') {
        $formErrors['task'] = 'Task can not be empty';
    }

    if (count($formErrors) === 0) {
        $tasksJsonFile = __DIR__ . '/../data/tasks.json';
        if (file_exists($tasksJsonFile)) {
            $jsonData = file_get_contents($tasksJsonFile);

            $tasksData = json_decode($jsonData, true);
        } else {
            $tasksData = [];
        }

        $tasksData[] = [
            'username' => $_SESSION['authenticated_user'],
            'task' => $normalizedData['task']
        ];
        file_put_contents($tasksJsonFile, json_encode($tasksData, JSON_PRETTY_PRINT));
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
