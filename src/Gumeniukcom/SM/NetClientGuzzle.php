<?php
declare(strict_types=1);

namespace Gumeniukcom\SM;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Psr\Log\LoggerInterface;

class NetClientGuzzle extends NetClientAbstract implements NetClientInterface
{

    /**
     * @var ClientInterface
     */
    private ClientInterface $guzzleClient;

    public function __construct(string $serviceAddr, ClientInterface $client, LoggerInterface $logger)
    {
        $this->guzzleClient = $client;
        parent::__construct($serviceAddr, $logger);
    }

    /**
     * @param string $serviceAddr
     * @param LoggerInterface $logger
     * @param int $timeout
     * @param array $config
     * @return NetClientGuzzle
     */
    public static function withConfig(
        string $serviceAddr,
        LoggerInterface $logger,
        int $timeout = self::REQUEST_TIMEOUT_DEFAULT,
        array $config = []
    ) {

        $guzzleClient = new Client([
                'base_uri' => $serviceAddr,
                'timeout' => $timeout,
            ] + $config);
        return new self($serviceAddr, $guzzleClient, $logger);
    }

    /**
     * @param string $method
     * @param string $methodName
     * @param null $formParams
     * @param array $headers
     * @return NetResponse
     * @throws \Exception
     */
    public function request(string $method, string $methodName, $formParams = null, array $headers = []): NetResponse
    {
        if (!$this->isMethodAvailable($method)) {
            $this->logger->error(
                'request called with wrong http method',
                [
                    'method' => $method,
                    'method_name' => $methodName,
                ]
            );
            throw new \Exception('request called with wrong http method');
        }

        if (!is_null($formParams)) {
            $headers['form_params'] = $formParams;
        }


        try {
            $res = $this->guzzleClient->request($method, $methodName, $headers);

            $this->logger->debug(
                'request finished',
                [
                    'method' => $method,
                    'method_name' => $methodName,
                    'status_code' => $res->getStatusCode(),
                ]
            );
            return new NetResponse($res->getStatusCode(), $res->getBody()->getContents());
        } catch (ServerException $exception) {
            $this->logger->error(
                'request server exception handled',
                [
                    'method' => $method,
                    'method_name' => $methodName,
                    'status_code' => $exception->getCode(),
                    'error_message' => $exception->getMessage(),
                ]
            );
            return new NetResponse(
                $exception->getCode(),
                $exception->getResponse()->getBody()->getContents(),
                $exception->getMessage()
            );
        } catch (ClientException $exception) {
            $this->logger->error(
                'request client exception handled',
                [
                    'method' => $method,
                    'method_name' => $methodName,
                    'status_code' => $exception->getCode(),
                    'error_message' => $exception->getMessage(),
                ]
            );
            return new NetResponse(
                $exception->getCode(),
                $exception->getResponse()->getBody()->getContents(),
                $exception->getMessage()
            );
        } catch (GuzzleException $exception) {
            $this->logger->error(
                'request exception handled',
                [
                    'method' => $method,
                    'method_name' => $methodName,
                ]
            );
            return new NetResponse(
                $exception->getCode(),
                null,
                $exception->getMessage()
            );
        }
    }
}