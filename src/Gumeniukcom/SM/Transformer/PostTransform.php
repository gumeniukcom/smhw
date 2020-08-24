<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Transformer;


use Exception;
use Gumeniukcom\SM\Entity\Post;
use Gumeniukcom\SM\Entity\PostInterface;

class PostTransform extends TransformerAbstract implements PostTransformInterface
{
    /**
     * @param array $array
     * @return PostInterface|null
     */
    public function transformFromAssocArray(array $array): ?PostInterface
    {
        try {
            $createdTime = new \DateTimeImmutable($array['created_time']);

            return new Post(
                $array['id'],
                $array['from_name'],
                $array['from_id'],
                $array['message'],
                $array['type'],
                $createdTime
            );
        } catch (Exception $exception) {
            $this->logger->error($exception->getMessage(), $array);
            return null;
        }
    }
}