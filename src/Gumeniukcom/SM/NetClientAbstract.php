<?php
declare(strict_types=1);

namespace Gumeniukcom\SM;


use Psr\Log\LoggerInterface;

abstract class NetClientAbstract
{

    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const REQUEST_TIMEOUT_DEFAULT = 30;

    /**
     * @var string
     */
    protected $serviceAddr = '';

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Request timeout in seconds
     * @var int
     */
    protected $requestTimeout = self::REQUEST_TIMEOUT_DEFAULT;

    /**
     * NetClientAbstract constructor.
     * @param string $serviceAddr
     * @param LoggerInterface $logger
     */
    public function __construct(string $serviceAddr, LoggerInterface $logger)
    {
        $this->serviceAddr = $serviceAddr;
        $this->logger = $logger;
    }

    /**
     * @param string $method
     * @return bool
     */
    protected function isMethodAvailable(string $method): bool
    {
        return in_array($method, [
            self::HTTP_POST,
            self::HTTP_GET,
        ]);
    }

}