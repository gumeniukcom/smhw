<?php
declare(strict_types=1);

namespace Gumeniukcom;


use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MLogger;
use Psr\Log\LoggerInterface;

class Logger implements LoggerInterface
{
    private MLogger $logger;

    public function __construct(string $name)
    {
        $this->logger = new MLogger($name);

        $formatter = new JsonFormatter();

        $stream = new StreamHandler(
            'php://stdout',
            $level = MLogger::DEBUG,
            $bubble = true);
        $stream->setFormatter($formatter);

        $this->logger->pushHandler($stream);
    }


    public function emergency($message, array $context = [])
    {
        $this->logger->emergency($message, $this->clearContext($context));
    }

    public function alert($message, array $context = [])
    {
        $this->logger->alert($message, $this->clearContext($context));
    }

    public function critical($message, array $context = [])
    {
        $this->logger->critical($message, $this->clearContext($context));
    }

    public function error($message, array $context = [])
    {
        $this->logger->error($message, $this->clearContext($context));
    }

    public function warning($message, array $context = [])
    {
        $this->logger->warning($message, $this->clearContext($context));
    }

    public function notice($message, array $context = [])
    {
        $this->logger->notice($message, $this->clearContext($context));
    }

    public function info($message, array $context = [])
    {
        $this->logger->info($message, $this->clearContext($context));
    }

    public function debug($message, array $context = [])
    {
        $this->logger->debug($message, $this->clearContext($context));
    }

    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $message, $this->clearContext($context));
    }

    /**
     * TODO : implement clearing context, eg: token value to ***
     * @param array $context
     * @return array
     */
    private function clearContext(array $context = []): array {
        return $context;
    }
}