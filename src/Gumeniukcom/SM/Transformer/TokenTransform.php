<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Transformer;


use Gumeniukcom\SM\Entity\Token;
use Gumeniukcom\SM\Entity\TokenInterface;

class TokenTransform extends TransformerAbstract implements TokenTransformInterface
{
    /**
     * @param array $response
     * @return TokenInterface|null
     */
    public function fromSMResponse(array $response): ?TokenInterface
    {
        if (!array_key_exists('sl_token', $response)) {
            $this->logger->error("no token on repsonse", $response);
            return null;
        }
        try {
            return new Token($response['sl_token']);
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage(), $response);
            return null;
        }
    }
}