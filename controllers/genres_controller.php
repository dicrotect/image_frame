<?php
    class genresController {
        private $db;
        private $plural_resource;
        public function __construct($db, $plural_resource) {
             $this->db = $db;
             $this->plural_resource = $plural_resource;
        }
        public function show($id) {
            $genre = new genre($this->db, $this->plural_resource);
            $sql = $genre->show($id);
            $sql = mysqli_query($this->db,$sql) or die (mysqli_error($this->db));
            return $sql;
        }
    }
?>
