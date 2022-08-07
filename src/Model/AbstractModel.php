<?php

declare(strict_types=1);

namespace App\Model;

use App\Exception\ConfigurationException;
use App\Exception\StorageException;
use PDO;
use PDOException;

abstract class AbstractModel
{
    protected PDO $connection;

    public function __construct(array $config)
    {
        try {
            $this->validateConfig($config);
            $this->creatConnection($config);
        } catch (PDOException $e) {
            throw new StorageException('Connection error');
        }
    }

    private function creatConnection(array $config): void
    {
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['database'];
        $this->connection = new PDO(
            $dsn,
            $config['user'],
            $config['password']
        );
    }

    private function validateConfig(array $config): void
    {
        if (
            empty($config['database']) || empty($config['host'])
            || empty($config['user']) || empty($config['password'])
        ) {
            throw new ConfigurationException('Storage configuration error');
        }
    }
}
