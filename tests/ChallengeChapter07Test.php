<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\Panther\PantherTestCaseTrait;
use Symfony\Component\BrowserKit\HttpBrowser;

final class ChallengeChapter07Test extends TestCase
{
    use PantherTestCaseTrait;

    private HttpBrowser $client;

    private function currentUserHasTask(string $task): bool
    {
        $response = $this->client->request('GET', '/tasks');

        return strpos($response->filter('ul.tasks')->text(), $task) !== false;
    }

    protected function setUp(): void
    {
        $this->client = self::createHttpBrowserClient(
            [
                'webServerDir' => __DIR__ . '/../challenge_chapter_07/public/'
            ]
        );
    }

    protected function tearDown(): void
    {
        $this->client->request('GET', '/logout');
    }

    /**
     * @test
     */
    public function you_will_be_redirected_to_the_login_page_first(): void
    {
        $response = $this->client->request('GET', self::$baseUri . '/tasks');
        self::assertStringContainsString('/login', $response->getUri(), 'Expected to be redirected to the login page');
    }

    /**
     * @test
     */
    public function after_logging_in_you_have_access_to_the_list_of_tasks(): void
    {
        $this->login();

        $response = $this->client->request('GET', self::$baseUri . '/tasks');

        self::assertStringContainsString('Manage tasks', $response->text());
    }

    /**
     * @test
     */
    public function you_can_create_a_task(): void
    {
        $this->login();

        $this->client->request('GET', self::$baseUri . '/tasks');

        $task = 'Build some Lego';

        $this->client->submitForm(
            'Create',
            [
                'task' => $task
            ]
        );

        self::assertTrue($this->currentUserHasTask($task));
    }

    /**
     * @test
     */
    public function you_can_not_provide_an_empty_string_as_a_task(): void
    {
        $this->login();

        $this->client->request('GET', self::$baseUri . '/tasks');

        $response = $this->client->submitForm(
            'Create',
            [
                'task' => ''
            ]
        );

        self::assertCount(0, $response->filter('ul.tasks li'));
    }

    /**
     * @test
     */
    public function you_can_not_see_other_tasks_of_other_users(): void
    {
        $this->loginAs('matthias');

        $task = 'Build some Lego';
        $this->createTask($task);

        $this->loginAs('tomas');

        self::assertFalse($this->currentUserHasTask($task));
    }

    private function login(): void
    {
        $this->loginAs('matthias');
    }

    private function loginAs(string $username): void
    {
        $this->client->request('GET', self::$baseUri . '/login');

        $this->client->submitForm(
            'Submit',
            [
                'username' => $username,
                'password' => 'test'
            ]
        );
    }

    private function createTask(string $task): void
    {
        $this->client->request('GET', self::$baseUri . '/tasks');

        $this->client->submitForm(
            'Create',
            [
                'task' => $task
            ]
        );
    }
}
