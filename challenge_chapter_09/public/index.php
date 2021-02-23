<?php
$urlMap = [
    '/login' => 'login.php',
    '/logout' => 'logout.php',
    '/list-tasks' => 'list-tasks.php',
    '/create-task' => 'create-task.php',
    '/edit-task' => 'edit-task.php',
    '/mark-as-done' => 'mark-as-done.php'
];

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
if (isset($urlMap[$pathInfo])) {
    // Load a specific page script
    include(__DIR__ . '/../pages/' . $urlMap[$pathInfo]);
} else {
    // Return a 404 status code
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    include(__DIR__ . '/../pages/404.php');
}
