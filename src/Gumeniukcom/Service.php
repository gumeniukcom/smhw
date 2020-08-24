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
        $this->logger->info("finish register token", [
            'client_id' => $client_id,
            'email' => $email,
            'name' => $name,
            'token' => $token,
        ]);
        return $token;
    }

    /**
     * @param TokenInterface $token
     * @return PostsInterface
     */
    public function fetchAllPosts(TokenInterface $token): PostsInterface
    {
        $this->logger->debug('start fetch all posts');
        $posts = new Posts();
        if (!$token->isAlive()) {
            $this->logger->error('token expired');
            return $posts;
        }

        $posts = new Posts();
        for ($page = 1; $page <= 10; $page++) {
            $postsChunk = $this->client->getPosts($token, $page);
            if (is_null($postsChunk)) {
                $this->logger->error('some error of get posts chuck');
                return $posts;
            }
            $posts->addPosts($postsChunk);
        }

        $this->logger->info('finish fetch all posts');
        return $posts;
    }

    /**
     * @param PostsInterface $posts
     * @param AggregatorInterface $aggregator
     */
    public function runAggregate(PostsInterface $posts, AggregatorInterface $aggregator): void
    {
        $this->logger->debug('start aggregate: ' . $aggregator->getName());
        $aggregator->aggregate($posts);
        $this->logger->info('finish aggregate: ' . $aggregator->getName(), $aggregator->getResult());
    }


    /**
     * @param string $client_id
     * @param string $email
     * @param string $name
     */
    public function run(string $client_id, string $email, string $name): void
    {
        $token = $this->registerToken($client_id, $email, $name);

        $posts = $this->fetchAllPosts($token);

        $this->runAggregate($posts, new Aggregator\AverageCharacterPerMonth($this->logger));
        $this->runAggregate($posts, new Aggregator\LongestPostByCharacterPerMonth($this->logger));
        $this->runAggregate($posts, new Aggregator\TotalPostsSplitByWeekNumber($this->logger));
        $this->runAggregate($posts, new Aggregator\AveragePostsPerUserPerMonth($this->logger));
    }

}