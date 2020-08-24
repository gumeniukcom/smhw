<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Transformer;


use Gumeniukcom\SM\Entity\TokenInterface;

interface TokenTransformInterface
{
    /**
     * @param array $response
     * @return TokenInterface|null
     */
    public function fromSMResponse(array $response): ?TokenInterface;
}