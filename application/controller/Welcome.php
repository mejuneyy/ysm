<?php
/**
 * Controller_Welcome. 
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

 class Controller_Welcome extends Controller{
 
 	//public $_auto_load = false;
 	
	public function action_index($id = null){
		$array = array("a"=>"a","b"=>"b","c"=>"c");
		$hello = "Hello world! 欢迎您看到这个全新的框架<br/>";
		$config = Config::factory('view');
		$config->set('default_template', 'y');
		$default_theme = $config->get('default_template');
		$this->set('array', $array);
		$this->set('hello', $hello);
		$this->set('default_theme', $default_theme);
		$this->set('id', $id);
	}
 
 }