<?php
function normalize_submitted_data(array $submittedData, array $files): array
{
    $normalizedData = [
        'destination' =>
            isset($submittedData['destination'])
                ? (string)$submittedData['destination']
                : '',
        'number_of_tickets_available' =>
            isset($submittedData['number_of_tickets_available'])
                ? (int)$submittedData['number_of_tickets_available']
                : 0,
        'is_accessible' =>
            isset($submittedData['is_accessible'])
                ? true
                : false
    ];

    if (
        isset($files['picture']['error'])
        && $files['picture']['error'] === UPLOAD_ERR_OK
    ) {
        $normalizedData['picture'] = $files['picture']['tmp_name'];
    }

    return $normalizedData;
}

function validate_normalized_data(array $normalizedData): array
{
    $formErrors = [];

    if ($normalizedData['destination'] === '') {
        $formErrors['destination'] = 'Please provide a destination';
    }

    if ($normalizedData['number_of_tickets_available'] < 1) {
        $formErrors['number_of_tickets_available'] =
            'Number of tickets available should be at least 1';
    }

    if (!isset($normalizedData['picture'])) {
        $formErrors['picture'] = 'Please upload a picture';
    } elseif (is_uploaded_file($normalizedData['picture'])) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($normalizedData['picture']);
        if ($mimeType !== 'image/jpeg') {
            $formErrors['picture'] = 'Please provide a JPG image';
        }
    }

    return $formErrors;
}

function load_all_tours_data(): array
{
    $toursJsonFile = __DIR__ . '/../../data/tours.json';
    if (!file_exists($toursJsonFile)) {
        return [];
    }

    $jsonData = file_get_contents($toursJsonFile);

    return json_decode($jsonData, true);
}

function save_all_tours(array $toursData): void
{
    $toursJsonFile = __DIR__ . '/../../data/tours.json';

    $jsonData = json_encode($toursData, JSON_PRETTY_PRINT);

    file_put_contents($toursJsonFile, $jsonData);
}

function load_tour_data(int $id): array
{
    $toursData = load_all_tours_data();

    foreach ($toursData as $tourData) {
        if ($tourData['id'] === $id) {
            return $tourData;
        }
    }

    throw new RuntimeException('Could not find tour with ID ' . $id);
}

function save_tour_data(array $modifiedTourData): void
{
    $toursData = load_all_tours_data();

    foreach ($toursData as $key => $tourData) {
        if ($tourData['id'] === $modifiedTourData['id']) {
            $toursData[$key] = $modifiedTourData;
        }
    }

    save_all_tours($toursData);
}

function delete_tour(int $id): void
{
    $toursData = load_all_tours_data();

    foreach ($toursData as $key => $tourData) {
        if ($tourData['id'] === $id) {
            $toursData[$key]['is_deleted'] = true;
        }
    }

    save_all_tours($toursData);
}

function process_image_upload(array $normalizedData): array
{
    if (is_uploaded_file($normalizedData['picture'])) {
        $filename = 'tour-' . $normalizedData['id'] . '.jpg';
        $picturePath = __DIR__ . '/../../public/uploads/' . $filename;

        // Move the uploaded file to `public/uploads/`:
        move_uploaded_file($_FILES['picture']['tmp_name'], $picturePath);

        // Set the filename so it will be saved too:
        $normalizedData['picture'] = $filename;
    }

    return $normalizedData;
}
