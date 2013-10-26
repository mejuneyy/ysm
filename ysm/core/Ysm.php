<?php
/**
 * Ysm Core
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Ysm {
	const NUMBER_ONE = 1;
	//常规url长度
	const NORMAL_URI_LENGTH = 2;

	//部署跳转文件夹标识
	public static $SFOLDER = '';

	//控制器
	public static $CONTROLLER = '';

	//视图
	public static $VIEW = '';
	
	//项目目录标识
	public static $_application = 'application';
	
	//控制器目录标识
	public static $_controller = 'controller';
	
	//视图目录标识
	public static $_view = 'view';
	
	//扩展目录标识
	public static $_module = 'module';

	//缓存目录标识
	public static $_cache = 'cache';
	
	//日志目录标识
	public static $_logs = 'logs';

	//类目录标识
	public static $_libs = 'libs';
	
	//重写类目录标识
	public static $_cover = 'cover';

	//files列表变量
	private static $_files = array();
	
	//配置列表变量
	private static $_load_array = array();

	//构造函数
	public function __construct(){

	}
	
	/**
	 * 初始化
	 *
	 */
	public static function run(){

		//自动加载文件
		self::auto_load();
	}
	
	/**
	 * 自动加载文件
	 *
	 */
	private static function auto_load(){
		self::_must_load_in_turn();
		//加载类文件
		self::load(self::$_files);
		//获取开启模块
		$_open_module_list = Ysm_Config::factory('Module')->get('open_module');
		//重置类文件列表
		self::$_files = array();
		//获取模块类列表
		foreach ($_open_module_list as $module => $module_path){
			self::_must_load_in_turn(self::$_module.DIRECTORY_SEPARATOR.$module_path.DIRECTORY_SEPARATOR);
		}
		//再次加载类文件
		if(!empty(self::$_files)){
			self::load(self::$_files);
		}
		//设置控制器视图
		Ysm_Request::set_mvc();
		//加载控制器
		self::jump();
	}
	
	/**
	 * 必备的加载顺序
	 *
	 */
	private static function _must_load_in_turn($module = null){
		//核心必须加载的类加载
		$_lib_path = $module.self::$_application.DIRECTORY_SEPARATOR.self::$_libs;
		//核心类文件入队列
		self::files($_lib_path, true);
		//重写核心必须加载的类加载
		$_cover_path = $module.self::$_application.DIRECTORY_SEPARATOR.self::$_cover;
		//重写核心类文件入队列
		self::files($_cover_path, true);
		//控制器类文件
		$_controller_path = $module.self::$_application.DIRECTORY_SEPARATOR.self::$_controller;
		//控制器类文件入队列
		self::files($_controller_path, true);
	}
	
	/**
	 * 加载控制器
	 *
	 */
	private static function jump(){
		//控制器文件目录
		$_controller_path = PROOT.self::$_application.DIRECTORY_SEPARATOR.self::$_controller.DIRECTORY_SEPARATOR;
		$_controller_path = !empty(self::$SFOLDER)? $_controller_path.self::$SFOLDER.DIRECTORY_SEPARATOR : $_controller_path;
		//加载控制器
		$_controller_path_file = $_controller_path.ucwords(self::$CONTROLLER).EXT;
		self::load($_controller_path_file);
		$class = 'Controller_'.ucwords(self::$CONTROLLER);
		$view = 'action_'.self::$VIEW;
		$c = new $class;
		$uc = Ysm_Request::URI_COUNT();
		if(is_numeric(Ysm_Request::URI($uc))){
			$c->$view(Ysm_Request::URI($uc));
		}else{
			$c->$view();
		}
	}
	
	/**
	 * 查找文件
	 *
	 * @param string $pathCode
	 * @param boolean $is_core 是否需要只查找框架核心文件，默认为否
	 * @param string $file
	 */
	private static function files( $pathCode, $is_core = false, $file = NULL ){
		//查找框架核心类文件
		$_ysm_lib_path = YSM_PATH.$pathCode;
		//入文件队列
		self::_files($_ysm_lib_path, $file);
		if(!$is_core){
			//查找本地类文件
			$_lib_path = PROOT.$pathCode;
			//入文件队列
			self::_files($_lib_path, $file);	
		}
	}

	/**
	 * 查找文件
	 *
	 * @param string $pathCode
	 * @param string $file
	 */
	private static function _files( $path, $file = NULL){
		if(is_dir($path)){
			//遍历文件
			$_tmp_files = scandir($path);
			//文件数
			$_files_count = sizeof($_tmp_files);
			for($i = 2; $i<$_files_count; $i++){
				$__file_name = rtrim($_tmp_files[$i], EXT);
				//如果指定文件名，则只文件名相同入队列，否则文件夹下所有文件入队列
				if(!empty($file)){
					if(ucwords($file) == $__file_name && is_file($path.DIRECTORY_SEPARATOR.$_tmp_files[$i]))
					self::$_files[] = $path.DIRECTORY_SEPARATOR.$_tmp_files[$i];	
				}else{
					if(is_file($path.DIRECTORY_SEPARATOR.$_tmp_files[$i]))
					self::$_files[] = $path.DIRECTORY_SEPARATOR.$_tmp_files[$i];
				}
			}
		}
	}
	
	/**
	 * 加载文件
	 *
	 * @param array $files
	 */
	public static function load( $files ){
		if(is_array($files)){
			foreach($files as $file){
				self::load($file);
			}
		}else{
			require $files;
		}
	}
	
	/**
	 * 加载文件并返回文件内容
	 *
	 * @param array $files
	 */
	public static function load_and_return( $file ){
		if(is_array($file)){
			foreach ($file as $f){
				self::load_and_return($f);
			}
		}else{
			$_array = require $file;
			foreach ($_array as $_k => $_v){
				self::$_load_array[$_k] = $_v;
			}
		}
		return self::$_load_array;
	}
	
	/**
	 * 设置断点调试变量
	 *
	 * @param string $string
	 */
	public static function ed( $string ){
		echo "<pre/>";
		print_r($string);
		exit();
	}
	
	/**
	 * 外部调用查找文件
	 *
	 * @param string $pathCode
	 * @param boolean $is_core 是否需要只查找框架核心文件，默认为否
	 * @param string $file
	 * @return array $_files 返回文件列表
	 */
	public static function get_files($pathCode,$is_core = false, $file = NULL){
		//重新初始化files队列
		self::$_files = array();
		//文件入队列
		self::files($pathCode, $is_core, $file);
		return self::$_files;
	}
}