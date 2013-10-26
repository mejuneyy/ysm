<?php
/**
 * Ysm_MySql. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Ysm_MySql {
	
	//单例成员变量
	private static $_instance;
	
	//私有db对象
	private $_db;
	
	//私有db表前缀
	private $_table_prefix;
	
	//私有mysql result
	private $_result;
	
	//私有mysql 语句
	private $_query;
	
	//私有字段集合
	private $_fields;
	
	//数据库
	private $_database;
	
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
			$this->_conn_to_mysql();
		}
	}
	
	/**
	 * 连接mysql
	 */
	private function _conn_to_mysql(){
		//获取数据库配置标识
		$_conn_config = Ysm_Config::factory('site')->get('db_connection');
		//获取数据库配置
		$_conn_db_array = Ysm_Config::factory('database')->get($_conn_config);
		$this->_db = mysql_connect($_conn_db_array['connection']['hostname'], $_conn_db_array['connection']['username'], $_conn_db_array['connection']['password']) or die('Could not connect: ' . mysql_error());
		mysql_select_db($_conn_db_array['connection']['database']) or die('Could not select database');
		$this->_database = $_conn_db_array['connection']['database'];
		mysql_query('SET NAMES '.$_conn_db_array['charset']);
		$this->_table_prefix = $_conn_db_array['table_prefix'];
	}
	
	
	/**
	 * 获取表前缀
	 *
	 * @return unknown
	 */
	public function _prefix(){
		return $this->_table_prefix;	
	}
	
	/**
	 * sql执行
	 *
	 * @param string $query
	 */
	public function _query( $query ){
		$this->_query = $query;
		$this->_result = mysql_query( $query );
	}
	
	/**
	 * 返回数据库结果对象
	 *
	 * @return mysql result
	 */
	public function _result(){
		return $this->_result;	
	}
	
	/**
	 * 获取单条mysql 结果
	 */
	public function _getone(){
		return mysql_fetch_row( $this->_result, MYSQL_ASSOC);
	}
	
	/**
	 * 获取所有mysql结果
	 */
	public function _getall(){
		$_data = array();
		while ($_rs = mysql_fetch_array($this->_result, MYSQL_ASSOC)) {
		   	$_data[] = $_rs;
		}
		unset($_rs);
		mysql_free_result($this->_result);
		return $_data;
	}
	
	/**
	 * 获取mysql结果条数
	 */
	public function _count(){
		return mysql_num_rows( $this->_result );
	}
	
	/**
	 * 获取上次影响结果的mysql语句
	 */
	public function _last_query(){
		return $this->_query;
	}
	
	/**
	 * 获取上次插入数据的id
	 */
	public function _last_insert_id(){
		return mysql_insert_id();
	}
	
	/**
	 * 获取mysql 表字段
	 */
	public function _fields_list( $table ){
		$db = DB::factory();
		$this->_fields = DB::factory()->query('SHOW FULL COLUMNS FROM `'.$table.'`')->getall();
		return $this->_fields;
	}
	
	/**
	 * 变量转义
	 *
	 * @param string $value
	 */
	public function _escape($value)
	{
		if (($value = mysql_real_escape_string( (string) trim($value), $this->_db)) === FALSE)
		{
			die('error sql query');
		}
		return "'$value'";
	}
	
	/**
	 * 获取主键
	 * 
	 * @param string $table
	 */
	public function _primary_key( $table ){
		$fields = DB::factory()->fields_list( $table );
		foreach ($fields as  $k => $field){
			if( $field['Key'] == 'PRI' ){
				return $field['Field'];
			}
		}
	}
}