<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\PantherTestCaseTrait;

final class PicturesTest extends TestCase
{
    use PantherTestCaseTrait;

    /**
     * @test
     */
    public function show_two_pictures_of_a_cat(): void
    {
        $client = self::createHttpBrowserClient();

        $client->request('GET', self::$baseUri . '/pictures');

        $response = $client->submitForm(
            'Submit',
            [
                'picture' => 'cat.jpg',
                'number' => 2
            ],
            'GET'
        );

        $imgElements = $response->filter('img');

        // We expect 2 <img> elements:
        self::assertCount(2, $imgElements);

        $imgElements->each(
            function (Crawler $imgElement): void {
                // The src of each <img> element should contain cat.jpg:
                self::assertStringContainsString(
                    'cat.jpg',
                    $imgElement->attr('src')
                );
            }
        );
    }
}
