<?php
declare(strict_types=1);

namespace Gumeniukcom\Aggregator;


use Gumeniukcom\SM\Entity\PostsInterface;

interface AggregatorInterface
{
    /**
     * @param PostsInterface $posts
     * @return $this
     */
    public function aggregate(PostsInterface $posts): self;

    /**
     * @return array
     */
    public function getResult(): array;

}