<?php
/**
 * Config. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Ysm_Config {
	//单例成员变量
	private static $_instance;
	
	//config配置
	private $_config;
	
	//config 的键值
	private $_key;
	
	//配置目录标识
	private $_config_folder = 'config';
	
	/**
	 * 构造函数
	 */
	private function __construct( $config ){
		if(empty($this->_config->$config)){
			$this->load($config);
			$this->_key = $config;
		}
	}
	
	/**
	 * 禁止克隆
	 *
	 */
	private function __clone(){
		
	}
	
	/**
	 * 单例工厂类
	 *
	 * @param string $config
	 * @return class Ysm_Config
	 */
	public static function factory( $config ){
		if(! (self::$_instance instanceof self) || !array_key_exists($config, self::$_instance->_config))
		{
			self::$_instance = new self($config);
		}
		return self::$_instance;
	}
	
	/**
	 * 获取配置文件
	 *
	 */
	private function load( $config ){
		$_tmp_config = $this->_load($config);
		if(!empty($_tmp_config)){
			$this->_config[$config] = $_tmp_config;
		} else {
			die('You must put a config in your config folder');
		}
	}
	
	/**
	 * 加载配置文件
	 *
	 */
	private function _load( $config ){
		$_config_list = Ysm::get_files($this->_config_folder,false, $config);
		return Ysm::load_and_return($_config_list);
	}
	
	/**
	 * 获取配置文件值
	 *
	 * @param string $key
	 */
	public function get( $key ){
		if(array_key_exists($key, $this->_config[$this->_key])){
			return $this->_config[$this->_key][$key];
		}
		return null;
	}
	
	/**
	 * 设置配置文件值
	 *
	 * @param unknown_type $key
	 */
	public function set( $key, $value){
		$this->_config[$this->_key][$key] = $value;
	}
}
