<?php
/**
 * 
 */
class Router{
	private $methed;
	private $rl=2;//用于路由层次统计
	private $confs;
	public function __construct($confs){
		$this->confs=$confs;
	}
	private function routerlevel($router)
	{
		$methed=array();
		foreach ($router as $controller => $controllervalue) {
			$methed[$controller]=array();
			if(!empty($router[$controller]['controller'])){
				$methed[$controller]=$this->routerlevel($router[$controller]['controller']);
				$this->rl++;
				
			}else{
				foreach ($router[$controller]['action'] as $action => $mothed) {
					$methed[$controller][$action]=$mothed;
				}					
			}

		}
		return $methed;
	}
	private function router_undefined($methed="")
	{
		if($methed!='GET' and $methed!='POST'){
			$this->location_controller('Index','index');
			exit();
		}
	}
	private function location_controller($cname,$fname)
	{
		$controllername=$cname.'Controller';
		$controller_funname=$fname;
		$controller=new $controllername();
		$controller->$controller_funname();
	}
	public function torouter()
	{	
		$router=$this->routerlevel($this->confs['controller']);
		$this->methed=$router;
		preg_match_all( '/\w+/i', $_SERVER['REQUEST_URI'] , $myrouter);
		//var_dump($myrouter[0]);
		if(empty($myrouter[0][0])){
			$this->router_undefined();
		}
		if(empty($this->methed[$myrouter[0][0]])){
			$this->router_undefined();
		}
		$methed=$this->methed[$myrouter[0][0]];
		for ($i=1; $i <count($myrouter[0]); $i++) { 
			// var_dump($methed);
			if(empty($methed[$myrouter[0][$i]])){
				$methed="";
				break;
			}else{
				$methed=$methed[$myrouter[0][$i]];
			}
			
			if($methed=='GET'||$methed=='POST'){
				break;
			}
		}
		$this->router_undefined($methed);
		$this->location_controller($myrouter[0][$i-1],$myrouter[0][$i]);
	}	
}