<?php declare(strict_types=1);

namespace App\Middleware\Event;

use App\Entity\Participant;
use App\Entity\User;
use App\Enum\EventStatus;
use App\Service\EventService;
use App\Service\ParticipantService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class EventParticipantSubscribeMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ParticipantService $participantService,
        private EventService $eventService,
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $participantCreateStatus = false;

        $eventId = (int)$request->getAttribute('eventId');
        $event = $this->eventService->findById($eventId);

        if ($event->getStatus() >= EventStatus::RUNNING->value) {
            return $handler->handle($request->withAttribute('participantCreateStatus', $participantCreateStatus));
        }

        /**
         * @var User $user
         */
        $user = $request->getAttribute(User::USER_ATTRIBUTE);

        $participant = new Participant();
        $participant->setUserId($user->getId())
            ->setEventId($eventId)
            ->setApproved(true);
        $participantCreateStatus = $this->participantService->create($participant);

        return $handler->handle($request->withAttribute('participantCreateStatus', $participantCreateStatus));
    }
}
