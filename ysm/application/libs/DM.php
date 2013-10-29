<?php
/**
 * Ysm_DM. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Ysm_DM{
	
	//模型目录标识
	private static $_model = 'model';
	
	//class name
	private static $_class;
	
	//prefix
	private $_prefix; 
	
	//table name
	private $_table;
	
	//table name
	private $_db_as_table;
	
	//db query
	private $_query;
	
	//主键,可被子类model重写
	protected $_primary_key; 
	
	//默认排序
	protected $_sort = 'desc';
	
	//执行sql
	protected $_query_sql;
	
	//执行结果
	public $_sql_result;
	
	/**
	 * 单例工厂类
	 *
	 * @param string $config
	 * @return class Ysm_Config
	 */
	public static function factory( $class ){
		self::$_class = $class;
		self::_load( $class );
		$class = 'Model_'.$class;
		return new $class;
	}
	
	/**
	 * 构造函数
	 */
	private function __construct(){
		//获得表前缀标识
		$this->_prefix = DB::factory()->prefix();
		//设定table name
		$this->_table = '`'.$this->_prefix.strtolower(self::$_class).'`';
		//设定tabel转义值
		$this->_db_as_table = strtolower(self::$_class);
		//设定table主键
		$this->_primary_key = DB::factory()->primary_key(trim($this->_table, '`')); 
		//设定table 转义值
		$this->_query[] = array(
			'name' => 'DM_TABLE',
			'args' => $this->_table.' as `'.$this->_db_as_table.'` ',
		);
	}
	
	/**
	 * 加载Model
	 *
	 */
	private static function _load( $model ){
		$_model_list = Ysm::get_files(Ysm::$_application.DIRECTORY_SEPARATOR.self::$_model, false, $model);
		Ysm::load($_model_list);
	}
	
	/**
	 * DM sql where条件组装
	 *
	 * @param string $cloum 字段名
	 * @param string $op	操作 >, <, = , like ... 
	 * @param string $value
	 */
	public function where($cloum, $op, $value, $table = null){
		$_table = empty($table) ? $this->_db_as_table : $table;
		$this->_query[] = array(
			'name' => 'WHERE',
			'args' => array(' `'.$_table.'`.`'.$cloum.'` ', $op, DB::factory()->escape($value)),
		);
		return $this;
	}
	
	/**
	 * DM sql where条件组装 or 
	 *
	 * @param string $cloum
	 * @param string $op
	 * @param string $value
	 */
	public function or_where($cloum, $op, $value, $table = null){
		$_table = empty($table) ? $this->_db_as_table : $table;
		$this->_query[] = array(
			'name' => 'OR_WHERE',
			'args' => array(' `'.$_table.'`.`'.$cloum.'` ', $op, DB::factory()->escape($value)),
		);
		return $this;
	}
	
	/**
	 * where_open
	 */
	public function where_open(){
		$this->_query[] = array(
			'name' => 'WHERE_OPEN',
			'args' => array(),
		);
		return $this;
	}
	
	/**
	 * where_close
	 */
	public function where_close(){
		$this->_query[] = array(
			'name' => 'WHERE_CLOSE',
			'args' => array(),
		);
		return $this;
	}
	
	/**
	 * or_where_open
	 */
	public function or_where_open(){
		$this->_query[] = array(
			'name' => 'OR_WHERE_OPEN',
			'args' => array(),
		);
		return $this;
	}
	
	/**
	 * or_where_close
	 */
	public function or_where_close(){
		$this->_query[] = array(
			'name' => 'OR_WHERE_CLOSE',
			'args' => array(),
		);
		return $this;
	}
	
	/**
	 * DM sql join条件组装
	 *
	 * @param sting $table
	 * @param sting $type
	 * @param sting $on
	 */
	public function join( $table, $type = NULL, $on = NULL){
		//type取值
		$type = empty($type) ? ' LEFT JOIN ' : $type;
		$_table = $this->_prefix.$table;
		$_table_primary_key = DB::factory()->primary_key($_table);
		$_on_table = ' `'.$_table.'` as  `'.$table.'` ';
		$_on = ' `'.$table.'`.`'.$_table_primary_key.'` ';
		$on = empty($on) ? $_on : $on;
		$this->_query[] = array(
			'name' => 'JOIN',
			'args' => array($_on_table, $type, $on),
		);
		return $this;
	}
	
	/**
	 * 排序
	 *
	 * @param string $cloum
	 * @param string $sort
	 */
	public function order_by($cloum, $sort = null, $table = null){
		$sort = empty($sort) ? $this->_sort : $sort;
		$_table = empty($table) ? $this->_db_as_table : $table;
		$cloum = ' `'.$_table.'`.`'.$cloum.'` ';
		$this->_query[] = array(
			'name' => 'ORDER_BY',
			'args' => array($cloum, $sort),
		);
		return $this;
	}
	
	/**
	 * 分页条件 limit
	 *
	 * @param int $limit 显示行数
	 */
	public function limit($limit){
		$this->_query[] = array(
			'name' => 'LIMIT',
			'args' => intval($limit),
		);		
		return $this;
	}
	
	/**
	 * 分页条件 offset
	 *
	 * @param int $offset 起始行
	 */
	public function offset($offset){
		$this->_query[] = array(
			'name' => 'OFFSET',
			'args' => intval($offset),
		);		
		return $this;
	}
	
	/**
	 * group by
	 *
	 * @param string $cloum
	 * @param string $table 
	 */
	public function group_by( $cloum, $table = null ){
		$_table = empty($table) ? $this->_db_as_table : $table;
		$cloum = ' `'.$_table.'`.`'.$cloum.'` ';
		$this->_query[] = array(
			'name' => 'GROUP_BY',
			'args' => $cloum,
		);
		return $this;
	}
	
	/**
	 * 获取单挑数据
	 *
	 */
	public function getone(){
		$this->_db_bulid();
		$this->_sql_result = DB::factory()->query($this->_query_sql)->getone();
		return $this;
	}
	
	
	/**
	 * 获取所有数据
	 *
	 */
	public function getall(){
		$this->_db_bulid();
		$this->_sql_result = DB::factory()->query($this->_query_sql)->getall();
		return $this;
	}
	
	/**
	 * 组装sql语句
	 */
	private function _db_bulid(){
		$sql = 'select * from ';
		$_num_sql_open = 0;
		$_num_where = 0;
		$_num_or = 0;
		foreach ($this->_query as $v){
			switch ($v['name']){
				case 'DM_TABLE':
					$sql .= $this->_bulid_table_name($v['args']);
					break;
				case 'JOIN':
					$sql .= $this->_bulid_join((array)$v['args']);
					break;
				case 'WHERE':
					if($_num_sql_open == 0){
						$sql.=' WHERE 1 AND ';
					}
					if($_num_where != 0){
						$sql.=' AND ';
					}
					$_num_sql_open ++;
					$_num_where++;
					$sql .= $this->_bulid_where((array)$v['args']);
					break;
				case 'OR_WHERE':
					if($_num_where != 0){
						$sql.=' OR ';
					}
					$_num_sql_open ++;
					$_num_where++;
					$sql .= $this->_bulid_where((array)$v['args']);
					break;
				case 'WHERE_OPEN':
					$_num_where = 0;
					$sql .= $this->_bulid_where_open();
					break;
				case 'WHERE_CLOSE':
					$sql .= $this->_bulid_where_close();
					break;
				case 'OR_WHERE_OPEN':
					$_num_where = 0;
					$sql .= $this->_bulid_or_where_open();
					break;
				case 'OR_WHERE_CLOSE':
					$sql .= $this->_bulid_or_where_close();
					break;
				case 'GROUP_BY':
					$sql .= $this->_bulid_group_by($v['args']);
					break;
				case 'ORDER_BY':
					$sql .= $this->_bulid_order_by($v['args']);
					break;
				case 'LIMIT':
					$sql .= $this->_bulid_limit($v['args']);
					break;
				case 'OFFSET':
					$sql .= $this->_bulid_offset($v['args']);
					break;
			}
		}
		$this->_query_sql = $sql;
	}
	
	/**
	 * _bulid_table_name
	 *
	 * @param array $args
	 */
	private function _bulid_table_name($args){
		return $args;
	}
	
	/**
	 * _bulid_where
	 *
	 * @param array $args
	 */
	private function _bulid_where(array $args){
		return $args[0].$args[1].$args[2];
	}
	
	/**
	 * _bulid_where_open
	 *
	 * @param array $args
	 */
	private function _bulid_where_open(){
		return ' AND ( ';
	}
	
	/**
	 * _bulid_where_close
	 *
	 * @param array $args
	 */
	private function _bulid_where_close(){
		return ' ) ';
	}
	
	/**
	 * _bulid_where_open
	 *
	 * @param array $args
	 */
	private function _bulid_or_where_open(){
		return ' OR ( ';
	}
	
	/**
	 * _bulid_where_close
	 *
	 * @param array $args
	 */
	private function _bulid_or_where_close(){
		return ' ) ';
	}
	
	/**
	 * _bulid_join
	 *
	 * @param array $args
	 */
	private function _bulid_join(array $args){
		return $args[1].$args[0].' ON `'.$this->_db_as_table.'`.`'.$this->_primary_key.'` = '.$args[2];
	}
	
	/**
	 * _bulid_limit
	 *
	 * @param string $args
	 */
	private function _bulid_limit($args){
		return ' LIMIT '.intval($args);
	}
	
	/**
	 * _bulid_offset
	 *
	 * @param string $args
	 */
	private function _bulid_offset($args){
		return ' OFFSET '.intval($args);
	}
	
	/**
	 * _bulid_group_by
	 *
	 * @param string $args
	 */
	private function _bulid_group_by($args){
		return ' GROUP BY '.$args;
	}
	
	/**
	 * _bulid_order_by
	 *
	 * @param string $args
	 */
	private function _bulid_order_by($args){
		return ' ORDER BY '.$args[0].' '.$args[1];
	}
	
	/**
	 * 获取上次组装的mysql
	 *
	 */
	public function last_query(){
		return DB::factory()->last_query();
	}
	
	/**
	 * 获取结果集的array
	 */
	public function get_array(){
		return $this->_sql_result;
	}
}
