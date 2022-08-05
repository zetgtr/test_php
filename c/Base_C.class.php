<?php

class Base_C extends Controller
{
    /**
     * @var Twig_Environment $twig Модель шаблонизатора Twig
     * @var PageM $page Модель страницы
     * @var UserM $user Модель пользователя
     * @var CartM $cart Модель корзины
     * @var string $title Заголовок страницы
     * @var string $content Содержание страницы
     * @var string $message вывод сообщения на страницу
     * @var array $user Данные пользователя
     * @var int $cartCount количество товаров в корзине
     */
    protected $title;
    protected $loader;
    protected $twig;
    protected $content;
    protected $message;

    public function before(){
        $this->title = 'Главная';
        $this->loader = new Twig_Loader_Filesystem('v');
        $this->twig = new Twig_Environment($this->loader);
        $this->content = '';
        $this->pdo = new Pdo_M();
        $this->user = new User_M();
        $this->page = new Page_M();
    }

    public function render(){
        if (isset($_SESSION['user_id'])) {
            $user = $this->user -> account($_SESSION['user_id']);
        } else {
            $user['name'] = false;
        }

        $template = $this->twig -> loadTemplate('main.twig');
        echo $template -> render(array(
            'title' => $this->title,
            'content' => $this->content,
            'user' => $user['name']
        ));
    }
}