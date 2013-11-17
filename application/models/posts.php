<?php
/**
* The Posts Model does the back-end heavy lifting for the Posts Controller
*/
class Posts_Model
{

/**
* Holds instance of database connection
*/
public $database;
public $categories_model;
public function __construct()
{
$this->database = new Database_Library;
$this->categories_model=new Category_Model;
}


protected  $table_name="posts";
protected  $db_fields=array('post_id', 'post_title', 'post_content', 'published_date', 'username','category_id','photo_path');
public $post_id;
public $post_title;
public $post_content;
public $published_date;
public $username;
public $category_id;
public $photo_path;
public $errors=array();

public function save() {
// A new record won't have a post_id yet.
if(isset($this->post_id)) {
// Really just to update the caption
$this->update();
} else {
// Make sure there are no errors

// Can't save if there are pre-existing errors
if(!empty($this->errors)) { return false; }

// Make sure the caption is not too long for the DB


// Can't save without filename and temp location
if(empty($this->post_title) || empty($this->post_content)) {
$this->errors[] = "you must fill all fields.";
return false;
}

}
}


// public function comments() {
//  return Comment::find_comments_on($this->post_id);
// }



// Common Database Methods
public  function find_all() {
return $this->find_by_sql("SELECT * FROM ". $this->table_name);
}

public function get_post($post_title)
{
$post_title = $this->database->escape_value($post_title);
$sql=("SELECT * FROM posts WHERE post_title='$post_title' LIMIT 1");
//execute query
$arr=$this->database->query($sql);
$post = $this->database->fetch_array($arr);
return $post;
}
public function get_last_posts()
{
$i=0;
$data=array();
$sql=("SELECT * FROM ".$this->table_name." order by published_date desc LIMIT 4");
//execute query
$result_set=$this->database->query($sql);
while ($arr= $this->database->fetch_assoc($result_set)){
foreach ($arr as $key => $value) {
$data[$i][$key]=$value;
}
$i++;
}
return $data;
}

public  function count_by_category_id($category_id=1) {  
$sql = "SELECT COUNT(*) FROM ".$this->table_name." WHERE category_id=".$category_id;
$result_set = $this->database->query($sql);
$row = $this->database->fetch_array($result_set);
return array_shift($row);
}
public  function get_by_category_id($post_id=1) {  
$sql = "SELECT category_id FROM ".$this->table_name." WHERE post_id=".$post_id;
$result_set = $this->database->query($sql);
$row = $this->database->fetch_array($result_set);
return array_shift($row);
}
public  function find_by_post_id($post_id=0) {
$i=0;
$data=array();
//not find all records,but find records for this particular page
$sql="SELECT * FROM ".$this->table_name." WHERE post_id=".$this->database->escape_value($post_id)." LIMIT 1";
$result_set=$this->database->query($sql);
while ($arr= $this->database->fetch_assoc($result_set)){
foreach ($arr as $key => $value) {
$data[$i][$key]=$value;
}
$i++;
}
return $data;


}
public  function related_posts_by_category_id($category_id="",$post_id="") {
$i=0;
$data=array();
//not find all records,but find records for this particular page
$sql="SELECT post_id,post_title,published_date FROM ".$this->table_name." WHERE category_id=".$this->database->escape_value($category_id);
$sql.=" GROUP BY post_title HAVING $post_id =".$this->database->escape_value($post_id);
//
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
return $result_set;
}

public function get_categorized_posts_per_page($per_page,$per_page_offset,$category_name){
$i=0;
$data=array();
//not find all records,but find records for this particular page
$sql="SELECT posts.post_id,posts.post_title,posts.post_content,posts.published_date,";
$sql.="posts.photo_path,posts.category_id,posts.username,";
$sql.="COUNT(comments.comment_id) AS comments_count,categories.category_name";
$sql.=" FROM posts LEFT JOIN comments ON posts.post_id=comments.post_id";
$sql.=" INNER JOIN categories ON posts.category_id=categories.category_id";
$sql.=" WHERE posts.category_id=".$this->categories_model->find_category_id_by_name($category_name)." GROUP BY posts.post_id,posts.post_title,posts.post_content,posts.published_date,";

$sql.="posts.photo_path,posts.category_id,posts.username";
$sql.=" ORDER BY published_date DESC";
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
public  function count_categorized_posts($category_name) {
$sql = "SELECT COUNT(*) FROM posts WHERE category_id='".$this->categories_model->find_category_id_by_name($category_name)."' ";
  $result_set = $this->database->query($sql);
$row = $this->database->fetch_array($result_set);
  return array_shift($row);
}
public function get_posts_per_page($per_page,$per_page_offset){
$i=0;
$data=array();
//not find all records,but find records for this particular post per page
$sql="SELECT posts.post_id,posts.post_title,posts.post_content,posts.published_date,";
$sql.="posts.photo_path,posts.category_id,posts.username,";
$sql.="COUNT(comments.comment_id) AS comments_count,categories.category_name";
$sql.=" FROM posts LEFT JOIN comments ON posts.post_id=comments.post_id";
$sql.=" INNER JOIN categories ON posts.category_id=categories.category_id";
$sql.=" GROUP BY posts.post_id,posts.post_title,posts.post_content,posts.published_date,";
$sql.="posts.photo_path,posts.category_id,posts.username";
$sql.=" ORDER BY published_date DESC";
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
//to loop comments here,because we use count,the comments must be group by comment_id (which is
//to be count)this way all comments will be shown not only the last one.
public function get_post_page($post_id){
$i=0;
$data=array();
//not find all records,but find records for this particular post
$sql="SELECT posts.post_id,posts.post_title,posts.post_content,posts.published_date,";
$sql.="posts.photo_path,posts.category_id,posts.username,";
$sql.="comments.comment_id,comments.author,comments.comment_content,comments.published_date,categories.category_name,categories.category_id ";
$sql.=" FROM posts LEFT JOIN comments ON posts.post_id=comments.post_id";
$sql.=" INNER JOIN categories ON posts.category_id=categories.category_id";
$sql.=" WHERE posts.post_id=".$this->database->escape_value($post_id)."   ORDER BY comments.published_date DESC";
$result_set=$this->database->query($sql);
while ($arr= $this->database->fetch_assoc($result_set)){
if($i<>$arr['post_id']){
$i=$arr['post_id'];
$data[$i]=array('post_id'=>$arr['post_id'],
'post_title'=>$arr['post_title'],'post_content'=>$arr['post_content'],'published_date'=>$arr['published_date'],
'photo_path'=>$arr['photo_path'],'category_name'=>$arr['category_name'],
'username'=>$arr['username'],'comments_count'=>array(),'comment'=>array());
}
$data[$i]['comments_count'][]=array('comment_id'=>$arr['comment_id']);

$data[$i]['comment'][]=array('author'=>$arr['author'],
'published_date'=>$arr['published_date'],'comment_content'=>$arr['comment_content']);
}
return $data;
}
public function get_posts(){
  $i=0;
$data=array();
$sql="SELECT * from posts ORDER BY published_date DESC";
$result_set=$this->database->query($sql);
while ($arr= $this->database->fetch_assoc($result_set)){
foreach ($arr as $key => $value) {
  $data[$i][$key]=$value;
  }
  $i++;
}
return $data;
}


public function get_edit_post_page($post_id){
$i=0;
$data=array();
$cat_arr=array();
//not find all records,but find records for this particular post
$sql="SELECT posts.post_id,posts.post_title,posts.post_content,posts.published_date,";
$sql.="posts.photo_path,posts.category_id,posts.username,";
$sql.="categories.category_name,categories.category_id";
$sql.=" FROM posts INNER JOIN categories ON posts.category_id=categories.category_id";
$sql.=" WHERE posts.post_id=".$this->database->escape_value($post_id);
$result_set=$this->database->query($sql);
while ($arr= $this->database->fetch_assoc($result_set)){
if($i<>$arr['post_id']){
$i=$arr['post_id'];
$data[$i]=array('post_id'=>$arr['post_id'],
'post_title'=>$arr['post_title'],'post_content'=>$arr['post_content'],'published_date'=>$arr['published_date'],
'photo_path'=>$arr['photo_path'],'category_name'=>$arr['category_name'],
'username'=>$arr['username']
          );
}
// $cat_arr=$this->categories_model->find_all();      
// $data[$i]['category_array'][]=array('category_id'=>$cat_arr['category_id'],
//  'category_name'=>$cat_arr['category_name']);
}
return $data;
}

public function get_post_titles(){
$i=0;
$data=array();
//not find all records,but find records for this particular page
$sql="SELECT * FROM ".$this->table_name."  ORDER BY published_date DESC";
$result_set=$this->database->query($sql);
while ($arr= $this->database->fetch_assoc($result_set)){
foreach ($arr as $key => $value) {
$data[$i][$key]=$value;
}
$i++;
}
return $data;
}


public  function count_all() {
//global $database;
$sql = "SELECT COUNT(*) FROM posts";
$result_set = $this->database->query($sql);
$row = $this->database->fetch_array($result_set);
return array_shift($row);
}

private static function instantiate($record) {
// Could check that $record exists and is an array
$object = new self;
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
//$database=new Database_Library;
$clean_attributes = array();
// sanitize the values before submitting
// Note: does not alter the actual value of each attribute
foreach($this->attributes() as $key => $value){
$clean_attributes[$key] = $this->database->escape_value($value);
}
return $clean_attributes;
}

// replaced with a custom save()
// public function save() {
//   // A new record won't have an post_id yet.
//   return isset($this->post_id) ? $this->update() : $this->create();
// }

public function create() {
//$database=new Database_Library;
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
$this->post_id = $this->database->insert_id();
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
$sql .= " WHERE post_id=". $this->database->escape_value($this->post_id);
$this->database->query($sql);
return ($this->database->affected_rows() == 1) ? true : false;
}

public function delete() {
// Don't forget your SQL syntax and good habits:
// - DELETE FROM table WHERE condition LIMIT 1
// - escape all values to prevent SQL injection
// - use LIMIT 1
$sql = "DELETE FROM ".$this->table_name;
$sql .= " WHERE post_id=". $this->database->escape_value($this->post_id);
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