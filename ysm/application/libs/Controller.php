<?php
/**
 * Ysm_Controller. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Ysm_Controller {
	
	//自动加载模板
	public $_auto_load = true;
	
	//页面主体
	public $body;
	
	//视图对象
	protected $_ob_view;
	
	/**
	 * 构造函数
	 *
	 */
	public function __construct(){
		$this->init();
	}
	
	/**
	 * 初始化控制器准备工作
	 */
	protected function init(){
		if($this->_auto_load){
			// 加载视图模板
			$this->load_view();
		}
	}
	
	/**
	 * 加载视图模板
	 */
	protected function load_view(){
		$folder = empty(Ysm::$SFOLDER) ? '' : Ysm::$SFOLDER.DIRECTORY_SEPARATOR;
		$this->_ob_view = View::factory($folder.ucwords(Ysm::$CONTROLLER).DIRECTORY_SEPARATOR.Ysm::$VIEW);
		unset($folder);
	}
	
	/**
	 * 加载视图
	 */
	protected function render()
	{
		$this->_ob_view->render();
	}
	
	/**
	 * 析构函数
	 */
	public function __destruct(){
		if(!empty($this->_ob_view)){
			//加载视图
			$this->_ob_view->render();
		}
	}
}