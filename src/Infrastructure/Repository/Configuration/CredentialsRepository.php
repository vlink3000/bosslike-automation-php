<?php declare(strict_types=1);

namespace Bosslike\Infrastructure\Repository\Configuration;

use Symfony\Component\Yaml\Yaml;

class CredentialsRepository implements CredentialsRepositoryInterface
{
    /**
     * @return array
     */
    public function getKeys(): array
    {
        return $this->readSecretsFromConfiguration()['secrets'];
    }

    /**
     * @return array
     */
    private function readSecretsFromConfiguration(): array
    {
        return Yaml::parseFile(dirname(__DIR__) . '/../../../config/keys/secrets.yaml');
    }
}