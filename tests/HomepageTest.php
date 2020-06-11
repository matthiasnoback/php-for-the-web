<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\PantherTestCaseTrait;

final class HomepageTest extends TestCase
{
    use PantherTestCaseTrait;

    /**
     * @test
     */
    public function the_homepage_works(): void
    {
        $client = self::createHttpBrowserClient();

        $response = $client->request('GET', self::$baseUri . '/');

        self::assertStringContainsString(
            'This is the homepage',
            $response->filter('h1')->text()
        );
    }
}
