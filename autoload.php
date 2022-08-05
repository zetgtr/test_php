<?php

    require_once 'config/config.php';
    include 'lib/Twig/Autoloader.php';

    Twig_Autoloader::register();

    spl_autoload_register(function($name){
        $dirs = ["c","m"];
        $file = $name.".class.php";
        foreach($dirs as $dir){
            $path = $dir."/".$file;
            if(is_file($path)){
                include_once($path);
                return;
            }
        }
        die('Клас не найден');
    });