<?php

namespace Net\Friend\Laravel\Cache;

use Mockery as m;
use PHPUnit_Framework_TestCase;

class MemcacheConnectorTest extends PHPUnit_Framework_TestCase {
    public function tearDown()
    {
        m::close();
    }

    public function testServersAreAddedCorrectly()
    {
        $memcached = m::mock('stdClass');
        $memcached->shouldReceive('addServer')->once()->with('localhost', 11211, 100);
        $memcached->shouldReceive('getVersion')->once()->andReturn(array('[localhost:11211]' => '1.2.6'));

        $connector = $this->getMock('Net\Friend\Laravel\Cache\MemcachedConnector', array('getMemcached'));
        $connector->expects($this->once())->method('getMemcached')->will($this->returnValue($memcached));
        $result = $connector->connect(array(array('host' => 'localhost', 'port' => 11211, 'weight' => 100)));
        $this->assertTrue($result === $memcached);
    }

    public function testServersAreAddedWithoutGetVersion()
    {
        $memcached = m::mock('stdClass');
        $memcached->shouldReceive('addServer')->once()->with('localhost', 11211, 100);
        $memcached->shouldReceive('getVersion')->once()->andReturn(null);

        $connector = $this->getMock('Net\Friend\Laravel\Cache\MemcachedConnector', array('getMemcached'));
        $connector->expects($this->once())->method('getMemcached')->will($this->returnValue($memcached));
        $result = $connector->connect(array(array('host' => 'localhost', 'port' => 11211, 'weight' => 100)));
        $this->assertTrue($result === $memcached);
    }
}