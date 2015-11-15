<?php
    session_start();
    if(!empty($_POST)){ 
        $membersController = new membersController($db,$plural_resource);
        $membersController->_new($_SESSION['member'],$_SESSION['image']);
    }

?>

<form action="" method ="post" >   
  <input type="hidden" name="action" value="submit /">
  <ui>
    <ul><?php echo $_SESSION['member']['name'];?></ul>
    <ul><?php echo $_SESSION['member']['email'];?></ul>
    <ul><?php echo $_SESSION['member']['password'];?></ul>
  </ui>
  <?php
      echo sprintf('<img src="../pro_image/%s". width="100" height="100">',
      $_SESSION['image']);
  ?>
  <br>
  <a href="index.php?action=rewrite">&laquo;&nbsp; 書き直す</a> 
  <input type="submit" value="登録する">
</form>
