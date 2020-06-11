<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\PantherTestCaseTrait;

final class ToursTest extends TestCase
{
    use PantherTestCaseTrait;

    protected function setUp(): void
    {
        $toursFile = __DIR__ . '/../data/tours.json';
        if (is_file($toursFile)) {
            unlink($toursFile);
        }
    }

    /**
     * @test
     */
    public function create_a_new_tour(): void
    {
        $client = self::createHttpBrowserClient();

        $client->request('GET', self::$baseUri . '/create-tour');

        $client->submitForm(
            'Save',
            [
                'destination' => 'Berlin',
                'number_of_tickets_available' => 10,
                'is_accessible' => 'yes',
                'picture' => __DIR__ . '/berlin.jpg'
            ]
        );

        $response = $client->request('GET', '/list-tours');

        self::assertStringContainsString(
            'Berlin',
            $response->filter('td')->text()
        );
    }

    /**
     * @test
     */
    public function edit_an_existing_tour(): void
    {
        $client = self::createHttpBrowserClient();

        $client->request('GET', self::$baseUri . '/create-tour');

        $client->submitForm(
            'Save',
            [
                'destination' => 'Berlin',
                'number_of_tickets_available' => 10,
                'is_accessible' => 'yes',
                'picture' => __DIR__ . '/berlin.jpg'
            ]
        );

        // No need to go to /list-tours; we should be redirected to that page

        // There will be only one tour and we're going to edit it now:
        $client->clickLink('Edit');

        $client->submitForm(
            'Save',
            [
                'destination' => 'Paris',
                'number_of_tickets_available' => 5,
                'is_accessible' => false,
                'picture' => __DIR__ . '/paris.jpg'
            ]
        );

        // We should be back on /list-tours

        // The destination is a link to the details page
        $response = $client->clickLink('Paris');

        self::assertStringContainsString(
            'Tour to Paris',
            $response->filter('h1')->text()
        );
        self::assertStringContainsString(
            'This tour is not accessible',
            $response->filter('.accessibility-info')->text()
        );
        self::assertStringContainsString(
            'There are 5 tickets available',
            $response->text()
        );
    }
}
