<?php
    class picturesController {
        private $db;
        private $plural_resource;
        public function __construct($db, $plural_resource) {
             $this->db = $db;
             $this->plural_resource = $plural_resource;
        }

        public function member_show($id) {
            //membersControllersをつかって
            //picture内にクラスを作るためinclideで読み込む
            include('models/member.php');
            include('controllers/members_controller.php');
            $membersController = new membersController($this->db,'members');
            $members = $membersController->show($id);
            return $members;
        }
        public function genre($id) {
            include_once('models/genre.php');
            include_once('controllers/genres_controller.php');
            $genresController = new genresController($this->db,'genres');
            $genres = $genresController->show($id);
            return $genres;
        }
        public function like($picture_id) {
            include_once('models/like.php');
            include_once('controllers/likes_controller.php');
            $likesController = new likesController($this->db,'likes');
            $likes = $likesController->count($picture_id);
            return $likes;
        }

        public function comment_create($picture_id,$comment,$member_id) {
            include_once('models/comment.php');
            include_once('controllers/comments_controller.php');
            $commentsController = new commentsController($this->db,'cpmments');
            $comments = $commentsController->create($picture_id,$comment,$member_id);
            return $comments;
        }
        public function comment_index($picture_id) {
            include_once('models/comment.php');
            include_once('controllers/comments_controller.php');
            $commentsController = new commentsController($this->db,'comments');
            $comments = $commentsController->index($picture_id);
            return $comments;
        }
        public function show_member_name($member_id) {
            include_once('models/member.php');
            include_once('controllers/members_controller.php');
            $membersController = new membersController($this->db,'members');
            $members = $membersController->show_member_name($member_id);
            return $members;
        }
        public function create($picture,$title,$comment,$genre) {
            $sql = new picture($this->plural_resource);
            $sql = $sql->create($picture,$title,$comment,$genre);
            mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
        }
        public function index() {
            $sql = new picture($this->plural_resource);
            $sql = $sql->index();
            $pictures = mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
            return $pictures;
        }
        public function show($id) {
            $sql = new picture($this->plural_resource);
            $sql = $sql->show($id);
            $pictures = mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
            return $pictures;
        }
        public function index_id($id) {
            $sql = new picture($this->plural_resource);
            $sql = $sql->index_id($id);
            $pictures = mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
            return $pictures;
        }
        
        public function update_likes($likes,$picture_id) {
            $sql = new picture($this->plural_resource);
            $sql = $sql->update_likes($likes,$picture_id);
            $pictures = mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
            return $pictures;

        }
        public function like_sort() {
            $sql = new picture($this->plural_resource);
            $sql = $sql->like_sort();
            $pictures = mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
            return $pictures;
        }
        public function update($comment,$id) {
            $sql = new picture($this->plural_resource);
            $sql = $sql->update($comment,$id);
            $pictures = mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
            return $pictures;
        }
        public function  delete($id) {
            $sql = new picture($this->plural_resource);
            $sql = $sql->delete($id);
            $mpicture = mysqli_query($this->db, $sql) or die (mysqli_error($this->db));
            return $picture;
        }
    }    



?>
