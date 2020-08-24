<?php
declare(strict_types=1);

namespace Gumeniukcom\Aggregator;

use Gumeniukcom\SM\Entity\PostsInterface;

class TotalPostsSplitByWeekNumber extends AggregatorAbstract implements AggregatorInterface
{
    protected string $name =  'total_posts_split_by_week_number';

    private array $totalPosts = [];

    /**
     * @param PostsInterface $posts
     * @return $this
     */
    public function aggregate(PostsInterface $posts): self
    {

        foreach ($posts->getPosts() as $post) {
            $key = $post->getCreatedWeek(); // week number
            if (!array_key_exists($key, $this->totalPosts)) {
                $this->totalPosts[$key] = 0;
            }
            $this->totalPosts[$key]++;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->totalPosts;
    }
}