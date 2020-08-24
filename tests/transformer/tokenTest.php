<?php

class tokenTest extends \Codeception\Test\Unit
{

    const TOKEN_VALUE = 'foobar';
    /**
     * @var \TransformerTester
     */
    protected TransformerTester $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testPositive()
    {

        $obj = \Codeception\Stub::make(\Gumeniukcom\Logger::class);
        $transfomer = new \Gumeniukcom\SM\Transformer\TokenTransform($obj);

        $token = $transfomer->fromSMResponse(['sl_token' => self::TOKEN_VALUE]);

        $this->assertEquals(self::TOKEN_VALUE, $token->getToken());
    }

    // tests
    public function testNegative()
    {
        $obj = \Codeception\Stub::make(\Gumeniukcom\Logger::class);
        $transfomer = new \Gumeniukcom\SM\Transformer\TokenTransform($obj);

        $token = $transfomer->fromSMResponse(['sl_token' => 'barfoo']);

        $this->assertNotEquals(self::TOKEN_VALUE, $token->getToken());
    }

    // tests
    public function testEmptyToken()
    {
//        $obj = \Codeception\Stub::construct(\Gumeniukcom\Logger::class,['tests']);
        $obj = \Codeception\Stub::make(\Gumeniukcom\Logger::class, [
            'error' => null,
            'debug' => null,
        ]);

        $transformer = new \Gumeniukcom\SM\Transformer\TokenTransform($obj);

        $token = $transformer->fromSMResponse([]);

        $this->assertEquals(null, $token);
    }
}