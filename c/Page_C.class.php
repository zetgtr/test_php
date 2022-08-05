<?php

class Page_C extends Base_C
{
    /**
     * Страница компании
     */
    public function index(){
        if($_SESSION['user_id']){
            $this->title="Компании";
            $template = $this->twig -> loadTemplate('company.twig');
            $query = "SELECT * FROM company";
            $companys =  $this -> pdo -> select($query);
            if($this->isPost()) {
                $this->message = $this->page -> addCompany();
                $this->content = $template -> render(array('message' => $this->message));
            } else {
                $this->content = $template -> render(array("companys"=>$companys));
            }
        }else{
            header("Location: index.php?act=login&c=user");
        }
    }

    /**
     * Страница коментариев
     */
    public function comment(){
        if($_SESSION['user_id']){
            $this->title="Коментарии";
            $company = $_GET["id"];
            $template = $this->twig -> loadTemplate('comment.twig');
            $query = "SELECT u.name AS userName, comm.comment, 
                DATE_FORMAT(comm.date,'%d.%m.%Y %H:%i:%s') AS date
                FROM comment AS comm 
                JOIN users AS u ON comm.id_user=u.id
                JOIN company AS comp ON $company = comp.id
                WHERE comm.id_company = $company";
            $comments =  $this -> pdo -> select($query);
            $query = "SELECT COUNT(*) AS count FROM comment WHERE id_company = $company";
            $count = $this -> pdo -> select($query);
            $query = "SELECT comp.name FROM comment 
                JOIN company AS comp ON $company = comp.id  LIMIT 1";
            $companyName = $this -> pdo -> select($query);
            $object = [
                "comments"=>$comments,
                "companyName"=>$companyName[0]["name"], 
                "company"=>$company,
                "user"=>$_SESSION['user_id'],
                "count"=>$count[0]["count"]
            ];
            $this->content = $template -> render($object);
        }else{
            header("Location: index.php?act=login&c=user");
        }
    }
}