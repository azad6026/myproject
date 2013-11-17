<?php
class Category_Model{
	
	public $database;
	public function __construct()
	{
	$this->database = new Database_Library;
	}
	protected  $table_name="categories";
	protected  $db_fields=array('category_id','category_name');
	public $category_id;
	public $category_name;
	public $errors=array();

	public function save() {
	// A new record won't have a category_id yet.
	if(isset($this->category_id)) {
		// Really just to update the caption
		$this->update();
	} else {
		// Make sure there are no errors
		
		// Can't save if there are pre-existing errors
	if(!empty($this->errors)) { return false; }

	public  function find_by_category_id($category_id=0) {
		$result_array = $this->find_by_sql("SELECT * FROM ".$this->$table_name." WHERE category_id=".$this->database->escape_value($category_id)." LIMIT 1");
		return !empty($result_array) ? intval($result_array['category_id']) : false;
	}
	public  function find_category_id_by_name($category_name) {	
		$i=0;
		$data=array();
		$sql="SELECT category_id FROM categories WHERE category_name='".$this->database->escape_value($category_name)."' ";
		$result_set=$this->database->query($sql);
		$arr= $this->database->fetch_assoc($result_set);
		return !empty($arr) ? (int) array_shift($arr) : false;
	  	  
	}

	public function find_all(){
	  	$i=0;
	    $data=array();
	  	$sql="SELECT * FROM categories";
		$result_set=$this->database->query($sql);
		while ($arr= $this->database->fetch_assoc($result_set)){
			foreach ($arr as $key => $value) {
				$data[$i][$key]=$value;
			}
			$i++;
	    }
	    return $data;
	}
	public function find_category_name_by_id(){
		$i=0;
	    $data=array();
	  	$sql="SELECT categories.category_name,COUNT(posts.post_id) AS posts_count FROM categories";
	  	$sql.=" LEFT JOIN posts ON categories.category_id=posts.category_id";
	  	//$sql.=" WHERE categories.category_id=posts.category_id";
	  	$sql.=" GROUP BY category_name";
		$result_set=$this->database->query($sql);
		while ($arr= $this->database->fetch_assoc($result_set)){
			foreach ($arr as $key => $value) {
				$data[$i][$key]=$value;
			}
			$i++;
		}
		return $data;
    }
	public function show_category_name(){
	  	$i=0;
	    $data=array();
	  	$sql="SELECT categories.category_name FROM categories";
		$result_set=$this->database->query($sql);
		while ($arr= $this->database->fetch_assoc($result_set)){
			foreach ($arr as $key => $value) {
				$data[$i][$key]=$value;
				}
			$i++;
		}
		return $data;
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