<?php
class Myconf{
	private static $confs;
	public static function setconf($confs)
	{
		self::$confs=$confs;
	}
	public static function getconf($conftype)
	{
		return self::$confs[$conftype];
	}
}