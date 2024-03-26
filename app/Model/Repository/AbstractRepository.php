<?php

declare(strict_types=1);

namespace Model\Repository;

use Dibi\DateTime;
use LeanMapper\Entity;
use LeanMapper\Repository;

abstract class AbstractRepository extends Repository
{
    public function find(int $id): ?Entity
    {
        // first part
        $row = $this->connection->select('*')
            ->from($this->getTable())
            ->where('id = %i', $id)
            ->where('deleted IS NULL')
            ->fetch();

        // second part
        return $row ? $this->createEntity($row) : null;
    }

    public function findAll(): array
    {
        return $this->createEntities(
            $this->connection->select('*')
                ->from($this->getTable())
                ->where('deleted IS NULL')
                ->fetchAll()
        );
    }

    public function persist(Entity $entity): void
    {
        if ($entity->isDetached()) {
            $entity->inserted = new DateTime();
        } elseif ($entity->isModified()){
            $entity->updated = new DateTime();
        }

        parent::persist($entity);
    }

}
