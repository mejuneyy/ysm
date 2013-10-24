<?php
/**
 * Ysm Core
 *
 * @package	Ysm
 * @author June.Yang
 * @copyright(c) www.itqee.com
 *
 */

class Fun {
	
	/**
	 * 数组转对象
	 *
	 * @param array $e
	 * @return object
	 */
	public static function arrayToObject($e){
		if( gettype($e)!='array' ) return;
	    foreach($e as $k => $v)
	    {
	        if( gettype($v)=='array' || getType($v)=='object' )
	        {
	        	$e[$k]=(object)arrayToObject($v);	
	        }
	    }
		return (object)$e;
	}
	
	/**
	 * 对象转数组
	 *
	 * @param object $e
	 * @return array
	 */
	function objectToArray($e){
	    $e=(array)$e;
	    foreach($e as $k=>$v){
	        if( gettype($v)=='resource' ) return;
	        if( gettype($v)=='object' || gettype($v)=='array' )
	            $e[$k]=(array)objectToArray($v);
	    }
	    return $e;
	}
}