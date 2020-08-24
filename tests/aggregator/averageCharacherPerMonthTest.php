<?php

class averageCharacherPerMonthTest extends \Codeception\Test\Unit
{
    /**
     * @var \AggregatorTester
     */
    protected AggregatorTester $tester;

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
    public function testAverageCharacherPerMonth()
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
                'id_4',
                'from_name_1',
                'from_id_1',
                'message_11111111111фуубар👍👍😕🙂🔥🎈🎉😔🤗😬😭😃',
                'type_1',
                new DateTimeImmutable('2020-10-07T20:28:52+00:00')
            ),
        ]);

        $ag = new \Gumeniukcom\Aggregator\AverageCharacterPerMonth($this->getLogger());

        $result = $ag->aggregate($posts)->getResult();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertArrayHasKey('2020.03', $result);
        $this->assertArrayHasKey('2020.10', $result);

        $this->assertEquals((mb_strlen('message_1') + mb_strlen('message_11') + mb_strlen('message_111')) / 3,
            $result['2020.03']);
        $this->assertEquals((mb_strlen('message_1') + mb_strlen('message_11111111111фуубар👍👍😕🙂🔥🎈🎉😔🤗😬😭😃')) / 2,
            $result['2020.10']);

    }
}