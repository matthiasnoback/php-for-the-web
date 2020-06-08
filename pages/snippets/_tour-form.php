<form method="post">
    <div>
        <label for="destination">
            Destination:
        </label>
        <input type="text" name="destination" id="destination" value="<?php
        echo isset($normalizedData['destination'])
            ? htmlspecialchars($normalizedData['destination'], ENT_QUOTES)
            : '';
        ?>">
        <?php
        if (isset($formErrors['destination'])) {
            ?>
            <strong><?php echo $formErrors['destination']; ?></strong>
            <?php
        }
        ?>
    </div>
    <div>
        <label for="number_of_tickets_available">
            Number of tickets available:
        </label>
        <input type="number" name="number_of_tickets_available"
               id="number_of_tickets_available" value="<?php
        echo isset($normalizedData['number_of_tickets_available'])
            ? htmlspecialchars(
                $normalizedData['number_of_tickets_available'], ENT_QUOTES
            )
            : '';
        ?>">
        <?php
        if (isset($formErrors['number_of_tickets_available'])) {
            ?>
            <strong>
                <?php echo $formErrors['number_of_tickets_available']; ?>
            </strong>
            <?php
        }
        ?>
    </div>
    <div>
        <label>
            <input type="checkbox" name="is_accessible" value="yes"<?php
            if (
                isset($normalizedData['is_accessible'])
                && $normalizedData['is_accessible']) {
                ?> checked<?php
            }
            ?>>
            Is accessible
        </label>
    </div>
    <div>
        <button type="submit">Save</button>
    </div>
</form>
