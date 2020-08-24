<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Transformer;


use Gumeniukcom\SM\Entity\PostInterface;

interface PostTransformInterface
{
    /**
     * @param array $array
     * @return PostInterface|null
     */
    public function transformFromAssocArray(array $array): ?PostInterface;
}