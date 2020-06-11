<?php

unset($_SESSION['authenticated_user']);

header('Location: /');
exit;

