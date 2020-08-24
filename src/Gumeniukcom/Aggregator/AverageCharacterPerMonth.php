<?php
declare(strict_types=1);

namespace Gumeniukcom\Aggregator;


use Gumeniukcom\SM\Entity\PostInterface;
use Gumeniukcom\SM\Entity\PostsInterface;

class AverageCharacterPerMonth extends AggregatorAbstract implements AggregatorInterface
{
    private array $results = [];

    /**
     * @param PostsInterface $posts
     * @return $this
     */
    public function aggregate(PostsInterface $posts): self
    {
        $counts = [];
        $characters = [];
        /** @var PostInterface $post */
        foreach ($posts->getPosts() as $post) {
            $key = $post->getCreatedYearMonth(); // year-month key
            if (!array_key_exists($key, $counts)) {
                $counts[$key] = 0;
                $characters[$key] = 0;
            }

            $counts[$key]++;
            $characters[$key] += $post->getMessageLength();
        }


        foreach ($counts as $key => $value) {
            $this->results[$key] = $characters[$key] / $value;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->results;
    }
}