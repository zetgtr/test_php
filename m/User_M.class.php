<?php
/**
 * Модель пользователя
 */
    class User_M { 
        
        /**
         * Функция создает пароль
         * @var string $login логин пользователя
         * @var string $password пароль пользователя
         * @return string возвращает зашифрованый пароль
         */
        public function setPass($login, $password) {
            return strrev(md5($login)) . md5($password);
        }

        /**
         * Функция выхода из личного кабинета
         */
        public function logout() {
            unset($_SESSION["user_id"]); 
        }    
        
        /**
         * Функция получения данных о пользователе
         * @return array
         */
        public function account() {
            $id = $_SESSION['user_id'];
            $res = Pdo_M::Instance() -> select("SELECT * FROM users WHERE id=" . $id);
            foreach ($res as $key => $val) {
                return $val;
            }
        }
        /**
         * Функция регистрации нового пользователя
         * @return string сообщение на странице регистрации
         */
        public function reg() {
            $name = trim( strip_tags ($_POST['name']));
            $login =  trim( strip_tags ($_POST['login']));
            $password = trim( strip_tags ($_POST['password']));

            $query = "SELECT * FROM users WHERE login = '" . $login . "'";
            $res = Pdo_M::Instance() -> select($query);

            if(!$res){
                $password = $this -> setPass($login, $password);
                $object = [
                    'name' => $name,
                    'login' => $login,
                    'password' => $password
                ];
                $res = Pdo_M::Instance() -> insert('users', $object);

                if (is_numeric($res)) {
                    return 'Регистрация прошла успешно. Войдите в <a href="index.php?act=login&c=user">личный кабинет</a>';
                } else {
                    return "Регистрация прервалась ошибкой!";
                }
            } else {
                return "Такой логин уже зарегистрирован!";
            }
        }
        
        /**
         * Функция авторизации пользователя
         * @return string сообщение на странице авторизации
         */
        public function login() {
            $login = trim( strip_tags ($_POST['login']));
            $password = trim( strip_tags ($_POST['password']));
            
            $query = "SELECT * FROM users WHERE login='" . $login . "'";
            $res = Pdo_M::Instance() -> select($query);
            if($res){
                foreach ($res as $key => $val) {
                    if ($val['password'] == $this -> setPass($login, $password)) {
                        $_SESSION['user_id'] = $val['id'];
                        header('Location: index.php');
                    } else {
                        return 'Пароль не верный!';
                    }
                } 
            } else {
                return 'Пользователь с таким логином не зарегистрирован!';
            }             
        }
    }