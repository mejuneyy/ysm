<?php
/**
 * Request. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Ysm_View{
	
	//主题
	public static $theme;
	
	//初始化视图文件
	private $_file;
	
	//初始化模板变量
	private $_data;
	
	/**
	 * 构造函数
	 *
	 * @param string $file
	 */
	private function __construct( $file = null){
		if(empty($this->theme)){
			self::$theme = Ysm_Config::factory('view')->get('default_template');
		}
		$path = PROOT.Ysm::$_application.DIRECTORY_SEPARATOR.Ysm::$_view.DIRECTORY_SEPARATOR.self::$theme.DIRECTORY_SEPARATOR;
		if(is_file($path.$file.EXT)){
			$this->_file = $path.$file.EXT;
		}
	}
	
	/**
	 * 视图工厂
	 *
	 * @param sting $file 视图标识
	 */
	public static function factory( $file = null ){
		return new View($file);
	}
	
	/**
	 * 加载视图
	 */
	public function render(){
		if(empty($this->_file)) die("You must set the file to use within your view before rendering");
		if(!empty($this->_data))
		$this->capture();
	}
	
	/**
	 * 加载模板变量
	 */
	private function capture(){
		// Capture the view output
		ob_start();
		extract($this->_data, EXTR_SKIP);
		require $this->_file;
		// Get the captured output and close the buffer
		Response::factory(ob_get_clean())->body();
	}
	
	/**
	 * 模板变量赋值
	 */
	public function set ( $key, $data){
		$this->_data[$key] = $data;
	}
}
