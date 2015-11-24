<?php
    session_start();
    $id = $_REQUEST['id'];
?>
<a href="new">一覧にもどる</a>
<?php
    $picturesController= new picturesController($db,$plural_resource);
    $pictures = $picturesController->show($id);
    $picture = mysqli_fetch_assoc($pictures);
    $picture_id = $picture['id'];
    echo '<p>'.$picture["title"].'</p>';
    echo sprintf('<img src="../pictures/%s" width="200" height ="200">',$picture['picture']);
?>

<?php if ($_SESSION['id'] == $picture['member_id']):?>
    <?php $_SESSION['picture_id'] = $id ?>
    <form action="update" method="post">
      <input type="text" name="edit_name" value="<?php echo $picture['comment']?>">
      <input type="submit" value="コメントを編集する">
    </form>
<?php
    echo sprintf('[<a href=../picture/delete?id=%d>delete</a>]',$picture["id"]);
?>
<?php else:?>
    <p><?php echo $picture['comment'];?></p>
<?php endif; ?>

<?php
    if(isset($picture['genre_id'])) {
        $genre_id = $picture["genre_id"];
        $id = intval($genre_id);
        $genresController = new picturesController($db,$plural_resource);
        $genres = $genresController->genre($genre_id);
        $genre = mysqli_fetch_assoc($genres);
        echo '<p>['.$genre['genre'].']</p>';

    }
    echo '<p>['.$picture['created'].']</p>';
    $likes = new picturesController($db,$plural_resource);
    $cnt = $likes->like($picture_id);
    if (isset($cnt)){
        $like_sum = mysqli_fetch_assoc($cnt);
        $likes = $like_sum['cnt'];
        echo $likes;
    }
    echo sprintf('[<a href=../like/update?id=%s>like</a>]',$picture["id"]);
?>
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


<?php
    $commentsController= new picturesController($db,$plural_resource);
    $comments = $commentsController->comment_index($picture_id);
    while($comment = mysqli_fetch_assoc($comments)) {
      //投稿者の名前を表示
      $member_id = $comment['member_id'];
      $membersController= new picturesController($db,$plural_resource);
      $member_names = $membersController->show_member_name($member_id);
      $member_name = mysqli_fetch_assoc($member_names);
      echo '<p>'.$member_name['name'].'</p>';
      //コメントを表示
      echo '<p>'.$comment['comment'].'</p>';
    }
?>

