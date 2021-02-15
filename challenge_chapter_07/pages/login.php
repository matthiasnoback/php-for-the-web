<?php

include(__DIR__ . '/../bootstrap.php');

// You shouldn't store passwords anywhere, but for testing purposes: theses hashes are made of the same password: "test"
$users = [
    'matthias' => '$2y$10$1sXx3dPquOicIl53Y7XRdOqyS4P6flYXXpxHpTC83ZnusdxpEPtXe',
    'tomas' => '$2y$10$vruLMw5IRBI4WwGVfpwF2Om3VgULeTrd7yC3tHAURqVLaCW72unQy'
];

if (isset($_POST['username'], $_POST['password'])) {
    // The user has submitted the login form

    if (isset($users[$_POST['username']])) {
        // The provided username is correct, now validate the password
        $expectedPasswordHash = $users[$_POST['username']];

        if (password_verify($_POST['password'], $expectedPasswordHash)) {
            // The provided password is also correct

            // Remember the username of the user who just logged in
            $_SESSION['authenticated_user'] = $_POST['username'];

            // Redirect to /
            header('Location: /tasks');
            exit;
        }
    }
}
?>
<?php
$title = 'Login';
include(__DIR__ . '/../_header.php');
?>
    <form method="post">
        <div>
            <label for="username">
                Username:
            </label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">
                Password:
            </label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
<?php
include(__DIR__ . '/../_footer.php');
