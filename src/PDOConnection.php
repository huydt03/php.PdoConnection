<?php namespace Huydt\PdoConnection;

use Huydt\Event\EventHandle;
use PDO;

class Connector extends EventHandle
{	
	private $EVENT = [
		'onConnectSuccess',
		'onConnectError'
	];

	private $conn;
	
	function __construct()
	{
		parent::__construct($this-> EVENT);
	}

	public function connect($host, $dbname, $username = 'root', $password = ''){
		try {
	 		$this-> conn = new PDO("mysql:host=$host; dbname=$dbname; charset=utf8", $username, $password);
	 		$this-> conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this-> handle['onConnectSuccess']-> fire();
	 	}catch(PDOException $e) {
	 		$this-> handle['onConnectError']-> fire($e->getMessage());
		}
	}

	public function close(){
		$this-> conn = null;
	}

}