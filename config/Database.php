<?php
/**
 * 视图相关配置文件
 */

return array(
	'default' => array
    (
        'type'       => 'MySQL',
        'connection' => array(
            'hostname'   => 'localhost',
            'username'   => 'root',
            'password'   => 'root',
            'database'   => 'ysm',
        ),
        'table_prefix' => 'ysm_',
        'charset'      => 'utf8',
    ),
    
    'other' => array
    (
        'type'       => 'MySQL',
        'connection' => array(
            'hostname'   => 'localhost',
            'username'   => 'root',
            'password'   => 'root',
            'database'   => 'ysm',
        ),
        'table_prefix' => 'ysm_',
        'charset'      => 'utf8',
    ),
);
