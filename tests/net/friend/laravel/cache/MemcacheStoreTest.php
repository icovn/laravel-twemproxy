<?php

namespace Net\Friend\Laravel\Cache;

use Memcached;
use PHPUnit\Framework\TestCase;

class MemcacheStoreTest extends TestCase
{
    public function testGetReturnsNullWhenNotFound()
    {
        $memcached = $this->getMock('Memcached', array('get'));
        $memcached->expects($this->once())->method('get')->with($this->equalTo('foo:bar'))->will(
            $this->returnValue(null)
        );
        $memcached->expects($this->once())->method('getResultCode')->will($this->returnValue(0));
        $store = new \Illuminate\Cache\MemcachedStore($memcached, 'foo');
        $this->assertNull($store->get('bar'));
    }

    public function testMemcacheValueIsReturned()
    {
        $memcached = $this->getMock('Memcached', array('get'));
        $memcached->expects($this->once())->method('get')->will($this->returnValue('bar'));
        $memcached->expects($this->once())->method('getResultCode')->will($this->returnValue(0));
        $store = new \Illuminate\Cache\MemcachedStore($memcached);
        $this->assertEquals('bar', $store->get('foo'));
    }

    public function testSetMethodProperlyCallsMemcache()
    {
        $memcached = $this->getMock('Memcached', array('set'));
        $memcached->expects($this->once())->method('set')->with(
            $this->equalTo('foo'),
            $this->equalTo('bar'),
            $this->equalTo(60)
        );
        $store = new \Illuminate\Cache\MemcachedStore($memcached);
        $store->put('foo', 'bar', 1);
    }

    public function testIncrementMethodProperlyCallsMemcache()
    {
        $memcached = $this->getMock('Memcached', array('increment'));
        $memcached->expects($this->once())->method('increment')->with($this->equalTo('foo'), $this->equalTo(5));
        $store = new \Illuminate\Cache\MemcachedStore($memcached);
        $store->increment('foo', 5);
    }

    public function testDecrementMethodProperlyCallsMemcache()
    {
        $memcached = $this->getMock('Memcached', array('decrement'));
        $memcached->expects($this->once())->method('decrement')->with($this->equalTo('foo'), $this->equalTo(5));
        $store = new \Illuminate\Cache\MemcachedStore($memcached);
        $store->decrement('foo', 5);
    }

    public function testStoreItemForeverProperlyCallsMemcached()
    {
        $memcached = $this->getMock('Memcached', array('set'));
        $memcached->expects($this->once())->method('set')->with(
            $this->equalTo('foo'),
            $this->equalTo('bar'),
            $this->equalTo(0)
        );
        $store = new \Illuminate\Cache\MemcachedStore($memcached);
        $store->forever('foo', 'bar');
    }

    public function testForgetMethodProperlyCallsMemcache()
    {
        $memcached = $this->getMock('Memcached', array('delete'));
        $memcached->expects($this->once())->method('delete')->with($this->equalTo('foo'));
        $store = new \Illuminate\Cache\MemcachedStore($memcached);
        $store->forget('foo');
    }
}