<?php

use Greedying\Domain\Domain;

require __DIR__.'/../vendor/autoload.php';

class DomainTest extends PHPUnit_Framework_TestCase 
{
    public function testPrefixAndSuffix()
    {
        $domain = new Domain('test.com');
        $this->assertEquals('test', $domain->prefix);
        $this->assertEquals('com', $domain->suffix);

        $domain = new Domain('test.net.cn');
        $this->assertEquals('test', $domain->prefix);
        $this->assertEquals('net.cn', $domain->suffix);
    }

    public function testyinjieNum()
    {
        $domain = new Domain('a.com');
        $this->assertEquals(1, $domain->yinjieNum());

        $domain = new Domain('ha.com');
        $this->assertEquals(1, $domain->yinjieNum());

        $domain = new Domain('haqian.com');
        $this->assertEquals(2, $domain->yinjieNum());

        $domain = new Domain('dapenti.com');
        $this->assertEquals(3, $domain->yinjieNum());

        $domain = new Domain('cuan.com');
        $this->assertEquals(1, $domain->yinjieNum());

        $domain = new Domain('cuqian.com');
        $this->assertEquals(2, $domain->yinjieNum());
    }

}
