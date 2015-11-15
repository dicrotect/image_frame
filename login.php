
<?php
//会員登録画面の作成
    session_start();
    function h($value){
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    
    //エラー処理 からの時を弾く
    if (!empty($_POST)) {
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


        //プロフィール写真のアップロード
        if (empty($error)) {
            if($fileName != "" ) {
                $image = $fileName;  
                move_uploaded_file($_FILES['image']['tmp_name'],'pro_image/'.$image);  
            }
        }
        if(empty($error)){
            $_SESSION['member'] = $_POST ;
            $_SESSION['image'] = $image;
            header('Location:check.php');
            exit();

        }
    }
    
       


?>

          <!-- Form Name -->
  
      <ui>        
        <!-- 名前の登録 -->
        
            <ul>
              <?php
                  if (isset($_POST["name"])) {
                      echo sprintf('<input type="text" name="name" value="%s" id="textinput" class="form-control input-md">',
                      h($_POST["name"]));
                  } else {
                      echo '<input id="textinput" name="name"  type="text">';
                  }
              ?>
            </ul>
            <?php if (isset($error['name'])): ?>
                <ul>名前が未入力です</ul>
            <?php endif; ?>
          
        <!-- メールアドレスの入力 -->  
            <ul>
                <?php
                  if (isset($_POST["email"])) {
                    echo sprintf('<input type="text" name="email" value="%s">',
                      h($_POST["name"]));
                  } else {
                      echo '<input type="text" name="email">';
                  }
                ?>        
            </ul>
            <?php if (isset($error['password'])): ?>
              <ul>メールアドレスが入力されていません</ul>
            <?php endif; ?>
         
        <!-- パスワードの入力 -->
            
            <ul>
                <?php
                  if (isset($_POST["password"])) {
                      echo sprintf('<input type="password" name="password" value="%s">',
                      h($_POST["name"]));
                  } else {
                      echo '<input type="password" name="password">';
                  }
                ?>
            </ul>
            <?php if (isset($error['password'])): ?>
                <ul>パスワードが入力されていません</ul>
            <?php endif; ?>
          
        <!-- プロフィールの登録 -->
                          
            <ul><textarea id="textarea" name="profile">comments</textarea></ul>
            <?php if (isset($error['profile'])): ?>
                <ul>プロフィール画像を登録しましょう</ul>
            <?php endif; ?>     
          
        
        <!-- 画像送信 -->
            <ul>
                <?php
                  if (isset($_POST["image"])) {
                      echo sprintf('<input type="file" name="image" value="%s">',
                      h($_POST["image"]));
                  } else {
                      echo '<input type="file" name="image">';
                  }
                ?>            
            </ul>
            <?php if (isset($error['image'])): ?>
                <ul>プロフィール画像を登録しましょう</ul>
            <?php endif; ?>
          
      <!-- 送信ボタン -->
          <ul><button type="submit"  value='push' >PUSH</button></ul>
      
    </ui>
</form>
 
  </body>
</html>
