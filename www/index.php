<?php
/**
 * Ysm FrameWrok
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */


//设定框架目录
$ysm_Frame_Wrok_Path = "../ysm";

//引用初始化文件
require $ysm_Frame_Wrok_Path.DIRECTORY_SEPARATOR."init.php";

//框架初始化
Ysm::run();