<?php

include(__DIR__ . '/../bootstrap.php');

if (!isset($_SESSION['authenticated_user'])) {
    header('Location: /login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    throw new RuntimeException('Expected HTTP method "POST"');
}
if (!isset($_POST['id'])) {
    throw new RuntimeException('POST parameter "id" missing');
}

$taskData = load_task_data((int)$_POST['id']);

if ($taskData['username'] !== $_SESSION['authenticated_user']) {
    throw new RuntimeException('You can not mark a task created by another user as done');
}

$taskData['isDone'] = true;
save_task_data($taskData);

header('Location: /list-tasks');
exit;
