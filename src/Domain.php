<?php 
namespace Greedying\Domain;
class Domain 
{
	public $prefix = '';
	public $suffix = '';
	static $pinyin = [];
	public function __construct($domain_name) {
		//暂时不考虑 net.cn后缀这种双后缀的情况
		$pos = strripos($domain_name, '.');
		$this->prefix = substr($domain_name, 0, $pos);
		$this->suffix = substr($domain_name, $pos + 1);
        if (self::$pinyin === array()) {
            self::$pinyin = require_once(__DIR__ . '/../config/pinyin_arr.php');
        }
	}

	/**
	 * 获取域名的音节数
	 * 实在不知道音节数英文怎么表述了，阿门
	 **/
	public function yinjieNum()
	{
        return $this->getYinjieNum($this->prefix);
	}

    public function getYinjieNum($str)
    {
		if (isset(self::$pinyin[$str])) {
			return 1;
		}

		$num = min(strlen($str), 7);
		/**
		 * 倒序的目的, cuan这样可以理解为双拼可以理解为单拼的，理解为单拼
		**/
		for ($i = $num; $i > 0; $i--){
			if (isset(self::$pinyin[substr($str, 0, $i)]) && $n = $this->getYinjieNum(substr($str, $i))) {
				return $n + 1;
			}
		}

		return 0;
    }
}
