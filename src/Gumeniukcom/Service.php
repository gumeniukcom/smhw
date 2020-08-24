<?php
declare(strict_types=1);

namespace Gumeniukcom;


use Gumeniukcom\Aggregator\AggregatorInterface;
use Gumeniukcom\SM\ClientInterface;
use Gumeniukcom\SM\Entity\Posts;
use Gumeniukcom\SM\Entity\PostsInterface;
use Gumeniukcom\SM\Entity\TokenInterface;
use Psr\Log\LoggerInterface;

class Service
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * Service constructor.
     * @param LoggerInterface $logger
     * @param ClientInterface $client
     */
    public function __construct(LoggerInterface $logger, ClientInterface $client)
    {
        $this->logger = $logger;
        $this->client = $client;
    }

    /**
     * @param string $client_id
     * @param string $email
     * @param string $name
     * @return TokenInterface|null
     */
    public function registerToken(string $client_id, string $email, string $name)
    {
        $token = $this->client->registerUserToken($client_id, $email, $name);
        if (is_null($token)) {
            return null;
        }

        return $token;
    }

    /**
     * @param TokenInterface $token
     * @return PostsInterface
     */
    public function fetchAllPosts(TokenInterface $token): PostsInterface
    {
        $posts = new Posts();
        if (!$token->isAlive()) {
            $this->logger->error('token expired');
            return $posts;
        }

        $posts = new Posts();
        for ($page = 1; $page <= 10; $page++) {
            $postsChunk = $this->client->getPosts($token, $page);
            if (is_null($postsChunk)) {
                $this->logger->error('');
                return $posts;
            }
            $posts->addPosts($postsChunk);
        }

        return $posts;
    }

    /**
     * @param PostsInterface $posts
     * @param AggregatorInterface $aggregator
     */
    public function runAggregate(PostsInterface $posts, AggregatorInterface $aggregator) {
        $result = $aggregator->aggregate($posts);
        var_dump($result->getResult());
    }


}