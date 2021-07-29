#!/usr/bin/env php
<?php
/*
 * This file is part of Nigatedev PHP framework package.
 *
 * (c) Abass Ben Cheik <abass@todaysdev.com>
 *
 */
namespace Nigatedev\Maker;

use Nigatedev\Maker\Model\ControllerMaker;

/**
 * Make class
 *
 * @author Abass Ben Cheik <abass@todaysdev.com>
 */
class Make
{
  /**
   * @var ControllerMaker $controllerMaker
   */
    public ControllerMaker $controllerMaker;
   
  /**
   * @var string $arg
   */
    public array $arg;
   
    public function __construct()
    {
        $this->controllerMaker = new ControllerMaker();
    }
   
   /**
    * @return Execute command or thrown command Unkwon exception
    */
    public function make(array $arg)
    {
        $this->arg = $arg;
        if (is_array($this->arg) && isset($this->arg[1])) {
            switch ($this->arg[1]) {
                case 'make:controller':
                    $this->isController($this->arg);
                    break;
                case "-h":
                    echo "Sorry no help has been written yet";
                    break;
                case "--help":
                    echo "Sorry no help has been written yet";
                    break;
                default:
                     echo "Unkwon command";
                    break;
            }
        } else {
            echo "Type --help or -h for basic usage";
        }
    }
   
    public function isController(array $controller)
    {
        if (isset($controller[2]) && !isset($controller[3])) {
             $warning = readline("Generate [".$controller[2]. "] Controller ? (Y [yes] / N [No]) \n> ");
            if (strtoupper($warning) === "Y") {
                $this->controllerMaker->makeController($controller[2]);
            } else {
                echo "Canceled !";
            }
        } else {
            $controller[2] = readline("Controller class name E.g: HomeController \n>  ");
            $this->controllerMaker->makeController($controller[2]);
        }
    }
}
