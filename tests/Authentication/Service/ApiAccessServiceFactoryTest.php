<?php declare(strict_types=1);

namespace Authentication\Test\Service;

use App\Test\Mock\MockContainer;
use App\Test\Service\AbstractServiceTest;
use Authentication\Service\ApiAccessService;
use Authentication\Service\ApiAccessServiceFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ApiAccessServiceFactoryTest extends AbstractServiceTest
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testCanCreateApiAccessService(): void
    {
        $config = [
            'api' => [
                'access' => [
                    'domain' => [
                        'whitelist' => [
                            'localhost',
                        ],
                    ],
                ],
            ],
        ];

        $container = new MockContainer(['config' => $config]);

        $apiAccessService = (new ApiAccessServiceFactory())($container);

        $this->assertInstanceOf(ApiAccessService::class, $apiAccessService);
    }
}
