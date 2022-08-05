<?php
class Base_M extends Controller
{
    protected $loader;
    protected $twig;
    protected $content;
    protected $message;
    protected $pdo;

    protected function before()
    {
        $this->pdo = new Pdo_M();
        $this->loader = new Twig_Loader_Filesystem('v');
        $this->twig = new Twig_Environment($this->loader);
    }
    public function render()
    {
        echo $this->content;
    }
}