<?php
class DbConfig 
{	
	private $_host = 'localhost';
	private $_username = 'njlsehp_root';
	private $_password = 'a3v^CLZP@0ri';
	private $_database = 'njlsehp_lush_prod';
	
	protected $connection;
	
	public function __construct()
	{
		if (!isset($this->connection)) {
			
			$this->connection = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
			
			if (!$this->connection) {
				die('Cannot connect to database server');
				exit;
			}			
		}	
		
		return $this->connection;
	}
}
?>
