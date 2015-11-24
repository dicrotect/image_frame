<?php

    class commentsController {
        private $db;
        private $plural_resource;
        public function __construct($db, $plural_resource) {
             $this->db = $db;
             $this->plural_resource = $plural_resource;
        }
        function create($picture_id,$comment,$member_id) {
            $comments = new comments($this->db, $this->plural_resource);
            $sql = $comemnts->create($picture_id,$comment,$member_id);
            $sql = mysqli_query($this->db,$sql) or die (mysqli_error($this->db));
            return $sql;
        }
        function index($picture_id) {
            $comments = new comments($this->db, $this->plural_resource);
            $sql = $comemnts->index($picture_id);
            $sql = mysqli_query($this->db,$sql) or die (mysqli_error($this->db));
            return $sql;
        }
        
    }

?>
