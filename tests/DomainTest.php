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

    public function testSyllableNum()
    {
        $domain = new Domain('a.com');
        $this->assertEquals(1, $domain->syllableNum());

        $domain = new Domain('ha.com');
        $this->assertEquals(1, $domain->syllableNum());

        $domain = new Domain('haqian.com');
        $this->assertEquals(2, $domain->syllableNum());

        $domain = new Domain('dapenti.com');
        $this->assertEquals(3, $domain->syllableNum());

        $domain = new Domain('cuan.com');
        $this->assertEquals(1, $domain->syllableNum());

        $domain = new Domain('cuqian.com');
        $this->assertEquals(2, $domain->syllableNum());
    }

	public function testGetType()
	{
		/** 
		 * 1数字  2字母 3 杂 4 汉字
		 */
        $domain = new Domain('123.com');
		$this->assertEquals(1, $domain->getType());

        $domain = new Domain('abc.com');
		$this->assertEquals(2, $domain->getType());
        $domain = new Domain('Abc.com');
		$this->assertEquals(2, $domain->getType());
        $domain = new Domain('ABC.com');
		$this->assertEquals(2, $domain->getType());

        $domain = new Domain('abc123.com');
		$this->assertEquals(3, $domain->getType());
        $domain = new Domain('Abc123.com');
		$this->assertEquals(3, $domain->getType());
        $domain = new Domain('A123Bc.com');
		$this->assertEquals(3, $domain->getType());
        $domain = new Domain('A123Bc.com');
		$this->assertEquals(3, $domain->getType());

        $domain = new Domain('测试汉字.com');
		$this->assertEquals(4, $domain->getType());

        $domain = new Domain('测试汉字123.com');
		$this->assertEquals(5, $domain->getType());
	}

	public function testGetLength()
	{
        $domain = new Domain('123.com');
		$this->assertEquals(3, $domain->getLength());

        $domain = new Domain('abc.com');
		$this->assertEquals(3, $domain->getLength());


        $domain = new Domain('ABC123.com');
		$this->assertEquals(6, $domain->getLength());

        $domain = new Domain('测试.com');
		$this->assertEquals(2, $domain->getLength());

        $domain = new Domain('测试abc123.com');
		$this->assertEquals(8, $domain->getLength());
	}

	public function testGetIsFourConsonant()
	{
        $domain = new Domain('abcd.com');
		$this->assertFalse($domain->getIsFourConsonant());

        $domain = new Domain('BCDF.com');
		$this->assertTrue($domain->getIsFourConsonant());

        $domain = new Domain('bcdf.com');
		$this->assertTrue($domain->getIsFourConsonant());

        $domain = new Domain('BCDFG.com');
		$this->assertFalse($domain->getIsFourConsonant());

        $domain = new Domain('1234.com');
		$this->assertFalse($domain->getIsFourConsonant());
	}
}
