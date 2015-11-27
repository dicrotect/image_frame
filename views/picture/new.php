<?php
    session_start();
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        //ログインユーザの情報を取得
        $membersController = new picturesController($db, $plural_resource);
        $member_show = $membersController->member_show($id);
        $member = mysqli_fetch_assoc($member_show);
        if (!empty($_POST['post']) && !empty($_FILES)) {
            if (!empty($_POST)) {
                $fileName = $_FILES['picture']['name'];
                if (!empty($_FILES['picture'])) {
                      $ext = substr($fileName, -3);
                      if ($ext != 'jpg' && $ext != 'gif'&& $ext != 'png'){
                          $error['picture'] = 'type';
                      }
                     //プロフィール写真のアップロード
                    if (empty($error)) {
                        if($fileName != "" ) {
                            $picture = $fileName;  
                            move_uploaded_file($_FILES['picture']['tmp_name'],'pictures/'.$picture);
                        }
                        //DBへ投稿情報をINSERTするオブジェクトを生成
                        $picturesController = new picturesController($db,$plural_resource);
                        $picturesController->create($picture,$_POST['title'],$_POST['comment'],intval($_POST['genre']));   
                        header('Location:new');
                    }
                }
            }
        }
    } else {
        header('Location:../member/index');
        exit;
    }
?>
<!-- プロフィールのプロフィールの表示 -->
<div class="container">
  <div class="row">
    <div class="profile-header-container">   
      <div class="profile-header-img">
        <?php echo sprintf('<img src="../pro_image/%s" width="100" height ="100" class="img-circle">',$member['image']);?>
        <!-- badge -->
        <div class="rank-label-container">
            <span class="label label-default rank-label"><?php echo$member['name'];?></span>
        </div>
        [<a href="../member/logout">ログアウトする</a>]
      </div>
    </div> 
  </div>
</div>
<!-- 画像投稿フォーム -->
<div class="container">
  <div class="row centered-form" style="margin-top: 0px;">
    <div class="col-xs-12 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Please post your picture</h3>
        </div>
        <div class="panel-body">
          <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <input type="text" name="title" id="text" class="form-control input-sm" placeholder="title">
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <select name="genre" id="genre" class="form-control input-sm" placeholder="Segundo Nome">
                    <option value="">ジャンルを選択</option>
                    <option value="1">旅行</option>
                    <option value="2">料理</option>
                    <option value="3">おもしろ</option>
                    <option value="4">趣味</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <input type="text" name="comment" id="comment" class="form-control input-sm" placeholder="please write comment">
            </div>
            <div class="row">
              <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                  <input type="file" name="picture" >
                </div>
              </div>
            </div> 
            <input type="submit" name="post" value="post" class="btn btn-info btn-block">   
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- 表示順変更タグ -->
<form action="" method="post">
  <div class="tab">
    <i class="fa fa-search-minus"></i>表示を並べ替えよう<i class="fa fa-search-minus"></i>
    <span><button type="submit" name="time" ><i class="fa fa-tachometer"></i></button>新着順</span>
    <span><button type="submit" name="like"  ><i class="fa fa-thumbs-o-up"></i></button>お気に入りの多い順</span>
    <span><button type="submit" name="mypost"><i class="fa fa-user"></i></button>自分の投稿のみ</span>
  </div>
</form>
    
<!-- 画像の表示 -->
<?php
    //いいねが多い順
    if (isset($_POST['like'])) {
        $picturesController= new picturesController($db,$plural_resource);
        $pictures = $picturesController->like_sort();
?>
  <div id="wrapper">
    <span id="columns"> 
      <?php while ($picture = mysqli_fetch_assoc($pictures)) { ?>
        <span class="pin">  
          <?php
            $member_id = $picture['member_id'];
            $picturesController= new picturesController($db,$plural_resource);
            $member_names = $membersController->show_member_name($member_id);
            $member_name = mysqli_fetch_assoc($member_names);
            echo '<p>'.$member_name['name'].'さんの写真</p>';
            //投稿情報を表示
            $picture_id = $picture['id'];

            echo '<p>'.$picture["title"].'</p>';
            echo sprintf('<img src="../pictures/%s" width="50" height ="150">',$picture['picture']);
            echo '<p>'.$picture["comment"].'</p>';
            echo '<p>'.$picture["created"].'</p>';
            // ジャンルの表示
            // if(isset($picture['genre_id'])) {
            //   $genre_id = $picture["genre_id"];
            //   $id = intval($genre_id);
            //   $genresController = new picturesController($db,$plural_resource);
            //   $genres = $genresController->genre($genre_id);
            //   $genre = mysqli_fetch_assoc($genres);
            //   echo '<p>ジャンル'.$genre['genre'].'</p>';
            // }
            //いいね数の表示
            $likes = new picturesController($db,$plural_resource);
            $cnt = $likes->like($picture_id);
            echo sprintf('<a href=../like/create?id=%s><i class="fa fa-thumbs-up"></i></a>',$picture["id"]);
            echo sprintf('[<a href=show?id=%s>show</a>]',$picture["id"]);
            if (isset($cnt)){
              $like_sum = mysqli_fetch_assoc($cnt);
              $likes = $like_sum['cnt'];
              echo '['.$likes.' likes] ';
              $picturesController = new picturesController($db,$plural_resource);
              $update_like = $picturesController->update_likes($likes,$picture_id);
            }
          ?>
        </span>
      <?php } ?>
    </span>
  </div>

<!-- 新着順に表示 -->
<?php 
    } elseif (isset($_POST['time']) || empty($_POST)) {
    $picturesController= new picturesController($db,$plural_resource);
    $pictures = $picturesController->index();
?>          
  <div id="wrapper">
    <span id="columns">
      <?php while ($picture = mysqli_fetch_assoc($pictures)) { ?>
        <span class="pin">   
        <?php    
            $member_id = $picture['member_id'];
            $picturesController= new picturesController($db,$plural_resource);
            $member_names = $membersController->show_member_name($member_id);
            $member_name = mysqli_fetch_assoc($member_names);
            echo '<p>'.$member_name['name'].'さんの写真</p>';
            //投稿情報を表示
            $picture_id = $picture['id'];
            echo '<p>'.$picture["title"].'</p>';
            echo sprintf('<img src="../pictures/%s" width="50" height ="150">',$picture['picture']);
            echo '<p>'.$picture["comment"].'</p>';
            echo '<p>'.$picture["created"].'</p>';
            //ジャンルの表示
            // if(isset($picture['genre_id'])) {
            //     $genre_id = $picture["genre_id"];
            //     $id = intval($genre_id);
            //     $genresController = new picturesController($db,$plural_resource);
            //     $genres = $genresController->genre($genre_id);
            //     $genre = mysqli_fetch_assoc($genres);
            //     echo '<p>'.$genre['genre'].'</p>';
            // }
            echo sprintf('[<a href=show?id=%s>show</a>]',$picture["id"]);
            //いいねの数の表示
            echo sprintf('<a href=../like/create?id=%s><i class="fa fa-thumbs-up"></i></a>',$picture["id"]);
            $likes = new picturesController($db,$plural_resource);
            $cnt = $likes->like($picture_id);
            if (isset($cnt)){
                $like_sum = mysqli_fetch_assoc($cnt);
                $likes = $like_sum['cnt'];
                echo '['.$likes.' likes] ';
                $picturesController = new picturesController($db,$plural_resource);
                $update_like = $picturesController->update_likes($likes,$picture_id);
            }
        ?>
        </span>
      <?php } ?>
    </span>
  </div>
<?php } ?>

<?php
    //自分の投稿のみ表示
    if (isset($_POST['mypost'])) {
        $picturesController= new picturesController($db,$plural_resource);
        $pictures = $picturesController->index_id($_SESSION['id']);
?>
  <div id="wrapper">
    <span id="columns">
      <?php while ($id_picture = mysqli_fetch_assoc($pictures)) { ?>
        <span class="pin"> 
          <?php
              echo '<p>'.$id_picture["title"].'</p>';
              echo sprintf('<img src="../pictures/%s" width="50" height ="150">',$id_picture['picture']);
              echo '<p>'.$id_picture["comment"].'</p>';
              echo '<p>'.$id_picture["created"].'</p>';
              //ジャンルの表示
              // if(isset($id_picture['genre_id'])) {
              //     $genre_id = $id_picture["genre_id"];
              //     $id = intval($genre_id);
              //     $genresController = new picturesController($db,$plural_resource);
              //     $genres = $genresController->genre($genre_id);
              //     $genre = mysqli_fetch_assoc($genres);
              //     echo '<p>'.$genre['genre'].'</p>';
                     echo sprintf('[<a href=show?id=%d>show</a>]',$id_picture["id"]);
              // }
              $picture_id = $id_picture['id'];
              $likes = new picturesController($db,$plural_resource);
              $cnt = $likes->like($picture_id);
              if (isset($cnt)){
                  $like_sum = mysqli_fetch_assoc($cnt);
                  $likes = $like_sum['cnt'];
                  echo '['.$likes.' likes] ';
                  $picturesController = new picturesController($db,$plural_resource);
                  $update_like = $picturesController->update_likes($likes,$picture_id);
              }
          ?>
        </span> 
      <?php } ?>
    </span>
  </div>
<?php } ?>









