<?php
/**
 * Ysm_DB. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Ysm_DB{
	
	//单例成员变量
	private static $_instance;
	
	//私有db对象
	private $_db;
	
	//私有db表前缀
	private $_table_prefix;
	
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
	public static function factory(){
		if(! (self::$_instance instanceof self))
		{
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	/**
	 * 构造函数
	 */
	private function __construct(){
		if(empty($this->_db)){
			$this->_conn();
		}
	}
	
	/**
	 * 私有数据库连接
	 */
	private function _conn(){
		//获取数据库配置标识
		$_conn_config = Ysm_Config::factory('site')->get('db_connection');
		if(empty($_conn_config)){
			die('please choose a db config');
		}
		//获取数据库配置
		$_conn_db_array = Ysm_Config::factory('database')->get($_conn_config);
		
		//连接数据库
		switch ($_conn_config['type']){
			case 'MySql':
			default:
				$this->_db = MySql::factory();
		}
		;
	}
	
	/**
	 * 获取表前缀
	 *
	 * @return unknown
	 */
	public function prefix(){
		return $this->_db->_prefix();	
	}
	
	/**
	 * sql执行
	 */
	public function query( $query ){
		$this->_db->_query( $query );
		return self::$_instance;
	}
	
	/**
	 * 返回数据库结果对象
	 *
	 * @return mysql result
	 */
	public function result(){
		return $this->_db->_result();
	}
	
	/**
	 * 获取单条mysql  结果
	 */
	public function getone(){
		return $this->_db->_getone();
	}
	
	/**
	 * 获取所有mysql结果
	 */
	public function getall(){
		return $this->_db->_getall();
	}
	
	/**
	 * 获取mysql结果条数
	 */
	public function count(){
		return $this->_db->_count();
	}
	
	/**
	 * 获取上次影响结果的mysql语句
	 */
	public function last_query(){
		return $this->_db->_last_query();
	}
	
	/**
	 * 获取上次插入数据的id
	 */
	public function last_insert_id(){
		return $this->_db->_last_insert_id();
	}
	
	/**
	 * 获取mysql 表字段
	 */
	public function fields_list( $table ){
		return $this->_db->_fields_list( $table );
	}
	
	/**
	 * 变量转义
	 *
	 * @param string $value
	 */
	public function escape( $value ){
		return $this->_db->_escape( $value );
	}
	
	/**
	 * 获取主键
	 * 
	 * @param string $table
	 */
	public function primary_key( $table ){
		return $this->_db->_primary_key( $table );
	}
}
