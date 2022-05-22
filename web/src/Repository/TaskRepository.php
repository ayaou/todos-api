<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 *
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @return Task[]
     */
    public function getTasks(?string $day = null, ?bool $done = null): array
    {
        $queryBuilder = $this->createQueryBuilder('t')->where('1=1');

        if (null !== $day) {
            $queryBuilder->andWhere('t.day = :day')
                ->setParameter('day', $day);
        }

        if (null !== $done) {
            $queryBuilder->andWhere('t.done = :done')
                ->setParameter('done', $done);
        }

        return $queryBuilder->getQuery()->execute();
    }

    /**
     * @param array<string, mixed> $data
     */
    public function saveTask(Task $task, array $data): Task
    {
        if (array_key_exists('title', $data)) {
            $task->setTitle($data['title']);
        }

        if (array_key_exists('description', $data)) {
            $task->setDescription($data['description']);
        }

        if (array_key_exists('day', $data)) {
            $task->setDone($data['day']);
        }

        if (array_key_exists('done', $data)) {
            $task->setDone($data['done']);
        }

        $this->getEntityManager()->persist($task);

        $this->getEntityManager()->flush();

        return $this->find($task->getId());
    }
}
