<?php
class Users_Model {

	public $database;
	public function __construct(){
		$this->database = new Database_Library;
	}
	//declare table name and its columns here
	protected  $table_name="users";
	protected  $db_fields = array('user_id', 'username', 'password', 'email', 'security_id','active','date_created');	
	public $user_id;
	public $username;
	public $password;
	public $email;
	public $security_id;
	public $active;
	public $date_created;
	//authenticate users
	public  function authenticate($username="", $password="") {
	    $username = $this->database->escape_value($username);
	    $password = $this->database->escape_value($password);
	    $sql  = "SELECT * FROM ".$this->table_name." ";
	    $sql .= "WHERE username = '{$username}' ";
	    $sql .= "AND password = '{$password}' ";
	    $sql .= "LIMIT 1";
	    $result_array = $this->find_by_sql($sql);
			return !empty($result_array) ? array_shift($result_array) : false;
	}
	
	public function get_user_data($username=""){
		$i=0;
		$data=array();
		$username= $this->database->escape_value($username);
		$sql="SELECT * FROM ".$this->table_name." WHERE username= '{$username}'";
		$result_set=$this->database->query($sql);
		while ($arr= $this->database->fetch_assoc($result_set)){
			foreach ($arr as $key => $value) {
				$data[$i][$key]=$value;
			}
				$i++;
		}
		return $data;
	}
	public  function find_registered_user($user_id="",$security_id="") {
		$user_id = $this->database->escape_value($user_id);
        $security_id = $this->database->escape_value($security_id);
        $sql  = "SELECT * FROM ".$this->table_name." ";
	    $sql .= "WHERE user_id = '{$user_id}' ";
	    $sql .= "AND security_id = '{$security_id}' ";
	    $sql .= "LIMIT 1";
        $result_array = $this->find_by_sql($sql);
		return !empty($result_array) ? array_shift($result_array) : false; 
	}
	public  function update_registered_user($user_id="",$security_id="") {
	  	$user_id = $this->database->escape_value($user_id);
	    $security_id = $this->database->escape_value($security_id);
	    $sql  = "UPDATE ".$this->table_name."  SET Active='1' ";
	    $sql .= "WHERE user_id = '{$user_id}' ";
	    $sql .= "AND security_id = '{$security_id}' ";
	    $sql .= "LIMIT 1";
	    $result_array = $this->database->query($sql);
	    return ($this->database->affected_rows() == 1) ? true : false;
	}
	//Database Methods
	public  function find_all() {
		return $this->find_by_sql("SELECT * FROM ".$this->table_name);
    }
  
	public  function find_by_user_id($user_id=0) {
	    $result_array = $this->find_by_sql("SELECT * FROM ".$this->table_name." WHERE user_id={$user_id} LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
	}
    public  function find_existed_username($username="") {
    	$result_array = $this->find_by_sql("SELECT * FROM ".$this->table_name." WHERE username='".$username."' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
    }
    public  function find_activated_username($username="") {
   	    $result_array = $this->find_by_sql("SELECT * FROM ".$this->table_name." WHERE username='".$username."' AND active='1' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
    }
   
   
    public  function find_existed_email($email="") {
    	$result_array = $this->find_by_sql("SELECT * FROM ".$this->table_name." WHERE email='".$email."' LIMIT 1");
		return !empty($result_array) ? array_shift($result_array) : false;
    }
    public  function find_by_sql($sql="") {
	    $result_set = $this->database->query($sql);
	    $object_array = array();
	    while ($row = $this->database->fetch_assoc($result_set)) {
	     	$object_array[] = $this->instantiate($row);
	    }
	    return $object_array;
    }

	public  function count_all() {
		$sql = "SELECT COUNT(*) FROM ".$this->table_name;
	    $result_set = $this->database->query($sql);
		$row = $this->database->fetch_array($result_set);
    	return array_shift($row);
	}

	private  function instantiate($record) {
		// Could check that $record exists and is an array
    	$object = new self;
		// Simple, long-form approach:
		// $object->user_id 				= $record['user_id'];
		// $object->username 	= $record['username'];
		// $object->password 	= $record['password'];
		// $object->first_name = $record['first_name'];
		// $object->last_name 	= $record['last_name'];
		
		// More dynamic, short-form approach:
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	private function has_attribute($attribute) {
		 // We don't care about the value, we just want to know if the key exists
		 // Will return true or false
	     return array_key_exists($attribute, $this->attributes());
	}

	protected function attributes() { 
		// return an array of attribute names and their values
		$attributes = array();
		foreach($this->db_fields as $field) {
		    if(property_exists($this, $field)) {
		      $attributes[$field] = $this->$field;
		    }
		}
		return $attributes;
	}
	
	protected function sanitized_attributes() {
		$clean_attributes = array();
		// sanitize the values before submitting
		// Note: does not alter the actual value of each attribute
		foreach($this->attributes() as $key => $value){
		    $clean_attributes[$key] = $this->database->escape_value($value);
		}
		return $clean_attributes;
	}
	
	public function save() {
		// A new record won't have an user_id yet.
		return isset($this->user_id) ? $this->update() : $this->create();
	}
	
	public function create() {
		// Don't forget your SQL syntax and good habits:
		// - INSERT INTO table (key, key) VALUES ('value', 'value')
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$sql = "INSERT INTO ".$this->table_name." (";
		$sql .= join(", ", array_keys($attributes));
		$sql .= ") VALUES ('";
		$sql .= join("', '", array_values($attributes));
		$sql .= "')";
		if($this->database->query($sql)) {
			$this->user_id = $this->database->insert_id();
			return true;
		} else {
			return false;
		}
	}
	 public function update_password($user_id,$password) {
			
		$sql = "UPDATE ".$this->table_name." SET password='". $this->database->escape_value($password);
		$sql.="' where user_id='". $this->database->escape_value($user_id)."' LIMIT 1";
	    $this->database->query($sql);
	    return ($this->database->affected_rows() == 1) ? true : false;
		
	}
	public function update() {
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".$this->table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE user_id=". $this->database->escape_value($this->user_id);
	    $this->database->query($sql);
	    return ($this->database->affected_rows() == 1) ? true : false;
	}

	public function delete() {
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
		$sql = "DELETE FROM ".$this->table_name;
		$sql .= " WHERE user_id=". $this->database->escape_value($this->user_id);
		$sql .= " LIMIT 1";
		$this->database->query($sql);
		return ($this->database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}

}

?>