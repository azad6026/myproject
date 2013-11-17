<?php
class Lookup_Posts_Model{
	/**
	* Holds instance of database connection
	*/
	public $database;
	public function __construct()
	{
	$this->database = new Database_Library;
	}
    protected  $table_name="lookup_posts";
	protected  $db_fields=array('post_id', 'post_title', 'post_content');
	public $post_id;
	public $post_title;
	public $post_content;
    public $errors=array();

    public  function find_search_term($term,$per_page,$per_page_offset) {
		$i=0;
		$data=array();
		$sql="SELECT DISTINCT post_id,post_title,post_content FROM lookup_posts WHERE MATCH (post_title, post_content) AGAINST ('".$this->database->escape_value($term)."' IN NATURAL language MODE WITH QUERY EXPANSION)";
		$sql.=" LIMIT ".$this->database->escape_value($per_page);
		$sql.=" OFFSET ".$this->database->escape_value($per_page_offset);
		$result_set=$this->database->query($sql);
		while ($arr= $this->database->fetch_assoc($result_set)){
			foreach ($arr as $key => $value) {
				$data[$i][$key]=$value;
			}
			$i++;
		}
		return $data;


    }
	public  function count_searched_posts($term) {
	    $sql="SELECT  COUNT(DISTINCT post_id) FROM ".$this->table_name." WHERE MATCH (post_title, post_content) AGAINST ('".$this->database->escape_value($term)."' IN NATURAL language MODE WITH QUERY EXPANSION)";
	    $result_set=$this->database->query($sql);
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

}