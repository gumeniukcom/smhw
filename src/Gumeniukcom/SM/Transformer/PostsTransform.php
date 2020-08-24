<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Transformer;


use Gumeniukcom\SM\Entity\Posts;
use Gumeniukcom\SM\Entity\PostsInterface;
use Psr\Log\LoggerInterface;

class PostsTransform extends TransformerAbstract implements PostsTransformInterface
{
    /**
     * @var PostTransformInterface
     */
    private PostTransformInterface $postTransformer;

    public function __construct(LoggerInterface $logger, PostTransformInterface $postTransformer)
    {
        parent::__construct($logger);
        $this->postTransformer = $postTransformer;
    }

    /**
     * @param array $array
     * @return array|null
     */
    public function transformFromSMResponse(array $array): ?PostsInterface
    {
        if (!array_key_exists('posts', $array)) {
            $this->logger->error("empty posts im sm response");
            return null;
        }
        $posts = new Posts();
        foreach ($array['posts'] as $post) {
            $postEntity = $this->postTransformer->transformFromAssocArray($post);
            if (is_null($postEntity)) {
                $this->logger->error("empty post from transform");
                return null;
            }
            $posts->addPost($postEntity);
        }

        return $posts;
    }
}