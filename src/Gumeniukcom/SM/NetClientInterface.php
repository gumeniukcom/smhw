<?php
declare(strict_types=1);

namespace Gumeniukcom\SM;


interface NetClientInterface
{
    public function request(string $method, string $methodName, $formParams = null, array $headers = []): NetResponse;
}