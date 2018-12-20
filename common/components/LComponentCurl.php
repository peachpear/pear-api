<?php
namespace common\components;

use yii\base\Component;

/**
 * Class LComponentCurl
 * @package common\components
 * User: iBaiYang
 */
class LComponentCurl extends Component
{
	private $url;
	private $ch;
	public $proxy;

	public function init()
	{
		parent::init();
		$proxyHost = isset($this->proxy['host']) && $this->proxy['host'] ? $this->proxy['host'] : '0.0.0.0';
		$proxyPort = isset($this->proxy['port']) && $this->proxy['port'] ? $this->proxy['port'] : 0;
		$this->ch = curl_init();
		// 如果有配置代理这里就设置代理
		if ($proxyHost != "0.0.0.0" && $proxyPort != 0) {
			curl_setopt($this->ch,CURLOPT_PROXY, $proxyHost);
			curl_setopt($this->ch,CURLOPT_PROXYPORT, $proxyPort);
		}
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
	}

	public function setUrl($url)
	{
		if (!$url) return false;
		if (!is_resource($this->ch))
		{
			$this->init();
		}
		curl_setopt($this->ch, CURLOPT_URL, $url);
		$this->url = $url;
	}

	public function setPostField($array)
	{
		if (!is_resource($this->ch))
		{
			$this->init();
		}
		curl_setopt($this->ch, CURLOPT_POST, 1);
		curl_setopt($this->ch, CURLOPT_POSTFIELDS, $array);
	}


	public function setOptions($array)
	{
		if (!$array) return false;
		if (!is_resource($this->ch))
		{
			$this->init();
		}
		curl_setopt_array($this->ch, $array);
	}

	public function close()
	{
		curl_close($this->ch);
	}

	public function __destruct()
	{
		if (is_resource($this->ch))
		{
			curl_close($this->ch);
		}
		$this->url = "";
	}

	public function execute()
	{
		return curl_exec($this->ch);
	}

	public function getErrorInfo($type=1)
	{
		if ($type == 1)
		{
			return curl_error($this->ch);
		}
		elseif ($type == 2)
		{
			return curl_errno($this->ch);
		}
		else
		{
			return curl_strerror(curl_errno($this->ch));
		}

	}
}