<?php

include(__DIR__ . '/../bootstrap.php');

unset($_SESSION['authenticated_user']);

header('Location: /');
exit;

