<?php
declare(strict_types=1);

namespace Gumeniukcom\Aggregator;


use Psr\Log\LoggerInterface;

abstract class AggregatorAbstract
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * AggregatorAbstract constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}