<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Entity;


class Posts implements PostsInterface
{
    /**
     * @var PostInterface[]
     */
    private array $posts;

    /**
     * Posts constructor.
     * @param array $posts
     */
    public function __construct(array $posts = [])
    {
        $this->posts = $posts;
    }

    /**
     * @return PostInterface[]
     */
    public function getPosts(): array
    {
        return $this->posts;
    }

    /**
     * @param PostInterface $post
     */
    public function addPost(PostInterface $post): void
    {
        $this->posts[] = $post;
    }

    /**
     * @param PostInterface[] $posts
     */
    public function addPostsArray(array $posts): void
    {
        $this->posts = array_merge($this->posts, $posts);
    }

    /**
     * @param PostsInterface $posts
     */
    public function addPosts(PostsInterface $posts): void
    {
        $this->addPostsArray($posts->getPosts());
    }
}