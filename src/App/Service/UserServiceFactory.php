<?php declare(strict_types=1);

namespace App\Service;

use App\Hydrator\ReflectionHydrator;
use App\Table\UserTable;
use Laminas\Hydrator\Strategy\NullableStrategy;
use Psr\Container\ContainerInterface;
use Ramsey\Uuid\Uuid;

class UserServiceFactory
{
    public function __invoke(ContainerInterface $container): UserService
    {
        $table = $container->get(UserTable::class);
        $hydrator = clone $container->get(ReflectionHydrator::class);
        $strategy = $container->get(NullableStrategy::class);
        $uuid = $container->get(Uuid::class);

        $hydrator->addStrategy(
            'registrationTime',
            $strategy,
        );
        $hydrator->addStrategy(
            'lastAction',
            $strategy,
        );

        return new UserService($table, $hydrator, $uuid);
    }
}
