<?php

namespace Omnipay;

use Mockery as m;
use Omnipay\Tests\TestCase;

class OmnipayTest extends TestCase
{
    public function tearDown() : void
    {
        Omnibill::setFactory(null);

        parent::tearDown();
    }

    public function testGetFactory()
    {
        Omnibill::setFactory(null);

        $factory = Omnibill::getFactory();
        $this->assertInstanceOf('Omnipay\Common\GatewayFactory', $factory);
    }

    public function testSetFactory()
    {
        $factory = m::mock('Omnipay\Common\GatewayFactory');

        Omnibill::setFactory($factory);

        $this->assertSame($factory, Omnibill::getFactory());
    }

    public function testCallStatic()
    {
        $factory = m::mock('Omnipay\Common\GatewayFactory');
        $factory->shouldReceive('testMethod')->with('some-argument')->once()->andReturn('some-result');

        Omnibill::setFactory($factory);

        $result = Omnibill::testMethod('some-argument');
        $this->assertSame('some-result', $result);
    }
}
