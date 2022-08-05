<?php
class Page_M extends Base_M
{
    /**
     * Функция добовления компании
     */
    public function addCompany(){
        $name = trim( strip_tags ($_POST['name']));
        $inn =  trim( strip_tags ($_POST['inn']));
        $director = trim( strip_tags ($_POST['director']));
        $address = trim( strip_tags ($_POST['address']));
        $phone = trim( strip_tags ($_POST['phone']));
        $info = trim( strip_tags ($_POST['info']));
        $object = [
            'name' => $name,
            'inn' => $inn,
            'director' => $director,
            'address' => $address,
            'phone' => $phone,
            'info' => $info
        ];
        Pdo_M::Instance() -> insert('company', $object);
    }

    /**
     * Функция добовления коментария
     */
    public function addComment(){
        $comment = trim( strip_tags ($_POST['text']));
        $userId = $_POST["userId"];
        $companyId = $_POST["companyId"];
        $date = date("Y-m-d H:i:s");
        Pdo_M::Instance() -> insert('comment', ["comment"=>$comment,"id_company"=>$companyId,"id_user"=>$userId, "date"=>$date]);
        $template = $this->twig -> loadTemplate('commentList.twig');
        $query = "SELECT u.name AS userName, comp.name AS companyName, 
            DATE_FORMAT(comm.date,'%d.%m.%Y %H:%i:%s') AS date, comm.comment 
            FROM comment AS comm 
            JOIN users AS u ON comm.id_user=u.id
            JOIN company AS comp ON $companyId = comp.id
            WHERE comm.id_company = $companyId";
        $comments =  $this -> pdo -> select($query);
        $query = "SELECT COUNT(*) AS count FROM comment WHERE id_company = $companyId";
        $count = $this -> pdo -> select($query);
        $this->content = $template -> render(array("comments"=>$comments,"count"=>$count));
    }

    /**
     * Функция получения количества коментариев по компании
     */
    public function commentWatch(){
        $companyId = $_POST["companyId"];
        $query = "SELECT COUNT(*) AS count FROM comment WHERE id_company = $companyId";
        $count = $this -> pdo -> select($query);
        echo $count[0]["count"];
    }

    /**
     * Функция добовления коменариев при изменении БД
     */
    public function commentWatchAdd(){
        $companyId = $_POST["companyId"];
        $template = $this->twig -> loadTemplate('commentAdd.twig');
        $query = "SELECT u.name AS userName, comp.name AS companyName, 
            DATE_FORMAT(comm.date,'%d.%m.%Y %H:%i:%s') AS date, comm.comment 
            FROM comment AS comm 
            JOIN users AS u ON comm.id_user=u.id
            JOIN company AS comp ON $companyId = comp.id
            WHERE comm.id_company = $companyId
            ORDER BY comm.id DESC LIMIT 1";
        $comment =  $this -> pdo -> select($query);
        echo $template -> render(array("comment"=>$comment[0]));
    }
}