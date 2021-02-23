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
            'id' => count($tasksData) + 1,
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
<?php

include __DIR__ . '/snippets/_task-form.php';

include(__DIR__ . '/../_footer.php');
