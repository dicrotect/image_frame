<?php
  class likes {
      
      private $plural_resource = '';
      public function __construct($plural_resource) {
          $this->plural_resource = $plural_resource;
      }

      // 投稿にいいねをつける
      public function create($picture_id,$member_id){
        $sql = sprintf('INSERT INTO %s SET picture_id=%d, member_id=%d',
            $this->plural_resource,
            $picture_id,
            $member_id
        );
        return $sql;
      }
      //投稿にいくついいねがついたかカウント
      public function count($picture_id){
          $sql = sprintf('SELECT COUNT(*) AS cnt from %s WHERE picture_id=%d',
              $this->plural_resource,
              $picture_id
          );
          return $sql;
      }
  }

?>
