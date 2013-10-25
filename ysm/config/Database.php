<?php
/**
 * 视图相关配置文件
 */

return array(
	'default' => array
    (
        'type'       => 'MySql',
        'connection' => array(
            'hostname'   => 'localhost',
            'username'   => 'root',
            'password'   => 'root',
            'persistent' => FALSE,
            'database'   => 'ysm',
        ),
        'table_prefix' => 'ysm_',
        'charset'      => 'utf8',
    ),
);
