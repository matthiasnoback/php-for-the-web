<?php
if (isset($_SESSION['message'])) {
    ?>
    <div class="alert alert-primary" role="alert"><?php
        echo htmlspecialchars($_SESSION['message'], ENT_QUOTES);
    ?></div>
    <?php

    unset($_SESSION['message']);
}
?>
