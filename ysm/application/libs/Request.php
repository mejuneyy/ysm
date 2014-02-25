<?php
/**
 * Request. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Ysm_Request{
	
	//url初始化
	private static $_url = '';

	//初始化参数值
	private static $_uri_list = array();

	private static function _setURL(){
		self::$_url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
		self::$_uri_list = explode('/', ltrim(self::$_url, '/'));
	}
	
	/**
	 * 获取参数
	 *
	 * @param string $pathCode
	 * @param string $file
	 */
	public static function URI( $i ){
		if(empty(self::$_uri_list))
		{
			self::_setURL();
		}
		return empty(self::$_uri_list[$i-1]) ? "" : self::$_uri_list[$i-1];
	}

	/**
	 * 获取参数总数
	 *
	 * @param string $pathCode
	 * @param string $file
	 */
	public static function URI_COUNT(){
		if(empty(self::$_uri_list))
		{
			self::_setURL();
		}
		return sizeof(self::$_uri_list);
	}

	/**
	 * 设置控制器视图
	 *
	 */
	public static function set_mvc(){
		//参数长度
		$_uri_length = self::URI_COUNT();
		//当uri参数长度大于常规，并且最后一位不为数字，则第一个参数为文件夹，否则第一个即为控制器
		if($_uri_length > Ysm::NORMAL_URI_LENGTH && !is_numeric(self::URI(Ysm::NORMAL_URI_LENGTH +1))){
			Ysm::$SFOLDER = Ysm_Request::URI(Ysm::NORMAL_URI_LENGTH - 1 );
			Ysm::$CONTROLLER = Ysm_Request::URI(Ysm::NORMAL_URI_LENGTH);
			Ysm::$VIEW = Ysm_Request::URI(Ysm::NORMAL_URI_LENGTH + 1);
		} elseif ( $_uri_length == Ysm::NORMAL_URI_LENGTH || ( $_uri_length > Ysm::NORMAL_URI_LENGTH && is_numeric(self::URI(Ysm::NORMAL_URI_LENGTH +1)))){
			Ysm::$CONTROLLER = Ysm_Request::URI(Ysm::NORMAL_URI_LENGTH - 1);
			Ysm::$VIEW = Ysm_Request::URI(Ysm::NORMAL_URI_LENGTH);
		} elseif ( $_uri_length == Ysm::NUMBER_ONE && empty(self::$_uri_list[Ysm::NUMBER_ONE - 1])){
			Ysm::$CONTROLLER = Ysm_Config::factory('site')->get('default_controller');
			Ysm::$VIEW = Ysm_Config::factory('site')->get('default_action');
		}
	}
}
