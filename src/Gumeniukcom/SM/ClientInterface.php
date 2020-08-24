<?php
declare(strict_types=1);

namespace Gumeniukcom\SM;


use Gumeniukcom\SM\Entity\PostsInterface;
use Gumeniukcom\SM\Entity\TokenInterface;

interface ClientInterface
{
    /**
     * @param string $client_id
     * @param string $email
     * @param string $name
     * @return TokenInterface|null
     */
    public function registerUserToken(string $client_id, string $email, string $name): ?TokenInterface;

    /**
     * @param TokenInterface $token
     * @param int $page
     * @return PostsInterface|null
     */
    public function getPosts(TokenInterface $token, int $page = 1): ?PostsInterface;
}