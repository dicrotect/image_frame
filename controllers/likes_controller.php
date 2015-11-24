<?php

  class likesController {
      private $db;
      private $plural_resource;
      public function __construct($db, $plural_resource) {
           $this->db = $db;
           $this->plural_resource = $plural_resource;
      }

      public function create($picture_id,$member_id){
          $like = new likes($this->plural_resource);
          $sql = $like->create($picture_id,$member_id);
          $sql = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
          return $sql;

      }
      public function count($picture_id){
          $count = new likes($this->plural_resource);
          $sql = $count->count($picture_id);
          $sql = mysqli_query($this->db, $sql) or die(mysqli_error($this->db));
          return $sql;
      }

  }


?>
