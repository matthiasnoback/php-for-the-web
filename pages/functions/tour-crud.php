<?php
function normalize_submitted_data(array $submittedData): array
{
    return [
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
