<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Transformer;


use Gumeniukcom\SM\Entity\PostsInterface;

interface PostsTransformInterface
{
    /**
     * @param array $array
     * @return array|null
     */
    public function transformFromSMResponse(array $array): ?PostsInterface;
}