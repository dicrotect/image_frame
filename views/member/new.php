<?php
    session_start();
    if(!empty($_POST)){

        if ($_POST['name'] == ""){
            $error['name'] = "blanck";
        }  
        if ($_POST['email'] == ""){
            $error['email'] = "blanck";
        }  
        if ($_POST['password'] == ""){
            $error['password'] = "blanck";
        }  
        //ファイルのエラー判定
        
        if (!empty($_POST)){
            $fileName = $_FILES['image']['name'];
            if (!empty($_FILES['image'])){
                $ext = substr($fileName, -3);
                if ($ext != 'jpg' && $ext != 'gif'&& $ext != 'png'){
                    $error['image'] = 'type';
                }
            }
            //プロフィール写真のアップロード
            if (empty($error)) {
                if($fileName != "" ) {
                    $image = $fileName;  
                    move_uploaded_file($_FILES['image']['tmp_name'],'pro_image/'.$image);  
                }
            }
        }
        if (empty($error)) {
            $_SESSION['image'] = $image;
            $_SESSION['member']['name'] = $_POST['name'];
            $_SESSION['member']['email'] = $_POST['email'];
            $_SESSION['member']['password'] = $_POST['password'];

            var_dump($_SESSION);
            header('Location:create');
            exit();
        }        
    }
?>

    <form action="" method="post" enctype="multipart/form-data">
    <ul>
      <p>ニックネーム</p>
      <li>
        <?php
            if (isset($_POST["name"])) {
                echo sprintf('<input type="text" name="name" value="%s">',
                    $_POST["name"]
                );
                if (isset($error['name'])) {
                    echo '<p> ニックネームを登録してください</p>';   
                }
            } else {
                echo '<input name="name"type="text">';
            }
        ?>
      </li>
      <p>email</p>
      <li>
        <?php
            if (isset($_POST["email"])) {
                echo sprintf('<input type="text" name="email" value="%s">',
                    $_POST["email"]
                );
                if (isset($error['email'])) {
                    echo '<p>emailを登録してください</p>';   
                }
            } else {
                echo '<input type="text" name="email">';
            }
        ?>
      </li>
      <p>password</p>
      <li>
        <?php
            if (isset($_POST["password"])) {
                echo sprintf('<input type="password" name="password" value="%s">',
                    $_POST["password"]
                );
                if (isset($error['password'])) {
                    echo '<p>passwordを登録してください</p>';   
                }
            } else {
                echo '<input type="password" name="password">';
            }
        ?>
      </li>
      <p>画像を登録しよう</p>
      <li>
      <?php
          if (isset($_FILES["image"])) {
              echo'<input type="file" name="image">';
              echo'<p>プロフィール画像を登録してください</p>';
          } else {
              echo '<input type="file" name="image">';
          }
      ?>
      </li>
      <li><input type="submit" value="Go"></li>
    </ul>
    </form>
