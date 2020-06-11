<?php

$numberOfPictures = isset($_GET['number']) ? (int)$_GET['number'] : 1;
if ($numberOfPictures < 1) {
    $numberOfPictures = 1;
}

$picture = isset($_GET['picture']) ? $_GET['picture'] : 'cat.jpg';

$title = 'Pictures';
include(__DIR__ . '/../_header.php');

for ($i = 1; $i <= $numberOfPictures; $i++) {
    ?>
    Cat <?php echo $i; ?>:
    <img src="<?php echo htmlspecialchars($picture, ENT_QUOTES); ?>"
         alt="Picture <?php echo $i; ?>">
    <?php
}
?>
    <form>
        <div>
            <label for="picture">
                Select a picture:
                <?php
                $pictures = [
                    'cat.jpg' => 'Cat',
                    'apple.jpg' => 'Apple'
                ];
                ?>
            </label>
            <select name="picture" id="picture">
                <?php foreach ($pictures as $filename => $description) {
                    ?>
                    <option value="<?php
                    echo htmlspecialchars($filename, ENT_QUOTES);
                    ?>"<?php
                    if (isset($_GET['picture']) && $_GET['picture'] === $filename) {
                        ?> selected<?php
                    }
                    ?>>
                        <?php echo htmlspecialchars($description, ENT_QUOTES); ?>
                    </option>
                    <?php
                } ?>
            </select>
        </div>
        <div>
            <label for="number">
                Number of pictures to show:
            </label>
            <input name="number" id="number" value="<?php
            if (isset($_GET['number'])) {
                echo htmlspecialchars($_GET['number'], ENT_QUOTES);
            }
            ?>">
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
<?php include(__DIR__ . '/../_footer.php'); ?>
