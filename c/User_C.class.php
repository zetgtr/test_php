<?php

class User_C extends Base_C
{
    /**
     * Страница регистрации
     */
    public function reg() {		
        $this->title .= ' | Регистрация'; 

        $template = $this->twig -> loadTemplate('userReg.twig');
            
        if($this->isPost()) {
            $this->message = $this->user -> reg();
            $this->content = $template -> render(array('message' => $this->message));
        } else {
            $this->content = $template -> render(array());
        }
    }

    /**
     * Страница входа на сайт 
     */
    public function login() {
        $this->title .= ' | Вход';

        $template = $this->twig -> loadTemplate('userLogin.twig');
        
        if($this->isPost()) {
            $this->message = $this->user -> login();
            $this->content = $template -> render(array('message' => $this->message));
        } else {
            $this->content = $template -> render(array());
        }
    }
    /**
     * функция выхода с сайта
     */
    public function logout() {
        $this->user -> logout();
        header("location: index.php"); 
    }	
}