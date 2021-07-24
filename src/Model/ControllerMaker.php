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
  * @var bool
  */
  private $injector = false;

  /**
  * @var string
  */
  private $dirName;

  public function __construct() {
    $this->dirName = dirname(dirname(dirname(dirname(dirname(__DIR__)))));
  }

  /**
  * @param string $className
  */
  public function makeController($className) {
    if ($this->isSafeClassName($className)) {
      $this->make($this->constructor);
      echo $this->success["cname"];
    } else {
      echo $this->error["cname"];
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

    preg_match('/^[0-9]/', $className, $match);
    if ($match) {
      $this->error["cname"] = "The class name shouldn't contains special chars, first letter can not be a number !";
      return false;
    }
    if (strlen($className) > 10 && substr($className, -10) === "Controller") {
      $this->constructor["cname"] = $className;
      return true;
    }
    $this->error["cname"] = "The class name must end with [Controller]. ";
    return false;
  }

  /**
  * @return an existence template / Model of controller
  */
  public function getModel($model) {
    $model = file_get_contents(__DIR__ .$model);
    return $model;
  }

  /**
  * Final controller class generator
  */
  public function make(array $controller) {
    $cName = $controller["cname"];
    $cDir = $this->dirName."/src/Controller/";
    $loaderFile = $this->dirName."/config/loader.php";

    if (is_file("{$cDir}{$cName}.php")) {
      die("Error: Can't create an existence controller class ".$cName);
    }
    if (is_dir($cDir) && is_file(__DIR__ ."/ControllerModel.php")) {
      file_put_contents("{$cDir}{$cName}.php", str_replace(["ControllerModel", "index"], [$cName, $this->lowerAndReplace("Controller", "", $cName)], $this->getModel("/ControllerModel.php")));
      fopen($this->dirName."/views/".$this->lowerAndReplace("Controller", "", $cName.".php"), "w+");
      file_put_contents($this->dirName."/views/".$this->lowerAndReplace("Controller", "", $cName.".php"), $this->getModel("/TemplateModel.php"));
      $loader = str_replace("];", "  '/". $this->lowerAndReplace("Controller", "", $cName)."' => [\\App\\Controller\\". $cName."::class, '".$this->lowerAndReplace("Controller", "", $cName)."'],\n];", file_get_contents($loaderFile));
      file_put_contents($loaderFile, $loader);
      $this->success["cname"] = $cName." controller was created successfully !";
    }
  }

  public function lowerAndReplace($find, $replace, $in) {
    return strtolower(str_replace($find, $replace, $in));
  }
}