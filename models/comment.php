<?php
    class comments {
        
        private $plural_resource = '';
        public function __construct($plural_resource) {
            $this->plural_resource = $plural_resource;
        }

        function create($picture_id,$comment,$member_id) {
            $sql = sprintf(
                'INSERT INTO comments SET picture_id=%d, comment="%s", created=NOW(), member_id=%d',
                $picture_id,
                $comment,
                $member_id
            );
            return $sql;
        }

        function index($picture_id) {
            $sql = sprintf(
                'SELECT * FROM comments WHERE picture_id=%d',
                $picture_id
            );
            return $sql;
        }
    }


?>
