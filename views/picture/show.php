<?php
    session_start();
    //写真のidを取得
    $id = $_REQUEST['id'];
?>
<a href="new">一覧にもどる</a>
<div class="container">
  <div class="row">
    <div class="col-lg-6 col-sm-6">
      <div class="show_page">
        <!-- 画像投稿の表示 -->
        <?php
            $picturesController= new picturesController($db,$plural_resource);
            $pictures = $picturesController->show($id);
            $picture = mysqli_fetch_assoc($pictures);
            $picture_id = $picture['id'];
            echo '<h3>'.$picture["title"].'</h3>';
            echo sprintf('<img src="../pictures/%s" width="200" height ="200">',$picture['picture']);
        ?>
        <!-- ログインユーザーが自分の投稿を参照した際にコメントの編集ができるようにする -->
        <div class='show_contents'>
          <?php if ($_SESSION['id'] == $picture['member_id']):?>
            <?php $_SESSION['picture_id'] = $id ?>
            <form action="update" method="post">
              <input type="text" name="edit_name" value="<?php echo $picture['comment']?>">
              <input type="submit" value="コメントを編集する">
            </form>
            <!-- 投稿の削除 -->
            <?php echo '<p><input type="button" value="投稿を削除" onClick="disp()"></p>';?>
          <?php else:?>
            <p><?php echo $picture['comment'];?></p>
          <?php endif; ?>
        </div>
        <?php
            //ジャンルの表示
            // if(isset($picture['genre_id'])) {
            //     $genre_id = $picture["genre_id"];
            //     $id = intval($genre_id);
            //     $genresController = new picturesController($db,$plural_resource);
            //     $genres = $genresController->genre($genre_id);
            //     $genre = mysqli_fetch_assoc($genres);
            //     echo '<p>['.$genre['genre'].']</p>';

            // }
            echo '<p>['.$picture['created'].']</p>';
            $likes = new picturesController($db,$plural_resource);
            $cnt = $likes->like($picture_id);
            if (isset($cnt)){
                $like_sum = mysqli_fetch_assoc($cnt);
                $likes = $like_sum['cnt'];
                echo $likes;
            }
            echo sprintf('[<a href=../like/create?id=%s>like</a>]',$picture["id"]);
        ?>
      </div>
    </div>
  </div>
</div> 
<!-- コメントの投稿 -->
<p>コメントを投稿しよう</p>
<form action="" method="post">
  <input type="text" name="comment">
  <input type="submit" name="post_comment">
</form>
<?php
    if (isset($_POST['post_comment'])){
        $comment = $_POST['comment'];
        $member_id = $_SESSION['id'];
        $commentsController= new picturesController($db,$plural_resource);
        $comments = $commentsController->comment_create($picture_id,$comment,$member_id);
    }
?>
<!-- コメントの表示 -->
<div class="container">
  <div class="qa-message-list" id="wallmessages">
    <div class="message-item" id="m16">
      <div class="message-inner">
        <?php
          $commentsController= new picturesController($db,$plural_resource);
          $comments = $commentsController->comment_index($picture_id);
          while($comment = mysqli_fetch_assoc($comments)) {
            $member_id = $comment['member_id'];
            $membersController= new picturesController($db,$plural_resource);
            $member_names = $membersController->show_member_name($member_id);
            $member_name = mysqli_fetch_assoc($member_names);
        ?> 
            <div class="message-head clearfix">
              <div class="message-icon pull-left"><a href="#"><i class="glyphicon glyphicon-check"></i></a></div>
              <div class="user-detail">
                <h5 class="handle"><?php echo '<p>'.$member_name['name'].'</p>';?></h5>
                <div class="qa-message-content">
                  <p><?php echo '<p>'.$comment['comment'].'</p>';?></p>
                </div>           
              </div>
            </div>
        <?php } ?>
      </div>   
    </div>    
  </div>
</div>

