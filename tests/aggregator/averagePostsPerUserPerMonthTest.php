<?php

class averagePostsPerUserPerMonthTest extends \Codeception\Test\Unit
{
    /**
     * @var \AggregatorTester
     */
    protected $tester;

    protected function getLogger()
    {
        return \Codeception\Stub::make(\Gumeniukcom\Logger::class, [
            'error' => null,
            'debug' => null,
            'info' => null,
        ]);
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testAveragePostsPerUserPerMonth()
    {

        $posts = new \Gumeniukcom\SM\Entity\Posts([
            new \Gumeniukcom\SM\Entity\Post(
                'id_1',
                'from_name_1',
                'from_id_1',
                'message_1',
                'type_1',
                new DateTimeImmutable('2020-03-07T20:28:52+00:00')
            ),
            new \Gumeniukcom\SM\Entity\Post(
                'id_2',
                'from_name_1',
                'from_id_1',
                'message_11',
                'type_1',
                new DateTimeImmutable('2020-03-07T20:28:52+00:00')
            ),
            new \Gumeniukcom\SM\Entity\Post(
                'id_3',
                'from_name_1',
                'from_id_1',
                'message_111',
                'type_1',
                new DateTimeImmutable('2020-03-07T20:28:52+00:00')
            ),
            new \Gumeniukcom\SM\Entity\Post(
                'id_4',
                'from_name_1',
                'from_id_1',
                'message_1',
                'type_1',
                new DateTimeImmutable('2020-10-07T20:28:52+00:00')
            ),
            new \Gumeniukcom\SM\Entity\Post(
                'id_5',
                'from_name_1',
                'from_id_1',
                'message_11111111111фуубар👍👍😕🙂🔥🎈🎉😔🤗😬😭😃',
                'type_1',
                new DateTimeImmutable('2020-10-07T20:28:52+00:00')
            ),

            new \Gumeniukcom\SM\Entity\Post(
                'id_6',
                'from_name_1',
                'from_id_2',
                'message_1',
                'type_1',
                new DateTimeImmutable('2020-10-07T20:28:52+00:00')
            ),
            new \Gumeniukcom\SM\Entity\Post(
                'id_7',
                'from_name_1',
                'from_id_2',
                'message_11111111111фуубар👍👍😕🙂🔥🎈🎉😔🤗😬😭😃',
                'type_1',
                new DateTimeImmutable('2020-10-07T20:28:52+00:00')
            ),
            new \Gumeniukcom\SM\Entity\Post(
                'id_8',
                'from_name_1',
                'from_id_3',
                'message_11111111111фуубар👍👍😕🙂🔥🎈🎉😔🤗😬😭😃',
                'type_1',
                new DateTimeImmutable('2020-10-07T20:28:52+00:00')
            ),
            new \Gumeniukcom\SM\Entity\Post(
                'id_9',
                'from_name_1',
                'from_id_4',
                'message_11111111111фуубар👍👍😕🙂🔥🎈🎉😔🤗😬😭😃',
                'type_1',
                new DateTimeImmutable('2020-11-07T20:28:52+00:00')
            ),
        ]);

        $ag = new \Gumeniukcom\Aggregator\AveragePostsPerUserPerMonth($this->getLogger());

        $result = $ag->aggregate($posts)->getResult();

        $this->assertIsArray($result);
        $this->assertCount(3, $result);
        $this->assertArrayHasKey('2020.03', $result);
        $this->assertArrayHasKey('2020.10', $result);
        $this->assertArrayHasKey('2020.11', $result);

        $this->assertEqualsWithDelta(3,
            $result['2020.03'], 0.01);
        $this->assertEqualsWithDelta(1.66,
            $result['2020.10'], 0.01);
        $this->assertEqualsWithDelta(1,
            $result['2020.11'], 0.01);

    }
}