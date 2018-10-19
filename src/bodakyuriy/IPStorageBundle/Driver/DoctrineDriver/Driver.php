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
     * @return int
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function save(string $ip): int
    {
        $existsIP = $this->entityManager->getRepository(IPStorage::class)->findOneBy(['ip' => $ip]);

        if ($existsIP) {
            return $this->updateCount($existsIP);
        }

        $this->entityManager->getConnection()->beginTransaction(); // auto-commit произойдет автоматически

        try {
            $this->IPStorageEntity->setIp($ip);
            $this->entityManager->persist($this->IPStorageEntity);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $ex) {
            $this->entityManager->getConnection()->rollback();
            $this->entityManager->close();

            throw $ex;
        }

        return $this->IPStorageEntity->getCount();
    }

    /**
     * @param IPStorage $ip
     * @return int
     * @throws \Doctrine\DBAL\ConnectionException
     */
    private function updateCount(IPStorage $ip)
    {
        $this->entityManager->getConnection()->beginTransaction(); // auto-commit произойдет автоматически

        try {
            $ip->setCount($ip->getCount() + 1);
            $this->entityManager->persist($ip);
            $this->entityManager->flush();
            $this->entityManager->getConnection()->commit();
        } catch (\Exception $ex) {
            $this->entityManager->getConnection()->rollback();
            $this->entityManager->close();

            throw $ex;
        }

        return $ip->getCount();
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