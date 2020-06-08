<?php

include(__DIR__ . '/functions/tour-crud.php');

include(__DIR__ . '/../bootstrap.php');

if (!isset($_GET['id'])) {
    header('Location: /list-tours');
    exit;
}

$tourId = (int)$_GET['id'];

delete_tour($tourId);

$_SESSION['message'] = 'Successfully deleted tour ' . $tourId;
header('Location: /list-tours');
exit;
