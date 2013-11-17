<?php
function __autoload($class_name)
{	
		/// Parse out filename where class should be located
		// This supports names like 'Name_Model' as well as 'Name_One_Controller'
		list($suffix, $filename) = preg_split('/_/', strrev($class_name), 2);
		$filename = strrev($filename);
		$suffix = strrev($suffix);
		//select the folder where class should be located based on suffix
		switch (strtolower($suffix)){
			case 'model':
			$folder = '/models/';
			break;
			case 'library':
			$folder = '/library/';
			break;
			case 'helper':
			$folder = '/helpers/';
			break;
			case 'mailer':
			$folder = '/mailer/';
			break;
		}
		//compose file name
		$file = SERVER_ROOT .DS.'application'.DS. $folder .DS. strtolower($filename) . '.php';
		//fetch file
		if (file_exists($file))
		{
			//get file
			include_once($file);
		}else{
			//file does not exist!
			die("File '$filename' containing class '$class_name' not found.");
		}
}
$query = $_SERVER['REQUEST_URI'];
$path = pathinfo( $query );
$request= $path['dirname'];
$parsed=array();
$parsed=explode('/',$query);
//$page_name=array_shift($parsed);  //Shift an element off the beginning of array:here page_name 

$reverse_parsed=array_reverse($parsed);
$poped=array_pop($reverse_parsed);
$poped_page=array_pop($reverse_parsed);
$page_name=$poped_page;
if( $poped_page==''){
	$page_name='posts';//default controller
}

$args=array_reverse($reverse_parsed);
//print_r($reverse_parsed);
//the rest of the array are get statements, parse them out.
$get_vars = array(); //to get variables
foreach ($args as $key=>$value)
{

	//split GET vars along '=' symbol to separate variable, values
	//list($variable , $value) = preg_split('/=/' , $argument);
	//list($variable,$value ) =  $key;$argument;
	$get_vars[$key] = urldecode($value);//Decodes any %## encoding in the given string. Plus symbols ('+') are decoded to a space character.
}


$splitted_page_name=preg_split('/_/', ($page_name), 2);
$page_prefix=array_shift($splitted_page_name);
if( $page_prefix=='admin'){
	//compute the path to the file
	$target = SERVER_ROOT .DS.'application'.DS.'admin'.DS.'controllers'.DS. $page_name . '.php';
}else{
	//compute the path to the file
    $target = SERVER_ROOT .DS.'application'.DS.'controllers'.DS. $page_name . '.php';
}

//get target
if (file_exists($target)){
	include_once($target);
	//modify page_name to fit naming convention
	if( $page_prefix=='admin'){
		$class = ucfirst($page_name) . '_Controller_Admin';
	}else{
		$class = ucfirst($page_name) . '_Controller';
	}
	//instantiate the appropriate class
	if (class_exists($class))
	{
		$controller = new $class;
	}
	else
	{
		//did we name our class correctly?
		die('class does not exist!');
	}
}else{
	//can't find the file in 'controllers'!
	die('page_name does not exist!');
}
//once we have the controller instantiated, execute the default function
//pass any GET varaibles to the main method
$controller->main($get_vars);