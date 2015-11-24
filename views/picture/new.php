<?php
    session_start();
    if (isset($_SESSION['id'])) {
        $id = $_SESSION['id'];
        //ログインした会員情報を呼び出すオブジェクトを生成
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
                    }
                }
            }
        }
    } else {
        header('Location:../member/index');
        exit;
    }
?>
[<a href="../member/logout">ログアウトする</a>]
<?php
    //プロフィール情報の表示
    if (isset($_SESSION['id'])) {
        echo '<p>'.$member['name'].'</p>';
        echo sprintf('<img src="../pro_image/%s" width="100" height ="100">',$member['image']);
    }  
?>

<form action="" method="post" enctype="multipart/form-data">
  <p>写真を登録しよう</p>
  <input type="file" name="picture">
  <p>タイトル</p>
  <input type="text" name="title">
  <p>ジャンルを選択します。</p>
  <select name="genre">
    <option value="">選択しない</option>
    <option value="1">旅行</option>
    <option value="2">料理</option>
    <option value="3">おもしろ</option>
    <option value="4">趣味</option>
  </select>
  <p>コメント</p>
  <input type="text" name="comment">
  <input type="submit" name='post'>
</form>

<h2>表示の仕方を選択できます</h2>
<form action="" method="post">
  <input type="submit" name="like" value='likeの多い順'>
  <input type="submit" name="time" value='投稿の早い順'>
  <input type="submit" name="mypost" value='自分の投稿のみ'>
</form>
<?php
    //いいねが多い順
    if (isset($_POST['like'])) {
        $picturesController= new picturesController($db,$plural_resource);
        $pictures = $picturesController->like_sort();
        while ($picture = mysqli_fetch_assoc($pictures)) {
            //投稿者の名前を表示
            $member_id = $picture['member_id'];
            $picturesController= new picturesController($db,$plural_resource);
            $member_names = $membersController->show_member_name($member_id);
            $member_name = mysqli_fetch_assoc($member_names);
            echo '<p>'.$member_name['name'].'</p>';
            //投稿情報を表示
            $picture_id = $picture['id'];
            echo '<p>'.$picture["title"].'</p>';
            echo sprintf('<img src="../pictures/%s" width="100" height ="100">',$picture['picture']);
            echo '<p>'.$picture["comment"].'</p>';
            echo '<p>'.$picture["created"].'</p>';
            if(isset($picture['genre_id'])) {
                $genre_id = $picture["genre_id"];
                $id = intval($genre_id);
                $genresController = new picturesController($db,$plural_resource);
                $genres = $genresController->genre($genre_id);
                $genre = mysqli_fetch_assoc($genres);
                echo '<p>'.$genre['genre'].'</p>';
            }
            echo sprintf('[<a href=show?id=%s>show</a>]',$picture["id"]);
            //いいね数の表示
            $likes = new picturesController($db,$plural_resource);
            $cnt = $likes->like($picture_id);
            if (isset($cnt)){
                $like_sum = mysqli_fetch_assoc($cnt);
                $likes = $like_sum['cnt'];
                echo $likes;
                $picturesController = new picturesController($db,$plural_resource);
                $update_like = $picturesController->update_likes($likes,$picture_id);
            }
            echo sprintf('[<a href=../like/create?id=%s>like</a>]',$picture["id"]);
        }
    } elseif (isset($_POST['time']) || empty($_POST)) {
        //新着順
        $picturesController= new picturesController($db,$plural_resource);
        $pictures = $picturesController->index();
            
        while ($picture = mysqli_fetch_assoc($pictures)) {
            //投稿者の名前を表示
            $member_id = $picture['member_id'];
            $picturesController= new picturesController($db,$plural_resource);
            $member_names = $membersController->show_member_name($member_id);
            $member_name = mysqli_fetch_assoc($member_names);
            echo '<p>'.$member_name['name'].'</p>';
            //投稿情報を表示
            $picture_id = $picture['id'];
            echo '<p>'.$picture["title"].'</p>';
            echo sprintf('<img src="../pictures/%s" width="100" height ="100">',$picture['picture']);
            echo '<p>'.$picture["comment"].'</p>';
            echo '<p>'.$picture["created"].'</p>';
            if(isset($picture['genre_id'])) {
                $genre_id = $picture["genre_id"];
                $id = intval($genre_id);
                $genresController = new picturesController($db,$plural_resource);
                $genres = $genresController->genre($genre_id);
                $genre = mysqli_fetch_assoc($genres);
                echo '<p>'.$genre['genre'].'</p>';
            }
            echo sprintf('[<a href=show?id=%s>show</a>]',$picture["id"]);
            //いいねの数の表示
            $likes = new picturesController($db,$plural_resource);
            $cnt = $likes->like($picture_id);
            if (isset($cnt)){
                $like_sum = mysqli_fetch_assoc($cnt);
                $likes = $like_sum['cnt'];
                echo $likes;
                $picturesController = new picturesController($db,$plural_resource);
                $update_like = $picturesController->update_likes($likes,$picture_id);
            }
            echo sprintf('[<a href=../like/create?id=%s>like</a>]',$picture["id"]);
        }
    }
?>

<?php
    //自分の投稿のみ表示
    if (isset($_SESSION['id']) || isset($_POST['mypost'])) {
        $picturesController= new picturesController($db,$plural_resource);
        $pictures = $picturesController->index_id($_SESSION['id']);
        while ($id_picture = mysqli_fetch_assoc($pictures)) {
            echo '<p>'.$id_picture["title"].'</p>';
            echo sprintf('<img src="../pictures/%s" width="100" height ="100">',$id_picture['picture']);
            echo '<p>'.$id_picture["comment"].'</p>';
            echo '<p>'.$id_picture["created"].'</p>';
            echo '<p>'.$id_picture["like_sum"].'</p>';

            if(isset($id_picture['genre_id'])) {
                $genre_id = $id_picture["genre_id"];
                $id = intval($genre_id);
                $genresController = new picturesController($db,$plural_resource);
                $genres = $genresController->genre($genre_id);
                $genre = mysqli_fetch_assoc($genres);
                echo '<p>'.$genre['genre'].'</p>';
                echo sprintf('[<a href=show?id=%d>show</a>]',$id_picture["id"]);
            }
        }
    }
?>



