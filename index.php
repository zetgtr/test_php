<?php
error_reporting(E_ERROR | E_PARSE | E_NOTICE);
require_once 'autoload.php';

$action =(isset($_GET['act'])) ? $_GET['act'] : 'index';


switch ($_GET['c'])
{
    case 'user':
        $controller = new User_C();
        break;
    default:
        $controller = new Page_C();
}


if($_GET['m']){
    switch ($_GET['m'])
    {
        default:
            $controller = new Page_M();
    }
}


$controller->Request($action);