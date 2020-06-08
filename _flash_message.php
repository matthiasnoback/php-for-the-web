<?php
if (isset($_SESSION['message'])) {
    ?>
    <p><?php
        echo htmlspecialchars($_SESSION['message'], ENT_QUOTES);
        ?></p>
    <?php

    unset($_SESSION['message']);
}
?>
