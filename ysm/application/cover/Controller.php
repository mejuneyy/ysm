<?php
/**
 * Ysm_Controller. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Controller extends Ysm_Controller {
	
	//视图对象
	protected $_ob_view;

	/**
	 * 给模板变量赋值
	 *
	 * @param string $key 变量名
	 * @param string $content 值
	 */
	public function set( $key, $value ){
		if(empty($this->_ob_view)) die('You must load a view before you set a variable');
		$this->_ob_view->set( $key, $value );
	}
}