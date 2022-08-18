<?php declare(strict_types=1);

namespace App\Middleware;

use App\Model\User;
use App\Service\UserService;
use Fig\Http\Message\StatusCodeInterface as HTTP;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UserMiddleware implements MiddlewareInterface
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $userUuid = $request->getAttribute('userUuid');

        $user = $this->userService->findByUuid($userUuid);

        if (!$user) {
            return new JsonResponse(['message' => 'User could not be found'], HTTP::STATUS_NOT_FOUND);
        }

        return $handler->handle($request->withAttribute(User::class, $user));
    }
}
