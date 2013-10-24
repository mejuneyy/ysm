<?php
/**
 * Ysm FrameWrok
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

//框架目录
define('YSM_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

//设定项目根目录
define('PROOT', realpath(dirname(YSM_PATH)).DIRECTORY_SEPARATOR);

//设定项目运行脚本后缀
define('EXT', '.php');

//定义ysm核心类文件夹
$ysm_core_path = $ysm_Frame_Wrok_Path.DIRECTORY_SEPARATOR.'core';

//引用核心类
require $ysm_core_path.DIRECTORY_SEPARATOR.'Ysm.php';

//引用公共方法类
require $ysm_core_path.DIRECTORY_SEPARATOR.'Fun.php';

//清空变量
unset($ysm_Frame_Wrok_Path, $ysm_core_path);