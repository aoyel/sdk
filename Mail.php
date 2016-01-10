<?php

namespace vendor\aoyel;

class Mail {

	protected $data;
	public $apiHost = "http://api.aoyel.com";
	private $_address;
	private $_param;
	private $_error;
	private $_appid = null;

	function __construct($appid){
		$this->_address = [];
		$this->_param = [];
		$this->_appid = $appid;
	}

	protected function setLastError($error){
		$this->_error = $error;
	}
	public function getLastError(){
		return $this->_error;
	}
	/**
	 * send mail
	 * @param string $appid
	 */
	public function send(){
		$this->prepare();

		$respone = Request::instance()->post($this->apiHost."/mail/send?appid={$this->_appid}", json_encode($this->data));
		if(is_array($respone) && $respone['status'] == 1){
			return $respone['data'];
		}else{
			if(isset($respone['data'])){
				$this->setLastError($respone['data']);
			}
		}
		return false;
	}

	/**
	 * query mail state
	 * @param string $appid
	 * @param string $mailId
	 */
	public function query($appid,$mailId){
		$data = [
				'appid'=>$appid,
				'id'=>$mailId
		];
		$respone = Request::instance()->post($this->apiHost."/mail", json_encode($this->data));
		$result = Request::instance()->parseResult($respone);
	}

	/**
	 * add template param
	 * @param string $name
	 * @param string $value
	 */
	public function addParam($name,$value){
		$this->_param[$name] = $value;
		$this->data['params'] = $this->_param;
	}

	/**
	 * set template id
	 * @param string $templateId
	 */
	public function setTemplateId($templateId){
		$this->data['templateId'] = $templateId;
		$this->data['type'] = 1;
	}

	public function setFromAddress($address){
		$this->data['from_address'] = $address;
	}


	public function setFromName($name){
		$this->data['from_name'] = $name;
	}

	public function setIsHtml($is_html){
		$this->data['is_html'] = $is_html;
	}

	public function setIsSSL($is_ssl){
		$this->data['is_ssl'] = $is_ssl;
	}


	public function setServerHost($host){
		$this->data['mail_host'] = $host;
	}

	public function setServerPort($port){
		$this->data['mail_port'] = $port;
	}

	public function setServerUser($user){
		$this->data['mail_user'] = $user;
	}

	public function setServerPassword($password){
		$this->data['mail_password'] = $password;
	}

	/**
	 * add send to address
	 * @param string $address
	 */
	public function addAddress($address){
		$this->_address[] = $address;
		$this->data['to_address'] = implode(",", $this->_address);
	}

	public function setChartset($charset){
		$this->data['charset'] = $charset;
	}

	/**
	 * check data is full
	 * @return bool
	 * @throws \Exception
	 */
	protected function prepare(){
		/**
		 * check data complate
		 */
		if(empty($this->data) || !isset($this->data['to_address'])){
			throw new \Exception("数据不完整");
		}
		if(empty($this->data['templateId'])){
			throw new \Exception("邮箱内容不能为空");
		}
		return true;
	}
}
?>