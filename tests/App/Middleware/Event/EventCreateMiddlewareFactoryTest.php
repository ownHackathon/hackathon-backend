<?php declare(strict_types=1);

namespace App\Test\Middleware\Event;

use App\Hydrator\ReflectionHydrator;
use App\Middleware\Event\EventCreateMiddleware;
use App\Middleware\Event\EventCreateMiddlewareFactory;
use App\Service\EventService;
use App\Test\Middleware\AbstractMiddlewareTest;
use App\Test\Mock\MockContainer;
use App\Test\Mock\Service\MockEventServie;
use Laminas\Hydrator\Strategy\DateTimeFormatterStrategy;

class EventCreateMiddlewareFactoryTest extends AbstractMiddlewareTest
{
    public function setUp(): void
    {
        parent::setUp();
    }

    public function testCanCreateEventMiddleware(): void
    {
        $container = new MockContainer(
            [
                EventService::class => new MockEventServie(),
                ReflectionHydrator::class => new ReflectionHydrator(),
                DateTimeFormatterStrategy::class => new DateTimeFormatterStrategy(),
            ]
        );

        $middleware = (new EventCreateMiddlewareFactory)($container);

        $this->assertInstanceOf(EventCreateMiddleware::class, $middleware);
    }
}
