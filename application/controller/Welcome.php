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
		$userModel = DM::factory('User');
		$rs = $userModel->join('story')->where('id','=','1')
		->where_open()
		->where('email','=','aaa')
		->where('id' , '>', '10')
		->where_close()
		->or_where_open()
		->where('email','=','bb')
		->where('id' , '<', '50')
		->or_where_close()
		->group_by('mobile')
		->order_by('id', 'desc')
		->limit(4)
		->offset(3)
		->getone()
		;
		//		bulid sql 
		//		select * from `ysm_user` as `user`  LEFT JOIN  `ysm_story` as  `story`  ON `user`.`id` =  `story`.`id`  
		//		WHERE 1 
		//		AND  `user`.`id` ='1' 
		//		AND (  `user`.`email` ='aaa' AND  `user`.`id` >'10' )  
		//		OR (  `user`.`email` ='bb' AND  `user`.`id` <'50' )  
		//		GROUP BY  `user`.`mobile`  
		//		ORDER BY  `user`.`id`  desc 
		//		LIMIT 4 OFFSET 3
		echo "<pre/>";
		print_r($rs);
		exit();
		echo DB::factory()->prefix();
		$db = DB::factory();
		//echo "<pre/>";
		//print_r($db->fields_list('ysm_users'));
		//exit();
		$array = array("a"=>"a","b"=>"b","c"=>"c");
		$hello = "Hello world! 欢迎您看到这个全新的框架<br/>";
		$config = Config::factory('view');
		//$config->set('default_template', 'y');
		$default_theme = $config->get('default_template');
		$this->set('array', $array);
		$this->set('hello', $hello);
		$this->set('default_theme', $default_theme);
		$this->set('id', $id);
	}
 
 }