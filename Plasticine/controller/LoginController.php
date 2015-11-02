<?php
class LoginController{
	public function login()
	{
		$ve=new ViewEngine();
		$content = array('test' => 'test','title'=>'Welcome to Plasticine');
		echo $ve->view('test')->take($content)->show();
	}
}