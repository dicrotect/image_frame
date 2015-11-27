<?php
    class genre {
        
        private $plural_resource = '';
        public function __construct($plural_resource) {
            $this->plural_resource = $plural_resource;
        }
        //ジャンルidを指定してジャンルを呼び出す
        public function show($id) {
            $sql = sprintf('SELECT * FROM genres WHERE id=%d',
            $id
            );
            return $sql;
        }
    }
?>
 
