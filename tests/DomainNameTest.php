<?php

use Greedying\Domain\DomainName;

require __DIR__.'/../vendor/autoload.php';

class DomainNameNameTest extends PHPUnit_Framework_TestCase 
{
    public function testPrefixAndSuffix()
    {
        $domain = new DomainName('test.com');
        $this->assertEquals('test', $domain->prefix);
        $this->assertEquals('com', $domain->suffix);

        $domain = new DomainName('test.net.cn');
        $this->assertEquals('test', $domain->prefix);
        $this->assertEquals('net.cn', $domain->suffix);
    }

    public function testSyllableNum()
    {
        $domain = new DomainName('a.com');
        $this->assertEquals(1, $domain->getSyllableNum());

        $domain = new DomainName('ha.com');
        $this->assertEquals(1, $domain->getSyllableNum());

        $domain = new DomainName('haqian.com');
        $this->assertEquals(2, $domain->getSyllableNum());

        $domain = new DomainName('dapenti.com');
        $this->assertEquals(3, $domain->getSyllableNum());

        $domain = new DomainName('cuan.com');
        $this->assertEquals(1, $domain->getSyllableNum());

        $domain = new DomainName('cuqian.com');
        $this->assertEquals(2, $domain->getSyllableNum());
    }

	public function testGetType()
	{
		/** 
		 * 1数字  2字母 3 杂 4 汉字
		 */
        $domain = new DomainName('123.com');
		$this->assertEquals(1, $domain->getType());

        $domain = new DomainName('abc.com');
		$this->assertEquals(2, $domain->getType());
        $domain = new DomainName('Abc.com');
		$this->assertEquals(2, $domain->getType());
        $domain = new DomainName('ABC.com');
		$this->assertEquals(2, $domain->getType());

        $domain = new DomainName('abc123.com');
		$this->assertEquals(3, $domain->getType());
        $domain = new DomainName('Abc123.com');
		$this->assertEquals(3, $domain->getType());
        $domain = new DomainName('A123Bc.com');
		$this->assertEquals(3, $domain->getType());
        $domain = new DomainName('A123Bc.com');
		$this->assertEquals(3, $domain->getType());

        $domain = new DomainName('测试汉字.com');
		$this->assertEquals(4, $domain->getType());

        $domain = new DomainName('测试汉字123.com');
		$this->assertEquals(5, $domain->getType());
	}

	public function testGetLength()
	{
        $domain = new DomainName('123.com');
		$this->assertEquals(3, $domain->getLength());

        $domain = new DomainName('abc.com');
		$this->assertEquals(3, $domain->getLength());


        $domain = new DomainName('ABC123.com');
		$this->assertEquals(6, $domain->getLength());

        $domain = new DomainName('测试.com');
		$this->assertEquals(2, $domain->getLength());

        $domain = new DomainName('测试abc123.com');
		$this->assertEquals(8, $domain->getLength());
	}

	public function testGetIsFourConsonant()
	{
        $domain = new DomainName('abcd.com');
		$this->assertFalse($domain->getIsFourConsonant());

        $domain = new DomainName('BCDF.com');
		$this->assertTrue($domain->getIsFourConsonant());

        $domain = new DomainName('bcdf.com');
		$this->assertTrue($domain->getIsFourConsonant());

        $domain = new DomainName('BCDFG.com');
		$this->assertFalse($domain->getIsFourConsonant());

        $domain = new DomainName('1234.com');
		$this->assertFalse($domain->getIsFourConsonant());
	}
}
