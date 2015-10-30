<?php
class MongoQuery{
	private $db;
	private $m;
	private $collection;
	private $cursor;

	public function __construct(){
		$conf=Myconf::getconf('database');
		$constr="mongodb://";
		$conf=$conf['Mongodb'];
		if(!empty($conf['user']) and !empty($conf['password'])){
			$constr.=$conf['user'].':'.$conf['password'].'@';
		}
		$constr.=$conf['host'][0];
		for ($i=1; $i <count($conf['host']) ; $i++) { 
			$constr.=','.$conf['host'][$i];
		}
		//"mongodb://user:password@server1:27017,server2:27017,server3:27017"
		//localhost:27017
		$this->db=$conf['db'];
		//echo $constr.'<br />';
		$this->m = new MongoClient($constr); // 连接
	}
	/*
	用于连接mongodb和选择收集器（即关系型数据库的表）
	*/
	public function collect($collect=null)
	{	
		if(empty($collect)){return false;}	
		$this->collection = $this->m->selectCollection($this->db, $collect);
		return $this;
	}

	/*
	$value=array(
	'user'=>"root",
	'password'=>password_hash('123456',PASSWORD_DEFAULT),
	'grade'=>0,
	'typename'=>"超级管理员");
	*/
	public function insert($value=null)
	{	
		if( empty($value) ){return false;}
		return $this->collection->insert($value);
	}
	/*
	$value=array('name' => 'root');
	若要删除_id则如下,_id通过查收集器能看到
	$value=array('_id' => new MongoId($id));
	*/
	public function remove($value=null)
	{	
		if( empty($value) ){return false;}
		//var_dump($value);
		$this->collection->remove($value, array("justOne" => true));
	}
	/*
	$value=array("username" => "root")
	$newvalue=array("typename"=>"超级管理员");//这是要修改或要新增的值
	*/
	public function update($value=null,$newvalue=null)
	{	
		if( empty($value) || empty($newvalue) ){return false;}
		$newdata = array('$set' => $newvalue);
		$this->collection->update($value,$newvalue);
	}
 	/*
 	$value=array( "user" => "root" );
 	$value=array( "grade" => array( “\$gt” => 0, “\$lte” => 3 ) );
 	*/
	public function find($value=null)
	{	
		if(empty($value)){
			$this->cursor = $this->collection->find();
		}else{
			$this->cursor = $this->collection->find($value);	
		}		
		return $this->getdata();
	}
	/**
	 * @return 查询到的是数组
	 */
	private function getdata()
	{
		$data=array();
		while( $this->cursor->hasNext() ) {
			$data[]=$this->cursor->getNext();
		}
		return $data;
	}

}
