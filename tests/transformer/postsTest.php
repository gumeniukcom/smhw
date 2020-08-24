<?php

class postsTest extends \Codeception\Test\Unit
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
    public function testPostTransformNoPostsInRepsonse()
    {
        $postTransformer = new \Gumeniukcom\SM\Transformer\PostTransform($this->getLogger());
        $postsTransform = new \Gumeniukcom\SM\Transformer\PostsTransform($this->getLogger(), $postTransformer);

        $posts = $postsTransform->transformFromSMResponse([]);

        $this->assertNull($posts);
    }

    public function testPostTransformOnePosteInRepsonse()
    {
        $postTransformer = new \Gumeniukcom\SM\Transformer\PostTransform($this->getLogger());
        $postsTransform = new \Gumeniukcom\SM\Transformer\PostsTransform($this->getLogger(), $postTransformer);

        $posts = $postsTransform->transformFromSMResponse([
            'posts' => [
                [
                    'id' => 'post_id_1',
                    'from_name' => 'post_id',
                    'from_id' => 'post_id',
                    'message' => 'post_id',
                    'type' => 'post_id',
                    'created_time' => '2020-03-07T20:28:52+00:00',
                ]
            ]
        ]);

        $this->assertNotNull($posts);
        $this->assertCount(1, $posts->getPosts());
    }
}