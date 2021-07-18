<?php
/**
 * This file is part of the Nigatedev PHP framework package
 * 
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 */
namespace Nigatedev\Maker\Controller;

use Nigatedev\Core\App;

/**
 * ControllerMaker
 * 
 * @package Nigatedev\Maker\Controller
 * 
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Controller {
  
  /**
   * @var string
   */
  private string $className;
  
  /**
   * @var array|null
   */
  private array $constructor = [];
  
  /**
   * @var array|null
   */
  private array $error = [];
  
  /**
   * @var array|null
   */
  private array $success = [];
  
  /**
   * @param string $className
   * 
   */
  public function makeController($className) {
   $this->isSafeClassName($className);
    if (isset($this->error["cname"])) {
       echo $this->error["cname"];
    } else {
      $this->make($this->constructor);
      if(isset($this->success["cname"])){
        echo $this->success["cname"];
      }
    }
    
  }
  
  /**
   * Check to see if $className is safe
   * 
   * @param string $className
   * 
   */
  public function isSafeClassName($className) {
    $className = trim($className);

    preg_match("/([^a-zA-Z0-9])/", $className, $match);
    if (count($match) > 0) {
    return  $this->error["cname"] = "The class name should not contains special chars.";
    }
    if (strlen($className) > 10 && substr($className, -10) === "Controller") {
     return $this->constructor["cname"] = $className;
    }
    return  $this->error["cname"] = "The class name should ended with [Controller] ";
  }
  /**
   * @return an existence template / Model of controller
   */
  public function getModel() {
    $model = file_get_contents(__DIR__ ."/ModelController.php");
    return $model;
  }
  
  /**
   * Generator of controller class
   */
  public function make(array $controller) {
    
    if (is_dir(dirname(dirname(__DIR__))."/Controller/")) {

      if (is_file(__DIR__ ."/ModelController.php")) {
        if(file_put_contents(dirname(dirname(__DIR__))."/Controller/".$controller["cname"].".php", str_ireplace("ModelController", $controller["cname"], $this->getModel())))
        {
          $this->success["cname"] =  "Your new Controller ".$controller["cname"]." was created successfully !";
        }
      }
    }
  }
}