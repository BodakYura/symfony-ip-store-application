<?php

namespace bodakyuriy\IPStorageBundle\Driver\DoctrineDriver;

use bodakyuriy\IPStorageBundle\Entity\IPStorage;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use bodakyuriy\IPStorageBundle\Contracts\StorageDriverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\PessimisticLockException;

/**
 * Class Driver
 * @package bodakyuriy\IPStorageBundle\Driver\DoctrineDriver
 */
class Driver implements StorageDriverInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var IPStorage
     */
    private $IPStorageEntity;
    /**
     * @var string
     */
    private $tableName;

    /**
     * Driver constructor.
     * @param EntityManager $entityManager
     * @param IPStorage $IPStorageEntity
     * @param string $tableName
     */
    public function __construct(EntityManagerInterface $entityManager, IPStorage $IPStorageEntity, string $tableName)
    {
        $this->IPStorageEntity = $IPStorageEntity;
        $this->tableName = $tableName;

        $metadata = $entityManager->getClassMetadata(IPStorage::class);
        $metadata->setPrimaryTable(['name' => $tableName]);

        $this->entityManager = $entityManager;

        $this->createTable($tableName, $metadata);
    }

    /**
     * @param string $ip
     * @return bool
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function save(string $ip): bool
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {
            $sql = "INSERT INTO $this->tableName SET ip = :ip ON DUPLICATE KEY UPDATE count = count + 1";
            $statement = $this->entityManager->getConnection()->prepare($sql);
            $statement->bindParam(':ip', $ip);
            $result = $statement->execute();

            $this->entityManager->getConnection()->commit();
        } catch (\Exception $ex) {
            $this->entityManager->getConnection()->rollback();
            $this->entityManager->close();

            throw $ex;
        }

        return $result;
    }

    /**
     * @param string $ip
     * @return int
     */
    public function getCount(string $ip): int
    {
        $existsIP = $this->entityManager->getRepository(IPStorage::class)->findOneBy(['ip' => $ip]);

        if ($existsIP) {
            return $existsIP->getCount();
        }

        return 0;
    }

    /**
     * @param string $tableName
     * @param ClassMetadata $metadata
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    private function createTable(string $tableName, ClassMetadata $metadata)
    {
        $schemaManager = $this->entityManager->getConnection()->getSchemaManager();
        if ($schemaManager->tablesExist(array($tableName)) == false) {
            $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
            $schemaTool->createSchema(array($metadata));
        }
    }
}