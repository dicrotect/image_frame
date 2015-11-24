<?php
    class genre {
        
        private $plural_resource = '';
        public function __construct($plural_resource) {
            $this->plural_resource = $plural_resource;
        }

        public function show($id) {
            $sql = sprintf('SELECT * FROM genres WHERE id=%d',
            $id
            );
            return $sql;
        }
    }
?>
 
