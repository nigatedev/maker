<?php
namespace App\Controller;

use Nigatedev\Core\Controller\Controller;

/**
 * undocumented class
 *
 * @package default
 * @subpackage default
 * @author `g:snips_author`
 */
class ControllerModel extends Controller
{
   /**
    * @return mixed
    */
    public function index()
    {
        return $this->render("index", [
        "cName" => "ControllerModel",
        "cPath" => "src/Controller/ControllerModel.php"
        ]);
    }
}
