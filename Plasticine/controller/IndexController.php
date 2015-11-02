<?php
class IndexController{
	public function Index()
	{
		if(!empty($_GET['name'])){
			$ve=new ViewEngine();
			$content = array('name' => $_GET['name'],'title'=>'Welcome to Plasticine');
			echo $ve->view('index')->take($content)->show();
		}else{
			$ve=new ViewEngine();
			$content = array('name' => 'Everyone!','title'=>'Welcome to Plasticine');
			echo $ve->view('index')->take($content)->show();
		}
	}
}