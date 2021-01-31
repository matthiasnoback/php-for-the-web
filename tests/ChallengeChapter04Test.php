<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\PantherTestCaseTrait;
use Symfony\Component\BrowserKit\HttpBrowser;

final class ChallengeChapter04Test extends TestCase
{
    use PantherTestCaseTrait;

    private HttpBrowser $client;

    private static function assertMessageIs(Crawler $response, string $expectedMessage): void
    {
        self::assertEquals(
            $expectedMessage,
            $response->filter('.message')->text()
        );
    }

    protected function setUp(): void
    {
        $this->client = self::createHttpBrowserClient(
            [
                'webServerDir' => __DIR__ . '/../challenge_chapter_04/public/'
            ]
        );
    }

    /**
     * @test
     */
    public function it_shows_the_english_message_by_default(): void
    {
        $response = $this->client->request('GET', self::$baseUri . '/congratulations.php');

        self::assertMessageIs($response, 'Congratulations!');
    }

    /**
     * @test
     */
    public function it_shows_the_dutch_language_when_dutch_is_selected(): void
    {
        $this->client->request('GET', self::$baseUri . '/congratulations.php');

        $response = $this->client->submitForm(
            'Submit',
            [
                'language' => 'nl'
            ],
            'GET'
        );

        self::assertMessageIs($response, 'Gefeliciteerd!');
    }

    /**
     * @test
     */
    public function it_remembers_the_selected_language(): void
    {
        $this->client->request('GET', self::$baseUri . '/congratulations.php');

        $this->client->submitForm(
            'Submit',
            [
                'language' => 'nl'
            ],
            'GET'
        );

        $response = $this->client->request('GET', self::$baseUri . '/congratulations.php');;

        self::assertMessageIs($response, 'Gefeliciteerd!');
    }

    /**
     * @test
     */
    public function it_uses_the_default_language_if_the_provided_language_is_invalid(): void
    {
        $response = $this->client->request('GET', self::$baseUri . '/congratulations.php?language=invalid');

        self::assertMessageIs($response, 'Congratulations!');
    }
}
