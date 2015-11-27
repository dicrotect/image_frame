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

<div class="container">
  <div class="row">
    <div class="form-box">
      <h1>PICTURES GERDEN</h1>
      <form role="form" id="contact-form" action="" method="post" enctype="multipart/form-data">
                <!-- name field -->
        <div class="form-group">
          <div id="nameError" class="alert" role="alert"></div>
          <label for="form-name-field" class="sr-only">Name</label>
            <div class="input-group">
                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                <?php
                    if (isset($_POST["name"])) {
                        echo sprintf('<input type="text" name="name" value="%s" class="form-control" id="form-name-field">',
                            $_POST["name"]
                        );
                        if (isset($error['name'])) {
                            echo '<p> ニックネームを登録してください</p>';   
                        }
                    } else {
                        echo '<input name="name"type="text" class="form-control" id="form-name-field">';
                    }
                ?>
            </div>
        </div>
        <!-- email field -->
        <div class="form-group">
        <div id="emailError" class="alert" role="alert"></div>
        <label for="form-email-field" class="sr-only">Email</label>
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
            <?php
                if (isset($_POST["email"])) {
                    echo sprintf('<input type="text" name="email" value="%s" class="form-control" id="form-email-field">',
                        $_POST["email"]
                    );
                    if (isset($error['email'])) {
                        echo '<p>emailを登録してください</p>';   
                    }
                } else {
                    echo '<input type="text" name="email" class="form-control" id="form-email-field">';
                }
            ?>
         </div>
        </div>
        <!-- password field -->
        <div class="form-group">
        <div id="passwordError" class="alert" role="alert"></div>
        <label for="form-password-field" class="sr-only">password</label>
        <div class="input-group">
          <div class="input-group-addon"><span class="glyphicon fa fa-key"></span></div>
            <?php
                if (isset($_POST["password"])) {
                    echo sprintf('<input type="password" name="password" value="%s" class="form-control" id="form-password-field">',
                        $_POST["password"]
                    );
                    if (isset($error['password'])) {
                        echo '<p>passwordを登録してください</p>';   
                    }
                } else {
                    echo '<input type="password" name="password" class="form-control" id="form-password-field">';
                }
            ?>
         </div>
        </div>
        <div class="form-group">
        <div id="imageError" class="alert" role="alert"></div>
        <div class="input-group">
        <div class="input-group-addon"><span class="glyphicon fa fa-picture-o"></span></div>
            <?php
                if (isset($_FILES["image"])) {
                    echo'<input type="file" name="image" class="form-control" id="form-image-field">';
                    echo'<p>プロフィール画像を登録してください</p>';
                } else {
                    echo '<input type="file" name="image" class="form-control" id="form-image-field">';
                }
            ?>
         </div>
        </div>
        <button type="submit" class="btn btn-default">GO</button>
      </form>   
    </div>
  </div>
</div>








