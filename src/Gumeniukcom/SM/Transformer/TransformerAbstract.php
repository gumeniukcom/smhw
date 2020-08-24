<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Transformer;


use Psr\Log\LoggerInterface;

abstract class TransformerAbstract
{
    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;

    /**
     * Post constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}