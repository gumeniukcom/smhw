<?php

use Gumeniukcom\SM\Entity\Post;

class postTest extends \Codeception\Test\Unit
{
    /**
     * @var \TransformerTester
     */
    protected $tester;

    protected function getLogger()
    {
        return \Codeception\Stub::make(\Gumeniukcom\Logger::class, [
            'error' => null,
            'debug' => null,
        ]);
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testTransformPost()
    {
        $transformer = new \Gumeniukcom\SM\Transformer\PostTransform($this->getLogger());

        $postId = 'dsfgdf';
        $post = $transformer->transformFromAssocArray([
            'id' => $postId,
            'from_name' => 'post_id',
            'from_id' => 'post_id',
            'message' => 'post_id',
            'type' => 'post_id',
            'created_time' => '2020-03-07T20:28:52+00:00',
        ]);

        $this->assertNotNull($post, 'post not null');

        $this->assertEquals($postId, $post->getId());

        $this->assertEquals('2020-03-07T20:28:52+00:00', $post->getCreatedTime()->format('c'));

        $this->assertEquals('2020.03', $post->getCreatedYearMonth());

        $this->assertEquals('10', $post->getCreatedWeek());
    }
}