<?php	
class DBManager
{
	public $link;
	
	public $host;
	public $username;
	public $password;
	public $dbname;

	function __construct($host,$username,$password, $dbname)
	{
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;

		$this->connect();
	}

	public function connect()
	{
		$this->link = new mysqli($this->host, $this->username, $this->password, $this->dbname);
		// Check connection
    if ($this->link->connect_error)
    {
      die("Connection failed: " . $this->link->connect_error);
    }
	}
	public function QuerySingleRow()
	{
		$args = func_get_args();
		$sql = $args[0];

		foreach ($args as $key => $arg) {
			if($key >= 1) {
				$arg = $this->link->real_escape_string($arg);

				$sql = str_replace("%a".($key-1), $arg, $sql);
			}
		}
		$result = $this->link->query($sql);
	  if($result !== false) {
	  	if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				//$this->link->close();
	      return $row;
	    }
	  }
   // $this->link->close();
    return null;
	}

	public function insert() {
		$args = func_get_args();
		$sql = $args[0];

		foreach ($args as $key => $arg) {
			if($key >= 1) {
				$arg = $this->link->real_escape_string($arg);
				$sql = str_replace("%a".($key-1), $arg, $sql);
			}
		}
		$result = $this->link->query($sql);
		
		return ($result === TRUE);
	}

	public function delete()
	{
		$args = func_get_args();
		$sql = $args[0];

		foreach ($args as $key => $arg) {
			if($key >= 1) {
				$arg = $this->link->real_escape_string($arg);
				$sql = str_replace("%a".($key-1), $arg, $sql);
			}
		}
		$result = $this->link->query($sql);
		
		return ($result === TRUE);
	}
	public function query()
	{
		$args = func_get_args();
		$sql = $args[0];
		foreach ($args as $key => $arg) {
			if($key >= 1) {
				$arg = $this->link->real_escape_string($arg);
				$sql = str_replace("%a".($key-1), $arg, $sql);
			}
		}
		$result = $this->link->query($sql);
		$res = array();
		if($result !== false) {
			if ($result->num_rows > 0) {
			  while($row = $result->fetch_assoc()) {
			    array_push($res, $row);
			  }
			} else {
			  $res = null;
			}
		} else {
			$res = null;
		}
		//$this->link->close();
		return $res;
	}
}
?>


