<?php declare(strict_types=1);

namespace Test\Unit\Authentication\Mock\Service;

use App\Service\Authentication\ApiAccessService;

class MockApiAccessService extends ApiAccessService
{
    public function __construct()
    {
        parent::__construct([]);
    }

    public function hasAccessRights(string $domain): bool
    {
        return $domain === 'localhost';
    }
}
