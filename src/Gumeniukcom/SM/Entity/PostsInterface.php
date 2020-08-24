<?php


namespace Gumeniukcom\SM\Entity;


interface PostsInterface
{
    /**
     * @return PostInterface[]
     */
    public function getPosts(): array;

    /**
     * @param PostInterface $post
     */
    public function addPost(PostInterface $post): void;

    /**
     * @param PostInterface[] $posts
     */
    public function addPostsArray(array $posts): void;

    /**
     * @param PostsInterface $posts
     */
    public function addPosts(PostsInterface $posts): void;
}