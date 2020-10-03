<?php declare(strict_types=1);

namespace Bosslike\Infrastructure\Repository\Bosslike;

use Bosslike\Domain\Repository\BosslikeClientRepositoryInterface;
use Bosslike\Infrastructure\Repository\Configuration\CredentialsRepositoryInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class BosslikeClientRepository implements BosslikeClientRepositoryInterface
{
    private const BOSSLIKE_API_URL = 'https://api-public.bosslike.ru/v1/';
    private const GET_TASKS = 'bots/tasks/';
    private const INIT_TASK = 'bots/tasks/{id}/do/';
    private const CHECK_TASK = 'bots/tasks/{id}/check/';
    private const VK_API_URL = 'https://api.vk.com/method/';
    /**
     * @var CredentialsRepositoryInterface
     */
    private $credentialsRepository;

    /**
     * @var ClientInterface
     */
    private $restClient;

    /**
     * BosslikeClientRepository constructor.
     *
     * @param CredentialsRepositoryInterface $credentialsRepository
     * @param ClientInterface $restClient
     */
    public function __construct(
        CredentialsRepositoryInterface $credentialsRepository,
        ClientInterface $restClient
    ) {
        $this->credentialsRepository = $credentialsRepository;
        $this->restClient = $restClient;
    }

    public function subscribeVk(): void
    {
        $keys  = $this->credentialsRepository->getKeys();
        foreach ($keys as $key) {
            $task = $this->getVkTask($key['bosslike']);
            $vkUrl = $this->startTask($task, $key['bosslike']);
            var_dump($vkUrl);
            $this->doVkTask($vkUrl, $key['vk']);
            $this->checkTask($task, $key['bosslike']);
        }
    }

    /**
     * @param string $bosslikeKey
     * @return array
     * @throws GuzzleException
     */
    private function getVkTask(string $bosslikeKey): array
    {
        $result = $this->restClient->request('GET', self::BOSSLIKE_API_URL . self::GET_TASKS, [
            'headers' => [
                'Accept' => 'application/json',
                'X-Api-Key' => $bosslikeKey
            ],
            'query' => [
                'service_type' => 1,
                'task_type' => 3
            ]
        ])->getBody()->getContents();

        return json_decode($result, true)['data']['items'][0];
    }

    /**
     * @param array $task
     * @param string $key
     * @return string
     * @throws GuzzleException
     */
    private function startTask(array $task, string $key): string
    {
        $url = self::BOSSLIKE_API_URL . str_replace("{id}",$task['id'],self::INIT_TASK);
        $result = $this->restClient->request('GET', $url, [
            'headers' => [
                'Accept' => 'application/json',
                'X-Api-Key' => $key
            ]
        ])->getBody()->getContents();

        return json_decode($result, true)['data']['url'];
    }

    /**
     * @param array $task
     * @param string $key
     * @throws GuzzleException
     */
    private function checkTask(array $task, string $key): void
    {
        $url = self::BOSSLIKE_API_URL . str_replace("{id}",$task['id'],self::CHECK_TASK);
        $this->restClient->request('GET', $url, [
            'headers' => [
                'Accept' => 'application/json',
                'X-Api-Key' => $key
            ]
        ]);
    }

    /**
     * @param string $vkUrl
     * @param string $vkToken
     * @throws GuzzleException
     */
    private function doVkTask(string $vkUrl, string $vkToken): void
    {
        switch ($vkUrl) {
            case strpos($vkUrl, 'public'):
                $vkId = str_replace("http://vk.com/public",'',$vkUrl);
                break;
            case strpos($vkUrl, 'club'):
                $vkId = str_replace("http://vk.com/club",'',$vkUrl);
                break;
            case strpos($vkUrl, 'id'):
                $vkId = str_replace("http://vk.com/id",'',$vkUrl);
                return;
            default:
                return;
        }

        $this->restClient->request('GET', self::VK_API_URL . 'groups.join?', [
            'query' => [
                'access_token' => $vkToken,
                'v' => '5.124',
                'group_id' => intval($vkId)
            ]
        ])->getBody()->getContents();
    }
}