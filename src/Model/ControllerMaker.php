<?php
/**
 * This file is part of the Nigatedev PHP framework package
 * 
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 */
namespace Nigatedev\Maker\Model;

/**
 * ControllerMaker
 * 
 * @package Nigatedev\Maker\Controller
 * 
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class ControllerMaker {
  
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
    return  $this->error["cname"] = "The class name shouldn't contains special chars.";
    }
    if (strlen($className) > 10 && substr($className, -10) === "Controller") {
     return $this->constructor["cname"] = $className;
    }
    return  $this->error["cname"] = "The class name must end with [Controller]. ";
  }
  /**
   * @return an existence template / Model of controller
   */
  public function getModel() {
    $model = file_get_contents(__DIR__ ."/ControllerModel.php");
    return $model;
  }
  
  /**
   * Final controller class generator
   */
  public function make(array $controller) {
    $dirName = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
    if (is_file($dirName."/src/Controller/".$controller["cname"].".php")) {
      die("Error: Can't create an existence controller class ".$controller["cname"]);
    }
  if (is_dir($dirName."/src/Controller/")) {
      if (is_file(__DIR__ ."/ControllerModel.php")) {
        if(file_put_contents($dirName."/src/Controller/".$controller["cname"].".php", str_ireplace("ControllerModel", $controller["cname"], $this->getModel())))
        {
          $this->success["cname"] = $controller["cname"]." controller was created successfully !";
        }
      }
    }
  }
}