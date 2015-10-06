<?php 
namespace Greedying\Domain;
class DomainName
{
	public $prefix = '';
	public $suffix = '';
	static $pinyin = [];
	public function __construct($domain_name) {
		$domain_name || exit('缺少域名参数');

		//暂时不考虑 net.cn后缀这种双后缀的情况
		$pos = strpos($domain_name, '.');
		$this->prefix = substr($domain_name, 0, $pos);
		$this->suffix = substr($domain_name, $pos + 1);
	}

	public static function getPinyin()
	{
        if (self::$pinyin === []) {
            self::$pinyin = require_once(__DIR__ . '/../config/pinyin_arr.php');
        }

		return self::$pinyin;
	}

	/***
	 * 类别
	 * 1、纯数字 2、纯字母 3、杂米 4、中文
	 **/
	public function getType()
	{
		if (preg_match("/^\d+$/", $this->prefix)) {
			return 1;
		}
		if (preg_match("/^[A-Za-z]+$/", $this->prefix)) {
			return 2;
		}

		if (preg_match("/\d+/", $this->prefix) &&			//含数字
			preg_match("/[A-Za-z]+/", $this->prefix) &&		//含字母
			preg_match("/^[a-zA-Z\d]+$/", $this->prefix)
		) {	//只含数字字母
			return 3;
		}

		if (preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $this->prefix)) {
			return 4;
		}

		return 5;//其他
	}

	public function getIsFourConsonant()
	{
		if (preg_match("/^[BCDFGHJKLMNPQRSTWXYZbcdfghjklmnpqrstwxyz]{4}$/", $this->prefix)) {
			return true;
		} else {
			return false;
		}
	}


	/****
	 * 长度
	 ***/
	public function getLength()
	{
		return mb_strlen($this->prefix);
	}

	/**
	 * 获取域名的音节数
	 * 实在不知道音节数英文怎么表述了，阿门
	 **/
	public function syllableNum()
	{
        return $this->getSyllableNum($this->prefix);
	}

	public function getSyllableNum($str)
	{
		$pinyin = self::getPinyin();
		if (isset($pinyin[$str])) return 1;

		$num = min(strlen($str), 7);
		//倒序的目的, cuan这样可以理解为双拼可以理解为单拼的，理解为单拼
		for ($i = $num; $i > 0; $i--){
			if (isset($pinyin[substr($str, 0, $i)]) && 
				$n = $this->getSyllableNum(substr($str, $i))) {
				return $n + 1;
			}
		}
		return 0;
	}
}
