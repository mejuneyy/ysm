ysm
===

A lightweight PHP Framework

这是一个全新的php轻量级框架，给新手共同学习交流使用，我会尽量给全中文注释。框架结构通俗易懂。

2013.10.24 更新
已实现模板与逻辑分离，能够接收url分段，详情见welcome控制器 action_index方法

```php

  public function action_index($id = null){
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
	
```

交流email： mejuney@gmail.com
