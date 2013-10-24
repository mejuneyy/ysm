<?php
/**
 * Ysm_Response. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Ysm_Response {
	//初始化内容
	protected $_content;
	
	//初始化编码
	protected $_charset;
	/**
	 * 构造函数
	 *
	 * @param string $content
	 */
	protected function __construct($content = null){
		if(!empty($content)) $this->_content = $content;
		if(empty($this->_charset)) $this->_charset = Ysm_Config::factory('view')->get('charset');
		header("Content-type: text/html; charset={$this->_charset}");
	}
	
	/**
	 * 工厂方法
	 *
	 * @param unknown_type $content
	 * @return unknown
	 */
	public static function factory( $content = null ){
		return new Response($content);
	}
	
	/**
	 * 输出页面
	 */
	public function body(){
		echo $this->_content;
	}
}