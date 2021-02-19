<?php

function normalize_submitted_data(array $submittedData): array
{
    return [
        'task' => isset($submittedData['task'])
            ? (string)$submittedData['task']
            : '',
    ];
}

function validate_normalized_data(array $normalizedData): array
{
    $formErrors = [];

    if ($normalizedData['task'] === '') {
        $formErrors['task'] = 'Task can not be empty';
    }

    return $formErrors;
}

function load_all_tasks_data(): array
{
    $tasksJsonFile = __DIR__ . '/../../data/tasks.json';
    if (!file_exists($tasksJsonFile)) {
        return [];
    }

    $jsonData = file_get_contents($tasksJsonFile);

    return json_decode($jsonData, true);
}

function save_all_tasks(array $tasksData): void
{
    $tasksJsonFile = __DIR__ . '/../../data/tasks.json';

    $jsonData = json_encode($tasksData, JSON_PRETTY_PRINT);

    file_put_contents($tasksJsonFile, $jsonData);
}
