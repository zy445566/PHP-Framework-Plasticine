<?php
class ViewEngine{
	private $path;
	private $compiled;
	private $view;
	private $compile_file;
	private $right_math;
	private $left_math;
	private $arr_var=array();
	public function __construct(){
		$confstr=file_get_contents(dirname($_SERVER['DOCUMENT_ROOT']).'/conf/view.conf');
		$conf=json_decode($confstr,true);
		$conf=$conf['view'];
		$this->path=dirname($_SERVER['DOCUMENT_ROOT']).'/'.$conf['path'];
		$this->compiled=dirname($_SERVER['DOCUMENT_ROOT']).'/'.$conf['compiled'];
		$this->right_math=$conf['right_math'];
		$this->left_math=$conf['left_math'];
	}
	private function replaceview($content)
	{
		$pattern=array();
		$replacement=array();
		$pattern[]='/'.preg_quote($this->left_math).'\$([a-zA-Z]\w*)'.preg_quote($this->right_math).'/';
		$replacement[]='<?php echo $this->arr_var["${1}"]; ?>';
		foreach ($this->arr_var as $key => $value) {
			$pattern[]='/\$('.preg_quote($key).')/';
			$replacement[]='$this->arr_var["${1}"]';
		}
		$repContent=preg_replace($pattern,$replacement,$content);
		return $repContent;
	}
	private function compile($view)
	{	

		$view_file=$this->path.'/'.$view.".php";
		if(!file_exists($view_file)){
			return false;
		}
		$compile_file=$this->compiled."/".$view.".php";
		$content=file_get_contents($view_file);
		$pattern='/(include|require|include_once|require_once).*?["\'](.*?)\.php["\']\)/';
		if(preg_match_all($pattern, $content,$isinclude)){
			foreach ($isinclude[2] as $key => $value) {
				$this->compile($value);
			}
		}
		if(!file_exists($compile_file) || filemtime($compile_file)< filemtime($view_file)){
			$repContent=$this->replaceview($content);
			file_put_contents($compile_file,$repContent);
		}
		return true;
	}
	public function view($view)
	{
		$this->view=$view;
		$this->compile_file=$this->compiled."/".$this->view.".php";
		return $this;
		
	}
	public function take($value)
	{	
		$this->arr_var=$value;
	}
	public function __destruct(){
		//clearstatcache();
		if(!$this->compile($this->view)){
			return false;
		}
		include_once ($this->compile_file);
	}
}