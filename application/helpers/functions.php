<?php
class Functions_Helper{

    function valid_email($email) { 
      ///[^a-zA-Z0-9-_@.!#$%&'*\/+=?^`{\|}~]/
      if(preg_match("/^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]+$/", $email)) { //
          return false;   
      } 
      else { 
          return true; 
      } 
    } 
    function check_length($variable,$min_size,$max_size){
      if(strlen($variable)< $min_size){
          return false;
      }
      if(strlen($variable)> $max_size){
          echo 'this must not be greater than '.$max_size. 'characters';
          return false;
      }
    }
    function strip_zeros_from_date( $marked_string="" ) {
        // first remove the marked zeros
        $no_zeros = str_replace('*0', '', $marked_string);
        // then remove any remaining marks
        $cleaned_string = str_replace('*', '', $no_zeros);
        return $cleaned_string;
    }

    function redirect_to( $location = NULL ) {
        if ($location != NULL) {
        header("Location: {$location}");
        exit;
      }
    }

    function output_message($message="") {
        if (!empty($message)) { 
            return "<p class=\"message\">{$message}</p>";
        } else {
            return "";
        }
    }

    function __autoload($class_name) {
      	$class_name = strtolower($class_name);
        $path = LIB_PATH.DS."{$class_name}.php";
        if(file_exists($path)) {
            require_once($path);
        } else {
      		  die("The file {$class_name}.php could not be found.");
      	}
    }
    function include_initialize_for_controllers($ini="") {
        include(LIB_PATH.DS.'config'.DS.$ini);
    }
    function include_views_template($template="") {
        include(LIB_PATH.DS.'views'.DS.$template);
    }
    function include_layout_template($template="") {
    	 include(LIB_PATH.DS.'layouts'.DS.'templates'.DS.$template);
    }
    function include_controllers_template($template="") {
        include(LIB_PATH.DS.'controllers'.DS.$template);
    }
    function log_action($action, $message="") {
      	$logfile = LIB_PATH.DS.'views'.DS.'logs'.'log.txt';
      	$new = file_exists($logfile) ? false : true;
        if($handle = fopen($logfile, 'a')) { // append
            $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
        		$content = "{$timestamp} | {$action}: {$message}\n";
            fwrite($handle, $content);
            fclose($handle);
            if($new) { chmod($logfile, 0755); }
        } else {
            echo "Could not open log file for writing.";
        }
    }

    function datetime_to_text($datetime="") {
        $unixdatetime = strtotime($datetime);
        return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
    }
}