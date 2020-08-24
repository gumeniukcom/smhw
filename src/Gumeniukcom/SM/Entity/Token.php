<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Entity;


use DateInterval;
use DateTime;
use DateTimeImmutable;

class Token implements TokenInterface
{
    /**
     * @var string
     */
    private string $token;

    /**
     * @var DateTime
     */
    private DateTime $ttl;

    const TTL = 3600;

    public function __construct(
        string $token,
        int $ttlSeconds = self::TTL
    ) {
        $this->token = $token;
        $ttl = new DateTime();
        $interval = new DateInterval('PT' . $ttlSeconds . 'S');

        $this->ttl = $ttl->add($interval);
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return bool
     */
    public function isAlive(): bool
    {
        return $this->ttl > (new DateTime('now'));
    }

}