<?php declare(strict_types=1);

namespace App\Exception;

use Fig\Http\Message\StatusCodeInterface as Http;
use JetBrains\PhpStorm\Pure;
use Throwable;

class InvalidArgumentHttpException extends HttpException
{
    #[Pure] public function __construct(array $jsonMessage = [], int $code = Http::STATUS_BAD_REQUEST, ?Throwable $previous = null)
    {
        parent::__construct($jsonMessage, $code, $previous);
    }
}
