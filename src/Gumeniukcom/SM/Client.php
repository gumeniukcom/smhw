<?php
declare(strict_types=1);

namespace Gumeniukcom\SM;


use Gumeniukcom\SM\Entity\PostsInterface;
use Gumeniukcom\SM\Entity\TokenInterface;
use Gumeniukcom\SM\Transformer\PostsTransformInterface;
use Psr\Log\LoggerInterface;
use Gumeniukcom\SM\Transformer\TokenTransformInterface;

class Client implements ClientInterface
{

    const REGISTER_USER_TOKEN_ENDPOINT = 'assignment/register';
    const REGISTER_USER_TOKEN_METHOD = NetClientAbstract::HTTP_POST;

    const FETCH_POSTS_ENDPOINT = 'assignment/posts';
    const FETCH_POSTS_METHOD = NetClientAbstract::HTTP_GET;

    /**
     * @var NetClientInterface
     */
    private NetClientInterface $client;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var PostsTransformInterface
     */
    private PostsTransformInterface $postsTransformer;

    /**
     * @var TokenTransformInterface
     */
    private TokenTransformInterface $tokenTransformer;

    public function __construct(
        NetClientInterface $client,
        LoggerInterface $logger,
        PostsTransformInterface $postsTransformer,
        TokenTransformInterface $tokenTransformer
    ) {
        $this->client = $client;
        $this->logger = $logger;
        $this->postsTransformer = $postsTransformer;
        $this->tokenTransformer = $tokenTransformer;
    }

    /**
     * @param string $client_id
     * @param string $email
     * @param string $name
     * @return TokenInterface|null
     */
    public function registerUserToken(string $client_id, string $email, string $name): ?TokenInterface
    {
        $requestData = [
            'client_id' => $client_id,
            'email' => $email,
            'name' => $name,
        ];

        $this->logger->debug("start register user token", $requestData);

        $response = $this->client->request(
            self::REGISTER_USER_TOKEN_METHOD,
            self::REGISTER_USER_TOKEN_ENDPOINT,
            $requestData
        );

        if ($response->hasError()) {
            $this->logger->error("finished register user token with error", $requestData);
            return null;
        }


        $res = $this->unmarshallResponse($response->getResponse());

        if (is_null($res)) {
            $this->logger->error("finished register user token with error via unmarshall error", $requestData);
            return null;
        }

        $token = $this->tokenTransformer->fromSMResponse($res->getData());
        if (is_null($token)) {
            $this->logger->error("finished register user token with error on transform token", $requestData);
            return null;
        }

        $this->logger->debug("finished register user token", $requestData);

        return $token;
    }

    /**
     * @param TokenInterface $token
     * @param int $page
     * @return PostsInterface|null
     */
    public function getPosts(TokenInterface $token, int $page = 1): ?PostsInterface
    {
        if (!$token->isAlive()) {
            $this->logger->error("token expired");
            return null;
        }
        $headers = [
            'query' => [
                'sl_token' => $token->getToken(),
                'page' => $page,
            ],
        ];

        $this->logger->debug("start fetch posts", $headers);

        $response = $this->client->request(
            self::FETCH_POSTS_METHOD,
            self::FETCH_POSTS_ENDPOINT,
            null,
            $headers
        );

        if ($response->hasError()) {
            $this->logger->error("finished fetch posts with error", $headers);
            return null;
        }


        $res = $this->unmarshallResponse($response->getResponse());

        if (is_null($res)) {
            $this->logger->error("finished fetch posts with error via unmarshall error", $headers);
            return null;
        }

        /** @var PostsInterface $posts */
        $posts = $this->postsTransformer->transformFromSMResponse($res->getData());
        if (is_null($posts)) {
            $this->logger->error("finished fetch posts with error via posts transform", $headers);
            return null;
        }

        $this->logger->debug("finished fetch posts", $headers);

        return $posts;
    }


    /**
     * @param string $json
     * @return ClientResponse|null
     */
    private function unmarshallResponse(string $json): ?ClientResponse
    {
        $decodeResult = json_decode($json, true);
        if (is_null($decodeResult)) {
            $this->logger->error('something wrong with unmarshall json', ['json' => $json]);
            return null;
        }

        if (!array_key_exists('meta', $decodeResult) && !array_key_exists('data', $decodeResult)) {
            $this->logger->error('there are no meta and data keys in response', ['json' => $json]);
            return null;
        }

        $this->logger->debug('unmarshall success');
        return new ClientResponse($decodeResult['meta'], $decodeResult['data']);
    }

}