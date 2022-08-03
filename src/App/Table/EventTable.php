<?php declare(strict_types=1);

namespace App\Table;

use Administration\Table\AbstractTable;
use App\Model\Event;

class EventTable extends AbstractTable
{
    public function insert(Event $event): self
    {
        $values = [
            'userId' => $event->getUserId(),
            'title' => $event->getTitle(),
            'description' => $event->getDescription(),
            'eventText' => $event->getEventText(),
            'startTime' => $event->getStartTime()->format('Y-m-d H:i'),
            'duration' => $event->getDuration(),
        ];

        $this->query->insertInto($this->table, $values)->execute();

        return $this;
    }

    public function findAll(string $order = 'id', string $sort = 'ASC'): bool|array
    {
        return $this->query->from($this->table)->orderBy($order . ' ' . $sort)->fetchAll();
    }

    public function findByTitle(string $topic): bool|array
    {
        return $this->query->from($this->table)
            ->where('title', $topic)
            ->fetch();
    }

    public function findAllActive(): bool|array
    {
        return $this->query->from($this->table)
            ->where('active', 1)
            ->orderBy('startTime DESC')
            ->fetchAll();
    }

    public function findAllNotActive(): bool|array
    {
        return $this->query->from($this->table)
            ->where('active', 0)
            ->orderBy('startTime DESC')
            ->fetchAll();
    }
}
