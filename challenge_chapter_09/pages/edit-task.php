<?php
include(__DIR__ . '/../bootstrap.php');

if (!isset($_SESSION['authenticated_user'])) {
    header('Location: /login');
    exit;
}

if (!isset($_GET['id'])) {
    throw new RuntimeException('Query parameter "id" missing');
}

$originalData = load_task_data((int)$_GET['id']);

if ($originalData['username'] !== $_SESSION['authenticated_user']) {
    throw new RuntimeException('You can not edit a task created by another user');
}

$normalizedData = $originalData;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $normalizedData = array_merge($originalData, normalize_submitted_data($_POST));

    $formErrors = validate_normalized_data($normalizedData);

    if (count($formErrors) === 0) {
        save_task_data($normalizedData);
        header('Location: /list-tasks');
        exit;
    }
}

$title = 'New task';
include(__DIR__ . '/../_header.php');
?>
<h1>New task</h1>
<?php include __DIR__ . '/snippets/_task-form.php'; ?>
<?php

include(__DIR__ . '/../_footer.php');
