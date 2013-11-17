<?php
class Comment_Model{

	public $database;
	public function __construct()
    {
		$this->database = new Database_Library;
	}
	protected  $table_name="comments";
	protected  $db_fields=array('comment_id', 'comment_content','post_id','published_date','author');	   
	public $comment_id;
	public $post_id;
	public $published_date;
	public $author;
	public $comment_content;

	// "new" is a reserved word so we use "make" (or "build")
	public  function make($post_id, $author="Anonymous", $comment_content="") {
    	if(!empty($photo_comment_id) && !empty($author) && !empty($comment_contenty)) {
		$comment = new Comment();
	    $comment->post_id = (int)$post_id;
	    $comment->published_date = strftime("%Y-%m-%d %H:%M:%S", time());
	    $comment->author = $author;
	    $comment->comment_contenty = $comment_contenty;
	    return $comment;
		} else {
			return false;
		}
	}

	public  function find_comments_on($post_id=0) {
	    $i=0;
		$data=array();
		//not find all records,but find records for this particular page
		$sql = "SELECT comment_content FROM " . $this->table_name;
	    $sql .= " WHERE post_id=" .$this->database->escape_value($post_id);
	    $sql .= " ORDER BY published_date ASC";
		$result_set=$this->database->query($sql);
		while ($arr= $this->database->fetch_assoc($result_set)){
			foreach ($arr as $key => $value) {
				$data[$i][$key]=$value;
			}
			$i++;
		}
		return $data;
	}

	// Common Database Methods
	public  function find_all() {
		return $this->find_by_sql("SELECT * FROM ".$this->table_name);
    }
	  
	public  function find_by_comment_id($comment_id=0) {
	    $result_array = $this->find_by_sql("SELECT * FROM ".$this->table_name." WHERE comment_id={$comment_id} LIMIT 1");
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