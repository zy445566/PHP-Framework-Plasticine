<?php
/**
 * 用于框架初始化，如读取配置，自动载入库，等等
 */
class Bootstrap{
	private $mydir="";
	private $confs;
	public function __construct($mydir){
		$this->mydir=$mydir;		
	}
	/**
	 * 用于获取私有变量
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public function __get($name){ 
		return $this->$name; 
	}
	/**
	 * 用于设置私有变量
	 * @param [type] $name  [description]
	 * @param [type] $value [description]
	 */
	public function __set($name,$value){ 
		$this->$name = $value; 
	}
	/**
	 * [setclassdir description]
	 * @param  [type] $classdir  [description]
	 * @param  [type] $classname [description]
	 * @return [type]            [description]
	 */
	public function setclassdir($classdir)
	{	
		$thisdir=$this->mydir.'/'.$classdir.'/';
		spl_autoload_register(function ($classname) use ($thisdir) {
			$classfile=$thisdir.$classname.'.php';
			if (file_exists($classfile)){
				include_once($classfile);
			}
		});
	}
	/**
	 * [autoclass description]
	 * @param  [type] $classdir [description]
	 * @return [type]           [description]
	 */
	public function autoclass()
	{
		foreach ($this->confs["autoload"] as $library_key => $library_name) {
			$this->setclassdir($library_name);
		}
	}
	/**
	 * [getconf description]
	 * @param  [type] $confdir [description]
	 * @return [type]          [description]
	 */
	private function getconf($confdir)
	{
		$dir=opendir($this->mydir.'/'.$confdir);
		$confs=array();
		while(($file=readdir($dir))!==false){
			if($file!='.' && $file!='..'){
				$confstr=file_get_contents($this->mydir.'/'.$confdir.'/'.$file);
				$conf=json_decode($confstr,true);
				$isconf=explode('.',$file);
				if($isconf[1]='conf'){
					$confs[$isconf[0]]=$conf[$isconf[0]];
				}
				
			}
		}
		closedir($dir);
		return $confs;
	}

	/**
	 * [run description]
	 * @return [type] [description]
	 */
	public function run()
    {	
    	session_start();
    	$this->confs=$this->getconf('conf');
    	$this->autoclass();
    	Myconf::setconf($this->confs);
    }

	public function __destruct(){

	}
}