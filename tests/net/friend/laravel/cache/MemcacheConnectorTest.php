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
        $memcache = m::mock('stdClass');
        $memcache->shouldReceive('addServer')->once()->with('localhost', 11211, 100);
        $memcache->shouldReceive('getVersion')->once()->andReturn(array('[localhost:11211]' => '1.2.6'));

        $connector = $this->getMock('Net\Friend\Laravel\Cache\MemcachedConnector', array('getMemcached'));
        $connector->expects($this->once())->method('getMemcached')->will($this->returnValue($memcache));
        $result = $connector->connect(array(array('host' => 'localhost', 'port' => 11211, 'weight' => 100)));
        $this->assertTrue($result === $memcache);
    }

    public function testServersAreAddedWithoutGetVersion()
    {
        $memcache = m::mock('stdClass');
        $memcache->shouldReceive('addServer')->once()->with('localhost', 11211, 100);
        $memcache->shouldReceive('getVersion')->once()->andReturn(null);

        $connector = $this->getMock('Net\Friend\Laravel\Cache\MemcachedConnector', array('getMemcached'));
        $connector->expects($this->once())->method('getMemcached')->will($this->returnValue($memcache));
        $result = $connector->connect(array(array('host' => 'localhost', 'port' => 11211, 'weight' => 100)));
        $this->assertTrue($result === $memcache);
    }
}