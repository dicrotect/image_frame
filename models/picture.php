<?php
    class picture {

        private $plural_resource = '';
        public function __construct($plural_resource) {
          $this->plural_resource = $plural_resource;
        }
        //写真の投稿
        public function create($picture,$title,$comment,$genre) {
            $sql = sprintf(
                'INSERT INTO %s SET member_id=%d, picture="%s", title="%s", comment="%s",genre_id="%d",created=NOW()',
                $this->plural_resource,
                $_SESSION['id'],
                $picture,
                $_POST['title'],
                $_POST['comment'],
                $_POST['genre']
            );
            return $sql;
        }
        //写真を新着順で表示
        public function index() {
            $sql ='SELECT * FROM pictures ORDER BY created DESC';
            return $sql;
        }
        //写真をの詳細ページを呼び出し
        public function show($id) {
            $sql =sprintf('SELECT * FROM %s WHERE id=%d',
                $this->plural_resource,
                $id
            );
            return $sql;
        }
        //ログインidの人が投稿した写真のみを表示
        public function index_id($id) {
            $sql =sprintf('SELECT * FROM %s WHERE member_id=%d ORDER BY created DESC',
                $this->plural_resource,
                $_SESSION['id']
            );
            return $sql;
        }
        // いいねがついた段階でデータベースのいいね数の合計を更新する
        public function update_likes($likes,$picture_id) {
            $sql =sprintf('UPDATE %s SET like_sum=%d WHERE id=%d',
                $this->plural_resource,
                $likes,
                $picture_id
            );
            return $sql;
        }
        // いいねの多い順に投稿を表示
        public function like_sort() {
            $sql ='SELECT * FROM pictures ORDER BY like_sum DESC' ;
            return $sql;
        }
        // 投稿した写真のコメントを編集する
        public function update($comment,$id) {
            $sql = sprintf('UPDATE %s SET comment="%s" WHERE id=%d',
                $this->plural_resource,
                $comment,
                $id
            ); 
            return $sql;           
        }
        // 投稿の削除
        public function delete($id) {
            $sql =sprintf('DELETE FROM %s WHERE id=%d',
                $this->plural_resource,
                $id
            );
            return $sql;
        }


    }
?>
