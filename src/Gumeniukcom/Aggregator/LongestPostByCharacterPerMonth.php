<?php
declare(strict_types=1);

namespace Gumeniukcom\Aggregator;

use Gumeniukcom\SM\Entity\PostsInterface;

class LongestPostByCharacterPerMonth extends AggregatorAbstract implements AggregatorInterface
{

    private array $characters = [];

    /**
     * @param PostsInterface $posts
     * @return $this
     */
    public function aggregate(PostsInterface $posts): self
    {

        foreach ($posts->getPosts() as $post) {
            $key = $post->getCreatedYearMonth(); // year-month key
            if (!array_key_exists($key, $this->characters)) {
                $this->characters[$key] = $post->getMessageLength();
            } else {
                if ($post->getMessageLength() > $this->characters[$key]) {
                    $this->characters[$key] = $post->getMessageLength();
                }
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->characters;
    }
}