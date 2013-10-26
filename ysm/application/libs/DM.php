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
	
	//db query
	private $_query;
	
	//主键,可被子类model重写
	protected $_primary_key; 
	
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
		//设定table主键
		$this->_primary_key = DB::factory()->primary_key(trim($this->_table, '`')); 
		//设定table 转义值
		$this->_query['DM_table'] = $this->_table.' as `'.self::$_class.'`';
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
	public function where($cloum, $op, $value){
		$this->_query['WHERE'][] = array('`'.$cloum.'`', $op, DB::factory()->escape($value));
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
		$type = empty($type) ? 'LEFT JOIN' : $type;
		$_table = $this->_prefix.$table;
		$_table_primary_key = DB::factory()->primary_key($_table);
		$_on_table = '`'.$_table.'` as  `'.$table.'`';
		$_on = '`'.$table.'`.'.$_table_primary_key;
		$on = empty($on) ? $_on : $on;
		$this->_query['JOIN'][] = array($_on_table, $type, $on);
		return $this;
	}

}
