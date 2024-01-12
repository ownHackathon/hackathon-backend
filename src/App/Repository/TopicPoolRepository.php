<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Topic;

interface TopicPoolRepository extends Repository
{
    public function insert(Topic $topic): self;

    public function findByUuId(string $uuid): bool|array;

    public function updateEvent(Topic $topic): self;

    public function findByEventId(int $id): bool|array;

    public function findAvailable(): bool|array;

    public function findByTopic(string $topic): bool|array;

    public function getCountTopic(): int;

    public function getCountTopicAccepted(): int;

    public function getCountTopicSelectionAvailable(): int;
}
