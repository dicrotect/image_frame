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
        $fileName = $_FILES['image']['name'];
        if (!empty($_FILES['image'])){
            $ext = substr($fileName, -3);
            if ($ext != 'jpg' && $ext != 'gif'&& $ext != 'png'){
                $error['image'] = 'type';
            }
        }

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
            var_dump($_SESSION);
            header('Location:create');
            exit();
        }        
    }
?>
<form action="" method="post" enctype="multipart/form-data">
  <input type="text" name="name">
  <input type="text" name="email">
  <input type="password" name="password">
  <input type="file" name="image">
  <input type="submit" value="Go">
</form>
