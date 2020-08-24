<?php
declare(strict_types=1);

namespace Gumeniukcom\Aggregator;

use Gumeniukcom\SM\Entity\PostsInterface;

class AveragePostsPerUserPerMonth extends AggregatorAbstract implements AggregatorInterface
{
    private array $result = [];

    /**
     * @param PostsInterface $posts
     * @return $this
     */
    public function aggregate(PostsInterface $posts): self
    {
        $postPerUserPerMonth = [];

        foreach ($posts->getPosts() as $post) {
            $keyYearMonth = $post->getCreatedYearMonth(); // year-month key
            $keyUserId = $post->getFromId();
            if (!array_key_exists($keyYearMonth, $postPerUserPerMonth)) {
                $postPerUserPerMonth[$keyYearMonth] = [];
            }

            if (!array_key_exists($keyUserId, $postPerUserPerMonth[$keyYearMonth])) {
                $postPerUserPerMonth[$keyYearMonth][$keyUserId] = 0;
            }

            $postPerUserPerMonth[$keyYearMonth][$keyUserId]++;
        }

        foreach ($postPerUserPerMonth as $keyYearMonth => $key2values) {
            $total = 0;
            foreach ($key2values as $value2) {
                $total += $value2;
            }
            $this->result[$keyYearMonth] = $total / count($key2values);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}