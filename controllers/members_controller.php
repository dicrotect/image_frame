<?php

class membersController {
      private $db;
      private $plural_resource;
      public function __construct($db, $plural_resource){
           $this->db = $db;
           $this->plural_resource = $plural_resource;
      }

      public function index($email,$password) {
          $member = new member($this->plural_resource);
          $sql = $member->find_login_id($email,$password); 
          $members = mysqli_query($this->db,$sql) or die (mysqli_error($this->db));
          return $members;
      }

      public function  _new($member,$file){
          if(!empty($member)){
              $sql = new member($this->plural_resource);
              $sql = $sql->create($member,$file);
              mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
              header("Location: index");
          }
      }
      public function  show($id){
          $sql = new member($this->plural_resource);
          $sql = $sql->show($id);
          $member = mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
          return $member;
      }
  }
      



?>
