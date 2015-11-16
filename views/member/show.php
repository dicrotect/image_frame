<?php
    $membersController = new membersController($db,$plural_resource,$action);
    $members = $membersController->show($id);
    $member = mysqli_fetch_assoc($members);
    var_dump($member);

?>
<ul>
  <li><?php echo $member["name"];?></li>
  <li><?php echo $member["email"];?></li>
  <?php 
      echo sprintf('<img src="../../pro_image/%s". width="100" height="100">',
      $member['image']);
  ?>
  <img src="../../pro_image/<?php echo $member["image"];?>" width="100" height="100">
</ul>
