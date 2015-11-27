<?php
    
    session_start();
    if (isset($_COOKIE['email']) && $_COOKIE['email'] != '') {
        $_POST['email'] = $_COOKIE['email'];
        $_POST['password'] = $_COOKIE['password'];
        $_POST['save'] = 'on';
    }


    if(!empty($_POST)) {
        if($_POST['email'] != '' && $_POST['password'] != '') {
            $membersController = new membersController($db,$plural_resource);
            $members = $membersController->index($_POST['email'],$_POST['password']);
            if ($member = mysqli_fetch_assoc($members)) {
                $_SESSION['id'] = $member['id'];
                $_SESSION['time'] = time(); 
                if ($_POST['save'] == 'on') {
                    setcookie('email', $_POST['email'], time()+60*60*24*14);
                    setcookie('password', $_POST['password'], time()+60*60*24*14);
                }
                header('Location: ../picture/new');
                exit();
            } else {
                $error['login'] = 'failed';
            } 
        } else {
            $error['login'] = 'blanck';
        }
    }
?>
<div class="container">
  <div class="card card-container">
    <p>&raquo;<a href="new">create new account</a></p>
      <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
    <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
    <p id="profile-name" class="profile-name-card"></p>
    <div>
    </div>
    <form action="" method="post" class="form-signin">
      <dl>
        <dt>E-mail</dt>
        <dd>
          <?php
              if (isset($_POST['email'])) {
                  echo sprintf('<input type="text" name="email" value="%s">',
                  $_POST["email"], ENT_QUOTES,'UTF-8'
                 );
              } else {
                  echo '<input type="text" name="email">';
              }
          ?>
          <?php if (isset($error["login"])): ?>
              <?php if($error["login"] == 'blanck'): ?>
                  <p class="error">*メールアドレスとパスワードを正しく入力してください。</p>
              <?php  endif; ?>    
              <?php if($error['login'] == 'failed'): ?>
                  <p class="error">*ログインに失敗しました、正しくご記入ください</p>
              <?php endif; ?>
          <?php endif; ?>
        </dd>
        <dt>Password</dt>
        <dd>
         <?php
              if (isset($_POST['password'])) {
                  echo sprintf('<input type="password" name="password" value="%s">',
                  $_POST["password"], ENT_QUOTES,'UTF-8'
                 );
              } else {
                  echo '<input type="password" name="password">';
              }
          ?>
        </dd>   
        <div id="remember" class="checkbox">
          <label>
            <input id="save" type="checkbox" name="save" value="on" > Always login
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block btn-signin"  type="submit">Let's Go!</button>
      </dl>
    </form>       
  </div><!-- /card-container -->
</div><!-- /container -->

