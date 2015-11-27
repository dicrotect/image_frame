<?php
    session_start();
    if(!empty($_POST)){ 
        $membersController = new membersController($db,$plural_resource);
        $membersController->_new($_SESSION['member'],$_SESSION['image']);
    }

?>
<!-- ユーザー登録情報の確認 -->
<div class="container" role="main">
  <div class="jumbotron">
    <h3>登録情報の確認をしましょう</h3>
    <br>
    <div>
      <p>アイコン画像</p>
      <?php
          echo sprintf('<img src="../pro_image/%s". width="200" height="200">',
          $_SESSION['image']);
      ?>
      </div>
    <div class="form_check">
      <form action="" method ="post" >   
        <input type="hidden" name="action" value="submit /">
          <h3>ニックネーム</h3>
          <h3><?php echo $_SESSION['member']['name'];?></h3>
          <h3>登録メールアドレス</h3>
          <h3><?php echo $_SESSION['member']['email'];?></h3>
          <h3>passwordは表示されません</h3>
        <br>
        <a href="new?action=rewrite">&laquo;&nbsp; 書き直す</a> 
        <input type="submit" value="登録する">
      </form>  
    </div>
  </div>
</div>

