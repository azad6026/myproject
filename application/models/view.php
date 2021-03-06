<?php
/**
* Handles the view functionality of our MVC framework
*/
class View_Model
{
  /**
  * Holds variables assigned to template
  */
  public $data = array();
  /**
  * Holds render status of view.
  */
  private $render = FALSE;
  public $file;
  /**
  * Accept a template to load
  */
  public function __construct($template){
    //compose file name
    $file = SERVER_ROOT .DS.'application'.DS. 'views'.DS . strtolower($template) . '.php';
    if (file_exists($file)){
      /**
      * trigger render to include file when this model is destroyed
      * if we render it now, we wouldn't be able to assign variables
      * to the view!
      */
      $this->render = $file;
    }
  }
  /**
  * Receives assignments from controller and stores in local data array
  *
  * @param $variable
  * @param $value
  */
    public function __set_data($value) {
          //$this->data=$value;
    }
    public function __set($name, $value) {
          $this->data[$name] = $value;
    }
    public function __get($name) {
          return $this->data[$name];
    }
  /**
  * Render the output directly to the page, or optionally, return the
  * generated output to caller.
  *
  * @param $direct_output Set to any non-TRUE value to have the
  * output returned rather than displayed directly.
  */
  public function render($direct_output = TRUE)
  {
    // Turn output buffering on, capturing all output
    if ($direct_output !== TRUE)
    {
      ob_start();
    }
    // Parse data variables into local variables

    $data=$this->data;
          
    // Get template
    include($this->render);
    // Get the contents of the buffer and return it
    if ($direct_output !== TRUE)
    {
      return ob_get_clean();
    }
  }
  public function __destruct()
  {
  }
}