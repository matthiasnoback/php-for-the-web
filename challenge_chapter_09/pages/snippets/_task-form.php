<?php

/**
 * @var array $normalizedData
 * @var array $formErrors
 */
?>
<form method="post">
    <div>
        <label for="task">Task</label>
        <input type="text" id="task" name="task" value="<?php echo htmlspecialchars($normalizedData['task'] ?? '', ENT_QUOTES); ?>">
        <?php
        if (isset($formErrors['task'])) {
            ?><strong><?php echo htmlspecialchars($formErrors['task'], ENT_QUOTES); ?></strong><?php
        }
        ?>
    </div>
    <div>
        <button type="submit">Save</button>
    </div>
</form>
