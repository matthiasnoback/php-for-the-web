<?php

use PHPUnit\Framework\TestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Panther\PantherTestCaseTrait;
use Symfony\Component\BrowserKit\HttpBrowser;

final class ChallengeChapter08Test extends TestCase
{
    use PantherTestCaseTrait;

    private HttpBrowser $client;

    private function currentUserHasTask(string $task): bool
    {
        $response = $this->client->request('GET', '/list-tasks');

        return strpos($response->filter('ul.tasks')->text(), $task) !== false;
    }

    protected function setUp(): void
    {
        $tasksJsonFile = __DIR__ . '/../challenge_chapter_08/data/tasks.json';
        if (is_file($tasksJsonFile)) {
            unlink($tasksJsonFile);
        }

        $this->client = self::createHttpBrowserClient(
            [
                'webServerDir' => __DIR__ . '/../challenge_chapter_08/public/'
            ]
        );
    }

    protected function tearDown(): void
    {
        $this->client->request('GET', '/logout');
    }

    /**
     * @test
     * @dataProvider securePaths
     */
    public function you_need_to_be_logged_in(string $path): void
    {
        $response = $this->client->request('GET', self::$baseUri . $path);
        self::assertStringContainsString('/login', $response->getUri(), 'Expected to be redirected to the login page');
    }

    public function securePaths(): Generator
    {
        yield ['/list-tasks'];
        yield ['/create-task'];
    }

    /**
     * @test
     */
    public function after_logging_in_you_have_access_to_the_list_of_tasks(): void
    {
        $this->login();

        $response = $this->client->request('GET', self::$baseUri . '/list-tasks');

        self::assertStringContainsString('Manage tasks', $response->text());
    }

    /**
     * @test
     */
    public function you_can_create_a_task(): void
    {
        $this->login();

        $task = 'Build some Lego';

        $this->createTask($task);

        self::assertTrue($this->currentUserHasTask($task));
    }

    /**
     * @test
     */
    public function you_can_not_provide_an_empty_string_as_a_task(): void
    {
        $this->login();

        $response = $this->createTask('');

        self::assertStringContainsString(
            'Task can not be empty',
            $response->filter('strong')->text()
        );
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

    private function createTask(string $task): Crawler
    {
        $this->client->request('GET', self::$baseUri . '/create-task');

        return $this->client->submitForm(
            'Create',
            [
                'task' => $task
            ]
        );
    }
}
