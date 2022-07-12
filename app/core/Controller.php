<?php
    class Controller {
        
        public function view($dir, $data = [])
        {
            require_once '../app/views/templates/header.php';
            require_once '../app/views/' . $dir . '.php';
            require_once '../app/views/templates/footer.php';
        }

        public function model($model)
        {
            require_once '../app/models/' . $model . '.php';
            return new $model;
        }
    }
?>