<?php

include(__DIR__ . '/functions/tour-crud.php');

include(__DIR__ . '/../bootstrap.php');

if (!isset($_GET['id'])) {
    header('Location: /list-tours');
    exit;
}

$tourId = (int)$_GET['id'];
$originalData = load_tour_data($tourId);
$normalizedData = $originalData;

$formErrors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $normalizedData = array_merge($originalData, normalize_submitted_data($_POST, $_FILES));

    $formErrors = validate_normalized_data($normalizedData);

    if (count($formErrors) === 0) {
        $normalizedData = process_image_upload($normalizedData);

        save_tour_data($normalizedData);

        $_SESSION['message'] = 'The tour was updated successfully';
        header('Location: /list-tours');
        exit;
    }
}

include(__DIR__ . '/../_header.php');
?>
    <p><a href="/list-tours">Go back to the list</a></p>
    <h1>Edit tour <?php echo $tourId; ?></h1>
<?php
include(__DIR__ . '/snippets/_tour-form.php');

include(__DIR__ . '/../_footer.php');
