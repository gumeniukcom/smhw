<?php

class totalPostsSplitByWeekNumberTest extends \Codeception\Test\Unit
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
    public function testSomeFeature()
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
                'message_1',
                'type_1',
                new DateTimeImmutable('2020-03-07T20:28:52+00:00')
            ),
            new \Gumeniukcom\SM\Entity\Post(
                'id_3',
                'from_name_1',
                'from_id_1',
                'message_1',
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
                'id_4',
                'from_name_1',
                'from_id_1',
                'message_1',
                'type_1',
                new DateTimeImmutable('2020-10-07T20:28:52+00:00')
            ),
        ]);

        $ag = new \Gumeniukcom\Aggregator\TotalPostsSplitByWeekNumber($this->getLogger());

        $result = $ag->aggregate($posts)->getResult();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertArrayHasKey(10, $result);
        $this->assertArrayHasKey(41, $result);

        $this->assertEquals(3, $result[10]);
        $this->assertEquals(2, $result[41]);
    }
}