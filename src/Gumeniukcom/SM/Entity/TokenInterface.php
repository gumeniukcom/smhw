<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Entity;


interface TokenInterface
{
    /**
     * @return string
     */
    public function getToken(): string;

    /**
     * @return bool
     */
    public function isAlive(): bool;
}