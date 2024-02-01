<?php declare(strict_types=1);

namespace Test\Unit\Mock\Database;

use Envms\FluentPDO\Queries\Select;
use Envms\FluentPDO\Query;
use PDO;
use Test\Data\Entity\EventTestEntity;
use Test\Data\Entity\ParticipantTestEntity;
use Test\Data\Entity\ProjectTestEntity;
use Test\Data\Entity\TopicTestEntity;
use Test\Data\Entity\UserTestEntity;
use Test\Data\TestConstants;

use function array_key_exists;

class MockSelectForFetchAll extends Select
{
    public function __construct(Query $fluent, string $from)
    {
        parent::__construct($fluent, $from);
    }

    public function fetch(?string $column = null, int $cursorOrientation = PDO::FETCH_ORI_NEXT): bool|array
    {
        if (array_key_exists(1, $this->statements['SELECT'])
            && $this->statements['SELECT'][1] === 'COUNT(id) AS countTopic'
        ) {
            return [
                'countTopic' => 1,
            ];
        }

        if (array_key_exists('WHERE', $this->statements)) {
            return $this->handle($this->statements['FROM'], $this->statements['WHERE'], $this->parameters['WHERE']);
        }

        return false;
    }

    public function fetchAll($index = '', $selectOnly = ''): array
    {
        return [];
    }

    private function handle(string $from, array $where, array $params): bool|array
    {
        return match ($from) {
            'Event' => $this->handleEvent($where, $params),
            'Participant' => $this->handleParticipant($where, $params),
            'Project' => $this->handleProject($where, $params),
            'TopicPool' => $this->handleTopic($where, $params),
            'User' => $this->handleUser($where, $params),
            default => false
        };
    }

    private function handleEvent(array $where, array $params): array
    {
        return match ($where[0][1]) {
            'title = ?' => $params[0] === TestConstants::EVENT_TITLE ? EventTestEntity::getDefaultEventValue() : [],
            'id = ?' => $params[0] === TestConstants::EVENT_ID ? EventTestEntity::getDefaultEventValue() : [],
            default => []
        };
    }

    private function handleParticipant(array $where, array $params): array
    {
        return match ($where[0][1]) {
            'id = ?' => $params[0] === TestConstants::PARTICIPANT_ID
                ? ParticipantTestEntity::getDefaultParticipantValue() : [],
            'userId = ?' => $params[0] === TestConstants::USER_ID ? ParticipantTestEntity::getDefaultParticipantValue()
                : [],
            default => []
        };
    }

    private function handleProject(array $where, array $params): array
    {
        return match ($where[0][1]) {
            'id = ?' => $params[0] === TestConstants::PROJECT_ID ? ProjectTestEntity::getDefaultProjectValue() : [],
            'participantId = ?' => $params[0] === TestConstants::PARTICIPANT_ID
                ? ProjectTestEntity::getDefaultProjectValue() : [],
            default => []
        };
    }

    private function handleTopic(array $where, array $params): array
    {
        return match ($where[0][1]) {
            'id = ?' => $params[0] === TestConstants::TOPIC_ID ? TopicTestEntity::getDefaultTopicValue() : [],
            'uuid = ?' => $params[0] === TestConstants::TOPIC_UUID ? TopicTestEntity::getDefaultTopicValue() : [],
            'eventId = ?' => $params[0] === TestConstants::EVENT_ID ? TopicTestEntity::getDefaultTopicValue() : [],
            'topic = ?' => $params[0] === TestConstants::TOPIC_TITLE ? TopicTestEntity::getDefaultTopicValue() : [],
            default => []
        };
    }

    private function handleUser(array $where, array $params): array
    {
        return match ($where[0][1]) {
            'id = ?' => $params[0] === TestConstants::USER_ID ? UserTestEntity::getDefaultUserValue() : [],
            'uuid = ?' => $params[0] === TestConstants::USER_UUID ? UserTestEntity::getDefaultUserValue() : [],
            'name = ?' => $params[0] === TestConstants::USER_NAME ? UserTestEntity::getDefaultUserValue() : [],
            'email = ?' => $params[0] === TestConstants::USER_EMAIL ? UserTestEntity::getDefaultUserValue() : [],
            default => []
        };
    }
}
