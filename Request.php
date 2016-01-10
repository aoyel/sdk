<?php

namespace vendor\sdk;

class Request {
	
	protected static $instance = null;
	
	public static function instance() {
		if (self::$instance == null)
			self::$instance = new static ();
		return self::$instance;
	}
	
	/**
	 * post request
	 * @param string $url
	 * @param mixed $param
	 * @return mixed
	 */
	public function post($url, $param) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//严格认证
		curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
		curl_setopt($curl,CURLOPT_POST,true); // post传输数据
		curl_setopt($curl,CURLOPT_POSTFIELDS,$param);// post传输数据
		$responseText = curl_exec($curl);
		curl_close($curl);
		return $this->parseRespone($responseText);
	}
	
	/**
	 * get request
	 * @param unknown $url
	 * @param string $param
	 * @return mixed
	 */
	public function get($url,$param = null) {
		if(!empty($param))
			$url .= "?".http_build_query($param);
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0 ); 
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
		$responseText = curl_exec($curl);
		curl_close($curl);
		return $this->parseRespone($responseText);
	}
	
	/**
	 * parse result data
	 * @param string $data
	 */
	public function parseRespone($data){
		return json_decode($data,true);
	}
	
	/**
	 * check respone data is ok
	 * @param array|mixed $data
	 * @return boolean
	 */
	public function is_ok($data){
		if(isset($data['status']) && $data['status'] == 1){
			return true;
		}else{
			return false;
		}
	}
}

?>